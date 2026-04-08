<x-layouts.public>
    <x-slot:title>Make a Donation — DonateHeart</x-slot:title>

    <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Back --}}
        <a href="{{ route('campaigns.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors group mb-8">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to campaigns
        </a>

        <div class="card overflow-hidden shadow-md">
            {{-- Header gradient --}}
            <div class="bg-gradient-to-r from-brand-600 to-accent-600 p-6 md:p-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-display font-bold text-white">Make a Donation</h1>
                        <p class="text-white/70 text-sm mt-0.5">Your generosity creates real change in the world.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8">
                {{-- Campaign banner --}}
                @if($campaign)
                    <div class="bg-gradient-to-r from-accent-50 to-brand-50 border border-accent-100 rounded-xl p-4 mb-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-accent-600 mb-1">Donating to</p>
                        <p class="font-display font-bold text-gray-900 text-lg">{{ $campaign->title }}</p>
                    </div>
                @endif

                {{-- Validation errors --}}
                @if($errors->any())
                    <div class="alert-error mb-6">
                        <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <ul class="space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('donations.store') }}" method="POST" class="space-y-7">
                    @csrf
                    @if($campaign)
                        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                    @endif

                    {{-- ── Amount picker ────────────────────── --}}
                    <div x-data="{ selected: {{ old('amount', 1000) }} }">
                        <label class="form-label">Choose an amount</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                            @foreach($preset_amounts as $amt)
                                <button type="button"
                                        @click="selected = {{ $amt }}; $refs.amountInput.value = {{ $amt }}"
                                        :class="selected === {{ $amt }}
                                            ? 'border-brand-500 bg-brand-50 text-brand-700 shadow-sm ring-1 ring-brand-400'
                                            : 'border-gray-200 bg-white text-gray-600 hover:border-gray-300 hover:bg-gray-50'"
                                        class="border-2 rounded-xl py-3 px-2 text-center font-bold text-sm transition-all duration-150 focus:outline-none">
                                    ${{ number_format($amt / 100, 0) }}
                                </button>
                            @endforeach
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold text-sm">$</span>
                            <input x-ref="amountInput"
                                   type="number" name="amount"
                                   min="{{ config('donation.min_amount') }}"
                                   value="{{ old('amount', 1000) }}"
                                   @input="selected = null"
                                   class="form-input pl-8"
                                   placeholder="Custom amount (in cents)"
                                   required>
                        </div>
                        <p class="form-hint">Amount is in cents. $10.00 = 1000</p>
                    </div>

                    {{-- ── Donor info ───────────────────────── --}}
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="form-label">Full name</label>
                            <input type="text" name="donor_name"
                                   value="{{ old('donor_name', auth()->user()->name ?? '') }}"
                                   class="form-input" placeholder="Your name" required>
                        </div>
                        <div>
                            <label class="form-label">Email address</label>
                            <input type="email" name="donor_email"
                                   value="{{ old('donor_email', auth()->user()->email ?? '') }}"
                                   class="form-input" placeholder="you@example.com" required>
                        </div>
                    </div>

                    {{-- ── Payment & type ───────────────────── --}}
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="form-label">Payment method</label>
                            <select name="payment_method" class="form-select">
                                <option value="stripe">💳 Stripe</option>
                                <option value="paypal">🅿 PayPal</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Donation type</label>
                            <select name="type" class="form-select">
                                <option value="one_time">One-time donation</option>
                                <option value="recurring">Monthly recurring</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="currency" value="{{ $default_currency }}">

                    {{-- ── Anonymous ────────────────────────── --}}
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="relative mt-0.5">
                            <input type="checkbox" name="is_anonymous" value="1"
                                   class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 focus:ring-offset-0 cursor-pointer">
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-700">Donate anonymously</span>
                            <p class="text-xs text-gray-400 mt-0.5">Your name won't appear publicly</p>
                        </div>
                    </label>

                    {{-- ── Submit ───────────────────────────── --}}
                    <button type="submit" class="btn-primary w-full !py-4 text-base">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        Complete Donation
                    </button>

                    {{-- Trust --}}
                    <p class="text-center text-xs text-gray-400 flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Secured by 256-bit SSL encryption
                    </p>
                </form>
            </div>
        </div>
    </section>
</x-layouts.public>
