<x-layouts.public>
    <x-slot:title>Make a Donation — DonateHeart</x-slot:title>

    <div class="container py-5 animate-fade-up" style="max-width:640px">
        <a href="{{ route('campaigns.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-4">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to campaigns
        </a>

        <div class="card overflow-hidden shadow">
            {{-- Header --}}
            <div class="hero-gradient p-4 p-md-5 position-relative overflow-hidden">
                <div class="hero-pattern"></div>
                <div class="hero-orb" style="width:160px;height:160px;top:-40px;right:-40px;background:rgba(255,255,255,0.05)"></div>
                <div class="d-flex align-items-center gap-3 position-relative" style="z-index:2">
                    <div class="d-flex align-items-center justify-content-center rounded-4" style="width:48px;height:48px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.1)">
                        <svg width="24" height="24" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <div>
                        <h1 class="font-display fw-bold text-white fs-4 mb-0">Make a Donation</h1>
                        <p class="mb-0 small" style="color:rgba(255,255,255,0.55)">Your generosity creates real change in the world.</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                @if($campaign)
                    <div class="rounded-4 p-3 mb-4" style="background:linear-gradient(90deg,#eef2ff,#fffbeb);border:1px solid rgba(99,102,241,0.12)">
                        <div class="text-uppercase fw-bold text-primary" style="font-size:11px;letter-spacing:0.08em">Donating to</div>
                        <div class="font-display fw-bold fs-5 text-dark mt-1">{{ $campaign->title }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger rounded-4 border-0 mb-4 small">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('donations.store') }}" method="POST">
                    @csrf
                    @if($campaign) <input type="hidden" name="campaign_id" value="{{ $campaign->id }}"> @endif

                    {{-- Amount --}}
                    <div x-data="{ selected: {{ old('amount', 1000) }} }" class="mb-4">
                        <label class="form-label fw-semibold">Choose an amount</label>
                        <div class="row g-2 mb-2">
                            @foreach($preset_amounts as $amt)
                                <div class="col-6 col-sm-3">
                                    <button type="button"
                                            @click="selected = {{ $amt }}; $refs.amountInput.value = {{ $amt }}"
                                            :class="selected === {{ $amt }} ? 'selected' : ''"
                                            class="amount-btn w-100">
                                        ${{ number_format($amt / 100, 0) }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent fw-semibold text-muted">$</span>
                            <input x-ref="amountInput" type="number" name="amount" min="{{ config('donation.min_amount') }}" value="{{ old('amount', 1000) }}" @input="selected = null" class="form-control" placeholder="Custom amount (cents)" required>
                        </div>
                        <div class="form-text">Amount is in cents. $10.00 = 1000</div>
                    </div>

                    {{-- Donor info --}}
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Full name</label>
                            <input type="text" name="donor_name" value="{{ old('donor_name', auth()->user()->name ?? '') }}" class="form-control" placeholder="Your name" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Email address</label>
                            <input type="email" name="donor_email" value="{{ old('donor_email', auth()->user()->email ?? '') }}" class="form-control" placeholder="you@example.com" required>
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Payment method</label>
                            <select name="payment_method" class="form-select">
                                <option value="stripe">💳 Stripe</option>
                                <option value="paypal">🅿 PayPal</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Donation type</label>
                            <select name="type" class="form-select">
                                <option value="one_time">One-time donation</option>
                                <option value="recurring">Monthly recurring</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="currency" value="{{ $default_currency }}">

                    {{-- Anonymous --}}
                    <div class="form-check rounded-4 p-3 mb-4" style="border:1px solid #e2e8f0;padding-left:2.5rem!important">
                        <input type="checkbox" name="is_anonymous" value="1" class="form-check-input" id="anonymousCheck">
                        <label class="form-check-label" for="anonymousCheck">
                            <span class="fw-semibold small">Donate anonymously</span>
                            <div class="text-muted" style="font-size:12px">Your name won't appear publicly</div>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-gradient w-100 py-3 d-flex align-items-center justify-content-center gap-2 fs-6">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        Complete Donation
                    </button>
                    <p class="text-center text-muted mt-3 d-flex align-items-center justify-content-center gap-1" style="font-size:12px">
                        <svg width="14" height="14" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Secured by 256-bit SSL encryption
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-layouts.public>
