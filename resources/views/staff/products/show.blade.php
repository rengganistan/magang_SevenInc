@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
        <div>
            <p class="text-sm text-gray-400 mb-2">Dashboard / Produk / Detail</p>
            <h1 class="text-3xl lg:text-4xl font-bold text-white">Detail Produk</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('staff.products.index') }}"
                class="px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">
                ← Kembali
            </a>
            <a href="{{ route('staff.transactions.create', ['type' => 'Masuk', 'product_id' => $product->id]) }}"
                class="px-5 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white transition">
                + Catat Masuk
            </a>
            <a href="{{ route('staff.transactions.create', ['type' => 'Keluar', 'product_id' => $product->id]) }}"
                class="px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white transition">
                − Catat Keluar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Foto + Stok --}}
        <div class="space-y-4">
            <div class="rounded-2xl border border-gray-700 bg-gray-800 p-5 flex flex-col items-center">
                @if($product->gambar)
                    <img src="{{ asset('storage/'.$product->gambar) }}"
                        class="w-full max-w-xs rounded-xl object-cover border border-gray-600 shadow-lg">
                @else
                    <div class="w-full max-w-xs h-48 rounded-xl bg-gray-700 flex items-center justify-center text-6xl">📦</div>
                @endif
                <p class="mt-3 text-gray-400 text-sm">Foto Produk</p>
            </div>

            <div class="rounded-2xl border border-gray-700 bg-gray-800 p-5">
                <h3 class="text-sm font-semibold text-gray-400 uppercase mb-4">Status Stok</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">Stok Saat Ini</span>
                        @if($product->stok == 0)
                            <span class="px-3 py-1 rounded-full bg-red-600/20 text-red-400 font-bold">Habis</span>
                        @elseif($product->stok <= $product->stok_minimum)
                            <span class="px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 font-bold">{{ $product->stok }} {{ $product->satuan }}</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-green-600/20 text-green-400 font-bold">{{ $product->stok }} {{ $product->satuan }}</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">Stok Minimum</span>
                        <span class="text-white font-semibold">{{ $product->stok_minimum }} {{ $product->satuan }}</span>
                    </div>
                    @php
                        $pct = $product->stok_minimum > 0
                            ? min(100, round(($product->stok / max($product->stok_minimum * 2, $product->stok)) * 100))
                            : 100;
                        $barColor = $product->stok == 0 ? 'bg-red-500'
                            : ($product->stok <= $product->stok_minimum ? 'bg-yellow-500' : 'bg-green-500');
                    @endphp
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="{{ $barColor }} h-2 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="pt-2 border-t border-gray-700">
                        @if($product->stok == 0)
                            <p class="text-xs text-red-400">⚠ Stok habis! Laporkan ke manajer.</p>
                        @elseif($product->stok <= $product->stok_minimum)
                            <p class="text-xs text-yellow-400">⚠ Stok di bawah minimum.</p>
                        @else
                            <p class="text-xs text-green-400">✓ Stok dalam kondisi aman.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Detail --}}
        <div class="lg:col-span-2 space-y-4">

            <div class="rounded-2xl border border-gray-700 bg-gray-800 p-6">
                <h3 class="text-sm font-semibold text-gray-400 uppercase mb-4">Informasi Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kode Produk</p>
                        <p class="text-blue-400 font-bold text-lg">{{ $product->kode }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nama Produk</p>
                        <p class="text-white font-semibold text-lg">{{ $product->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kategori</p>
                        <span class="px-3 py-1 rounded-full bg-blue-600/20 text-blue-400 text-sm">{{ $product->category->nama ?? '-' }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Supplier</p>
                        <p class="text-white">{{ $product->supplier->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Satuan</p>
                        <p class="text-white">{{ $product->satuan }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Harga Jual</p>
                        <p class="text-green-400 font-semibold">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                    </div>
                </div>
                @if($product->deskripsi)
                <div class="mt-4 pt-4 border-t border-gray-700">
                    <p class="text-xs text-gray-500 mb-2">Deskripsi</p>
                    <p class="text-gray-300 text-sm leading-relaxed">{{ $product->deskripsi }}</p>
                </div>
                @endif
            </div>

            @if($attributes->count())
            <div class="rounded-2xl border border-gray-700 bg-gray-800 p-6">
                <h3 class="text-sm font-semibold text-gray-400 uppercase mb-4">Atribut Produk</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($attributes as $attr)
                    <div class="rounded-xl bg-gray-700/50 px-4 py-3">
                        <p class="text-xs text-gray-500 mb-0.5">{{ $attr->name }}</p>
                        <p class="text-white font-medium">{{ $attr->value }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Riwayat transaksi saya untuk produk ini --}}
            @php
                $myTx = $product->stockTransactions()
                    ->where('user_id', auth()->id())
                    ->latest()->take(5)->get();
            @endphp
            @if($myTx->count())
            <div class="rounded-2xl border border-gray-700 bg-gray-800 p-6">
                <h3 class="text-sm font-semibold text-gray-400 uppercase mb-4">Riwayat Transaksi Saya</h3>
                <div class="space-y-2">
                    @foreach($myTx as $tx)
                    <div class="flex items-center justify-between py-2 border-b border-gray-700 last:border-0">
                        <div class="flex items-center gap-3">
                            @if($tx->type === 'Masuk')
                                <span class="px-2 py-0.5 rounded-full bg-green-600/20 text-green-400 text-xs font-semibold">↑ Masuk</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-red-600/20 text-red-400 text-xs font-semibold">↓ Keluar</span>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="text-white font-semibold">{{ $tx->quantity }} {{ $product->satuan }}</span>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

@endsection
