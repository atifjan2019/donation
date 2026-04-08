<x-guest-layout>
    <div>
        <h2 class="text-2xl font-display font-bold text-gray-900 mb-1">Create your account</h2>
        <p class="text-sm text-gray-500 mb-8">Join our community of generous donors.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <button type="submit" class="btn-primary w-full">Create Account</button>

        <p class="text-center text-sm text-gray-500">
            Already have an account? <a href="{{ route('login') }}" class="font-medium text-brand-600 hover:text-brand-700">Sign in</a>
        </p>
    </form>
</x-guest-layout>
