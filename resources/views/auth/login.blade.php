<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 p-4 bg-blue-50 text-blue-800 rounded-lg" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="email"
                placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input
                id="password"
                class="block mt-1 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="block mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordar sesión') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            {{-- @if (Route::has('password.request'))
                <a class="text-sm text-primary-600 hover:text-primary-800" href="{{ route('password.request') }}">
                    <i class="fas fa-question-circle me-1"></i> {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif --}}

            <x-primary-button class="ms-3 bg-primary-600 hover:bg-primary-700 px-6 py-3">
                <i class="fas fa-sign-in-alt me-2"></i> {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
