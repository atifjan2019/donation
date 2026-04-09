<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #1f2937; margin: 0; padding: 20px; font-size: 13px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 3px solid #DB7C1C; padding-bottom: 15px; }
        .header h1 { font-size: 22px; margin: 0; color: #DB7C1C; }
        .header p { margin: 2px 0; font-size: 12px; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        thead th { background: #1f2937; color: #fff; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; }
        tbody td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; font-size: 12px; }
        tbody tr:nth-child(even) td { background: #f9fafb; }
        .total { margin-top: 20px; text-align: right; font-size: 16px; color: #DB7C1C; font-weight: bold; }
        .footer { margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 10px; font-size: 10px; color: #9ca3af; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>DonateHeart</h1>
            <p>Yearly Tax Receipt — {{ $year }}</p>
        </div>
        <div style="text-align: right">
            <p><strong>{{ $user->name }}</strong></p>
            <p>{{ $user->email }}</p>
        </div>
    </div>

    <p>Below is a summary of your completed donations for the tax year <strong>{{ $year }}</strong>.</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Campaign</th>
                <th style="text-align: right">Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $d)
                <tr>
                    <td>{{ $d->created_at->format('M d, Y') }}</td>
                    <td>{{ $d->campaign?->title ?? 'General Fund' }}</td>
                    <td style="text-align: right">${{ number_format($d->amount / 100, 2) }}</td>
                    <td>{{ ucfirst($d->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center; padding: 20px;">No donations found for {{ $year }}.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="total">Total: ${{ number_format($donations->sum('amount') / 100, 2) }}</p>

    <div class="footer">
        DonateHeart &mdash; This document was automatically generated. For questions, contact support.<br>
        Generated on {{ now()->format('F d, Y \a\t g:i A') }}
    </div>
</body>
</html>
