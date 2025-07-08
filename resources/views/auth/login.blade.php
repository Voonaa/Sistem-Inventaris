<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Login Error Alert -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
            <strong class="font-bold">Login Gagal!</strong>
            <span class="block sm:inline">Email atau password yang Anda masukkan salah.</span>
        </div>
    @endif

    <div class="text-center mb-8">
        <div class="flex justify-center">
            <img src="{{ asset('assets/images/logosmk.png') }}" alt="SMK Sasmita Logo" class="h-40 w-auto mb-6">
        </div>
        <div class="text-xl font-bold text-blue-700 mb-2">SISVEN</div>
        <h2 class="text-2xl font-semibold text-gray-900">Sistem Inventaris</h2>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="mt-1 block w-full px-3 py-2 bg-blue-50 border border-blue-200 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="admin@admin.com"
            >
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
                type="password"
                name="password"
                id="password"
                class="mt-1 block w-full px-3 py-2 bg-blue-50 border border-blue-200 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                required
                placeholder="••••••"
            >
        </div>

        <!-- Remember Me and Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="remember_me"
                    name="remember"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                >
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Forgot your password?
                </a>
            @endif
        </div>

        <div>
            <button
                type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>
