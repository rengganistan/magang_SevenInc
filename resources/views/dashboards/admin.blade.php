@extends('layouts.dashboard')

@section('content')

<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">

    <div class="w-full mb-1">

        <div class="mb-4">

            <h1 class="text-2xl font-semibold text-gray-900 sm:text-3xl dark:text-white">
                Dashboard Admin
            </h1>

            <p class="mt-2 text-gray-600 dark:text-gray-300">
                Selamat datang,
                <strong>{{ auth()->user()->name }}</strong>
            </p>

        </div>

    </div>

</div>

@endsection
