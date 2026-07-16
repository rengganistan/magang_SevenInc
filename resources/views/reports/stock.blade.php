@extends('layouts.dashboard')

@section('content')

<div class="p-4">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">

        <div class="flex justify-between items-center p-6 border-b dark:border-gray-700">

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Laporan Stok Barang
            </h1>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left text-gray-500">

                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">

                    <tr>

                        <th class="px-6 py-3">No</th>

                        <th class="px-6 py-3">Kode</th>

                        <th class="px-6 py-3">Produk</th>

                        <th class="px-6 py-3">Kategori</th>

                        <th class="px-6 py-3">Supplier</th>

                        <th class="px-6 py-3">Stok</th>

                        <th class="px-6 py-3">Minimum</th>

                        <th class="px-6 py-3">Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                    <tr class="border-b dark:border-gray-700">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->kode }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->nama }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->category->name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->supplier->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            <span class="font-semibold">

                                {{ $product->stok }}

                            </span>

                        </td>

                        <td class="px-6 py-4">

                            {{ $product->stok_minimum }}

                        </td>

                        <td class="px-6 py-4">

                            @if($product->stok==0)

                                <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full">
                                    Habis
                                </span>

                            @elseif($product->stok <= $product->stok_minimum)

                                <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">
                                    Menipis
                                </span>

                            @else

                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">
                                    Aman
                                </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center py-8">

                            Tidak ada data.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
