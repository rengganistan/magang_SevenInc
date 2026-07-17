@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

        <div>

            <p class="text-sm text-gray-400 mb-2">
                Dashboard / Supplier
            </p>

            <h1 class="text-3xl lg:text-4xl font-bold text-white">
                Manajemen Supplier
            </h1>

            <p class="mt-2 text-gray-400">
                Kelola seluruh data supplier yang bekerja sama dengan perusahaan.
            </p>

        </div>

        <div class="flex flex-col sm:flex-row gap-3">

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">

                ← Dashboard

            </a>

            <a href="{{ route('suppliers.create') }}"
               class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition">

                + Tambah Supplier

            </a>

        </div>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

        <div class="mb-6 rounded-xl border border-green-700 bg-green-900/40 p-4">

            <span class="text-green-300">

                {{ session('success') }}

            </span>

        </div>

    @endif

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-700 bg-gray-800 shadow-xl">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-700">

                    <tr>

                        <th class="px-6 py-4 text-left text-gray-300">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-gray-300">
                            Nama Supplier
                        </th>

                        <th class="px-6 py-4 text-left text-gray-300">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-gray-300">
                            Telepon
                        </th>

                        <th class="px-6 py-4 text-left text-gray-300">
                            Alamat
                        </th>

                        <th class="px-6 py-4 text-center text-gray-300">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-700">

                    @forelse($suppliers as $supplier)

                        <tr class="hover:bg-gray-700 transition">

                            <td class="px-6 py-5 text-white">

                                {{ $loop->iteration }}

                            </td>

                            <td class="px-6 py-5">

                                <span class="font-semibold text-white">

                                    {{ $supplier->nama }}

                                </span>

                            </td>

                            <td class="px-6 py-5 text-gray-300">

                                {{ $supplier->email ?: '-' }}

                            </td>

                            <td class="px-6 py-5">

                                @if($supplier->phone)

                                    <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-sm">

                                        {{ $supplier->phone }}

                                    </span>

                                @else

                                    <span class="text-gray-500">

                                        -

                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-gray-300">

                                {{ $supplier->address ?: '-' }}

                            </td>

                            <td class="px-6 py-5">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('suppliers.edit',$supplier->id) }}"
                                       class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition">

                                        ✏ Edit

                                    </a>

                                    <form
                                    action="{{ route('suppliers.destroy',$supplier->id) }}"
                                    method="POST"
                                    class="delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition">

                                            🗑 Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="py-16 text-center text-gray-400">

                                Belum ada data supplier.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
