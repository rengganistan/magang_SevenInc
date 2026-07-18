<!DOCTYPE html>
<html lang="en" class="dark">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php $setting = \App\Models\Setting::first(); @endphp

    <title>Reset Password - {{ $setting->app_name ?? 'Stockify' }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-900">

<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen">

    <a href="{{ url('/') }}"
        class="flex items-center mb-8 text-2xl font-semibold text-white">

        @if(!empty($setting->logo))
          <img
              src="{{ asset('storage/' . $setting->logo) }}"
              class="h-10 mr-3"
              alt="{{ $setting->app_name ?? 'Logo' }}">
        @else
          <img
              src="{{ asset('static/images/logo.svg') }}"
              class="h-10 mr-3"
              alt="Logo">
        @endif

        {{ $setting->app_name ?? 'Stockify' }}

    </a>

    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-lg border border-gray-700">

        <div class="p-8">

            <h2 class="mb-2 text-3xl font-bold text-white">
                Reset Password
            </h2>

            <p class="mb-6 text-sm text-gray-400">
                Masukkan password baru Anda di bawah ini.
            </p>

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">

                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $email) }}"
                        placeholder="name@gmail.com"
                        required
                        class="w-full rounded-lg border border-gray-600 bg-gray-700 p-3 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">
                        Password Baru
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="w-full rounded-lg border border-gray-600 bg-gray-700 p-3 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">
                        Konfirmasi Password Baru
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        required
                        class="w-full rounded-lg border border-gray-600 bg-gray-700 p-3 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-blue-600 px-5 py-3 text-white font-semibold hover:bg-blue-700 transition">
                    Reset Password
                </button>

            </form>

            <p class="mt-5 text-sm text-center text-gray-400">
                <a href="{{ route('login') }}" class="text-blue-400 hover:underline font-medium">
                    Kembali ke Login
                </a>
            </p>

        </div>

    </div>

</div>

</body>

</html>
