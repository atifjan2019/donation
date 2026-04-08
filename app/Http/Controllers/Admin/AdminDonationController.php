<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminDonationController extends Controller
{
    public function index(Request $request): JsonResponse|StreamedResponse
    {
        activity()
            ->causedBy($request->user())
            ->event('admin.donations.listed')
            ->log('Admin viewed donations list');

        $query = Donation::query()->with(['campaign:id,title,slug', 'user:id,name,email']);

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->date('to'));
        }
        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->integer('campaign_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->string('payment_method'));
        }
        if ($request->filled('donor')) {
            $donor = $request->string('donor');
            $query->where(function ($inner) use ($donor) {
                $inner->where('donor_name', 'like', "%{$donor}%")
                    ->orWhere('donor_email', 'like', "%{$donor}%");
            });
        }

        if ($request->string('export') === 'csv') {
            return response()->streamDownload(function () use ($query) {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['id', 'date', 'amount', 'currency', 'status', 'type', 'donor_name', 'donor_email', 'campaign']);
                $query->orderByDesc('id')->chunk(500, function ($rows) use ($out) {
                    foreach ($rows as $row) {
                        fputcsv($out, [
                            $row->id,
                            $row->created_at,
                            $row->amount,
                            $row->currency,
                            $row->status,
                            $row->type,
                            $row->donor_name,
                            $row->donor_email,
                            $row->campaign?->title,
                        ]);
                    }
                });
                fclose($out);
            }, 'donations-export.csv', ['Content-Type' => 'text/csv']);
        }

        return response()->json($query->latest()->paginate(25));
    }

    public function show(Donation $donation): JsonResponse
    {
        activity()
            ->performedOn($donation)
            ->event('admin.donations.viewed')
            ->log('Admin viewed donation detail');

        return response()->json($donation->load(['campaign', 'user', 'receipt']));
    }

    public function refund(Request $request, Donation $donation): JsonResponse
    {
        if ($donation->status !== 'completed') {
            abort(422, 'Only completed donations can be marked refunded.');
        }

        $donation->update([
            'status' => 'refunded',
        ]);

        activity()
            ->causedBy($request->user())
            ->performedOn($donation)
            ->event('admin.donations.refunded')
            ->log('Admin marked donation as refunded');

        return response()->json([
            'message' => 'Donation marked as refunded.',
            'donation' => $donation,
        ]);
    }
}
