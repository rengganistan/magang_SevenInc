@extends('layouts.dashboard')

@section('content')

<div class="p-4 bg-gray-900 min-h-screen">

    {{-- Header --}}
    <div class="mb-8 flex flex-col lg:flex-row lg:justify-between lg:items-center gap-5">

        <div>

            <h1 class="text-4xl font-bold text-white">
                Manajemen Produk
            </h1>

            <p class="text-gray-400 mt-2">
                Kelola seluruh data produk pada sistem inventory.
            </p>

        </div>

        <div class="flex gap-3">

            <a
                href="{{ route('admin.dashboard') }}"
                class="px-5 py-3 rounded-lg bg-gray-700 hover:bg-gray-600 text-white">

                ← Dashboard

            </a>

            <a
                href="{{ route('products.create') }}"
                class="px-5 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">

                + Tambah Produk

            </a>

        </div>

    </div>

    {{-- Alert Success --}}
    @if(session('success'))

    <div class="mb-6 rounded-lg bg-green-900 border border-green-700 p-4">

        <span class="text-green-300">

            {{ session('success') }}

        </span>

    </div>

    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        {{-- Total Produk --}}
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow">

            <p class="text-gray-400 text-sm">

                Total Produk

            </p>

            <h2 class="text-4xl font-bold text-white mt-3">

                {{ $products->count() }}

            </h2>

        </div>

        {{-- Total Kategori --}}
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow">

            <p class="text-gray-400 text-sm">

                Total Kategori

            </p>

            <h2 class="text-4xl font-bold text-green-400 mt-3">

                {{ $products->pluck('category_id')->unique()->count() }}

            </h2>

        </div>

        {{-- Stok Menipis --}}
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow">

            <p class="text-gray-400 text-sm">

                Stok Menipis

            </p>

            <h2 class="text-4xl font-bold text-yellow-400 mt-3">

                {{ $products->where('stok','<=',5)->where('stok','>',0)->count() }}

            </h2>

        </div>

        {{-- Stok Habis --}}
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow">

            <p class="text-gray-400 text-sm">

                Stok Habis

            </p>

            <h2 class="text-4xl font-bold text-red-500 mt-3">

                {{ $products->where('stok',0)->count() }}

            </h2>

        </div>

    </div>

    {{-- Search --}}
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 mb-6">

        <div class="flex flex-col md:flex-row gap-4">

            <input
                id="searchInput"
                type="text"
                placeholder="Cari produk..."

                class="flex-1 rounded-lg bg-gray-700 border border-gray-600 text-white
                placeholder-gray-400
                px-5 py-3">

        </div>

    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl bg-gray-800 border border-gray-700 shadow-xl">

        <div class="overflow-x-auto">

            <table id="productTable" class="w-full text-left">

                <thead class="bg-gray-700">

                    <tr>

                        <th class="px-6 py-4 text-gray-200">
                            No
                        </th>

                        <th class="px-6 py-4 text-gray-200">
                            Foto
                        </th>

                        <th class="px-6 py-4 text-gray-200">
                            Kode
                        </th>

                        <th class="px-6 py-4 text-gray-200">
                            Nama Produk
                        </th>

                        <th class="px-6 py-4 text-gray-200">
                            Kategori
                        </th>

                        <th class="px-6 py-4 text-gray-200">
                            Harga
                        </th>

                        <th class="px-6 py-4 text-gray-200">
                            Stok
                        </th>

                        <th class="px-6 py-4 text-center text-gray-200">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>
                                    @forelse($products as $product)

                <tr class="border-t border-gray-700 hover:bg-gray-700 transition duration-200">

                    {{-- No --}}
                    <td class="px-6 py-5 text-white">

                        {{ $loop->iteration }}

                    </td>

                    {{-- Foto --}}
                    <td class="px-6 py-5">

                        @if($product->gambar)

                            <img
                                src="{{ asset('storage/'.$product->gambar) }}"
                                class="w-14 h-14 rounded-lg object-cover border border-gray-600">

                        @else

                            <div class="w-14 h-14 rounded-lg bg-gray-700 flex items-center justify-center text-gray-400">

                                📦

                            </div>

                        @endif

                    </td>

                    {{-- Kode --}}
                    <td class="px-6 py-5">

                        <span class="font-semibold text-blue-400">

                            {{ $product->kode }}

                        </span>

                    </td>

                    {{-- Nama --}}
                    <td class="px-6 py-5">

                        <div class="font-semibold text-white">

                            {{ $product->nama }}

                        </div>

                        @if($product->deskripsi)

                            <div class="text-sm text-gray-400 mt-1">

                                {{ Str::limit($product->deskripsi,40) }}

                            </div>

                        @endif

                    </td>

                    {{-- Kategori --}}
                    <td class="px-6 py-5 text-gray-300">

                        {{ $product->category->name }}

                    </td>

                    {{-- Harga --}}
                    <td class="px-6 py-5">

                        <div class="text-green-400 font-semibold">

                            Rp {{ number_format($product->harga_jual,0,',','.') }}

                        </div>

                        <div class="text-xs text-gray-400">

                            Modal :
                            Rp {{ number_format($product->harga_beli,0,',','.') }}

                        </div>

                    </td>

                    {{-- Stok --}}
                    <td class="px-6 py-5">

                        @if($product->stok==0)

                            <span class="px-3 py-1 rounded-full bg-red-600 text-white text-sm">

                                Habis

                            </span>

                        @elseif($product->stok <= $product->stok_minimum)

                            <span class="px-3 py-1 rounded-full bg-yellow-500 text-white text-sm">

                                {{ $product->stok }} pcs

                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-green-600 text-white text-sm">

                                {{ $product->stok }} pcs

                            </span>

                        @endif

                    </td>

                    {{-- Action --}}
                    <td class="px-6 py-5">

                        <div class="flex justify-center gap-2">

                            <a
                                href="{{ route('products.edit',$product->id) }}"
                                class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition">

                                ✏ Edit

                            </a>

                            <form
                                action="{{ route('products.destroy',$product->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition">

                                    🗑 Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="py-20 text-center">

                        <div class="flex flex-col items-center">

                            <div class="text-6xl mb-3">

                                📦

                            </div>

                            <h2 class="text-2xl font-bold text-white">

                                Belum Ada Produk

                            </h2>

                            <p class="text-gray-400 mt-2">

                                Tambahkan produk pertama untuk memulai inventory.

                            </p>

                            <a
                                href="{{ route('products.create') }}"
                                class="mt-6 px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">

                                + Tambah Produk

                            </a>

                        </div>

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- Live Search --}}
<script>

const searchInput=document.getElementById('searchInput');

const table=document.getElementById('productTable');

searchInput.addEventListener('keyup',function(){

let filter=this.value.toLowerCase();

let rows=table.getElementsByTagName('tr');

for(let i=1;i<rows.length;i++){

let text=rows[i].innerText.toLowerCase();

rows[i].style.display=text.includes(filter)?'':'none';

}

});

</script>

@endsection
