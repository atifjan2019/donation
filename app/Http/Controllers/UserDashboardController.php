<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserDashboardController extends Controller
{
    public function overview(Request $request): JsonResponse
    {
        $user = $request->user();
        $yearStart = now()->startOfYear();

        return response()->json([
            'total_donated_lifetime' => $user->donations()->where('status', 'completed')->sum('amount'),
            'total_donated_this_year' => $user->donations()->where('status', 'completed')->where('created_at', '>=', $yearStart)->sum('amount'),
            'donation_count' => $user->donations()->count(),
            'active_recurring_count' => $user->recurringDonations()->where('status', 'active')->count(),
        ]);
    }

    public function history(Request $request): JsonResponse
    {
        $query = $request->user()->donations()->with('campaign:id,title,slug');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->date('to'));
        }
        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->integer('campaign_id'));
        }
        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->integer('min_amount'));
        }
        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->integer('max_amount'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return response()->json($query->latest()->paginate(20));
    }

    public function recurring(Request $request): JsonResponse
    {
        return response()->json(
            $request->user()->recurringDonations()->with('campaign:id,title,slug')->latest()->paginate(20)
        );
    }

    public function updateRecurringStatus(Request $request, int $recurringDonationId): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,paused,cancelled'],
        ]);

        $subscription = $request->user()->recurringDonations()->findOrFail($recurringDonationId);
        $subscription->update(['status' => $data['status']]);

        return response()->json([
            'message' => 'Recurring donation status updated.',
            'recurring_donation' => $subscription,
        ]);
    }

    public function receipts(Request $request): JsonResponse
    {
        $receipts = Receipt::query()
            ->whereHas('donation', fn ($q) => $q->where('user_id', $request->user()->id))
            ->with('donation:id,amount,currency,created_at,status,campaign_id')
            ->latest()
            ->paginate(20);

        return response()->json($receipts);
    }

    public function yearlyReceiptBundle(Request $request, int $year): BinaryFileResponse
    {
        $donations = Donation::query()
            ->where('user_id', $request->user()->id)
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->with('campaign:id,title')
            ->get();

        $pdf = Pdf::loadView('pdf.yearly-receipts', [
            'year' => $year,
            'donations' => $donations,
            'user' => $request->user(),
        ]);

        $dir = storage_path('app/private/receipts');
        File::ensureDirectoryExists($dir);

        $path = $dir.'/yearly-'.$request->user()->id.'-'.$year.'.pdf';
        $pdf->save($path);

        return response()->download($path);
    }
}
