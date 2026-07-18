@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
        <div>
            <p class="text-sm text-gray-400 mb-2">Dashboard / Supplier</p>
            <h1 class="text-3xl lg:text-4xl font-bold text-white">Daftar Supplier</h1>
            <p class="mt-2 text-gray-400">Lihat informasi supplier yang bekerja sama dengan perusahaan.</p>
        </div>
        <a href="{{ route('manager.dashboard') }}"
            class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">
            ← Dashboard
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-700 bg-gray-800 shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-gray-300">No</th>
                        <th class="px-6 py-4 text-left text-gray-300">Nama Supplier</th>
                        <th class="px-6 py-4 text-left text-gray-300">Email</th>
                        <th class="px-6 py-4 text-left text-gray-300">Telepon</th>
                        <th class="px-6 py-4 text-left text-gray-300">Alamat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-6 py-5 text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-5 font-semibold text-white">{{ $supplier->nama }}</td>
                        <td class="px-6 py-5 text-gray-300">{{ $supplier->email ?: '-' }}</td>
                        <td class="px-6 py-5">
                            @if($supplier->phone)
                                <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-sm">{{ $supplier->phone }}</span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-gray-300">{{ $supplier->address ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-gray-400">Belum ada data supplier.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
