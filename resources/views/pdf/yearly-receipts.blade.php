<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yearly Donation Receipt Summary</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; }
        h1 { margin-bottom: 4px; }
        .meta { margin-bottom: 20px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .total { margin-top: 16px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Donation Summary {{ $year }}</h1>
    <div class="meta">
        <div>Donor: {{ $user->name }}</div>
        <div>Email: {{ $user->email }}</div>
        <div>Generated: {{ now()->toDateTimeString() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Campaign</th>
                <th>Amount (minor units)</th>
                <th>Currency</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse($donations as $donation)
            <tr>
                <td>{{ $donation->created_at?->toDateString() }}</td>
                <td>{{ $donation->campaign?->title ?? 'General Donation' }}</td>
                <td>{{ $donation->amount }}</td>
                <td>{{ $donation->currency }}</td>
                <td>{{ $donation->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No donations found for this year.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="total">
        Total: {{ $donations->sum('amount') }}
    </div>
</body>
</html>
