@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-white">Dashboard Staff Gudang</h1>
        <p class="text-sm text-gray-400 mt-1">
            Selamat datang, <span class="text-white font-medium">{{ auth()->user()->name }}</span>
            — {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </p>
    </div>

    {{-- Alert session --}}
    @if(session('error'))
    <div class="rounded-xl border border-red-700 bg-red-900/40 px-4 py-3 flex items-center gap-3">
        <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <span class="text-red-300 text-sm">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="rounded-xl border border-yellow-700/50 bg-yellow-900/10 p-4">
            <p class="text-xs text-gray-400 mb-2">Pending Masuk</p>
            <p class="text-3xl font-bold text-yellow-400">{{ $pendingIncoming->count() }}</p>
            <p class="text-xs text-gray-500 mt-1">menunggu konfirmasi</p>
        </div>

        <div class="rounded-xl border border-orange-700/50 bg-orange-900/10 p-4">
            <p class="text-xs text-gray-400 mb-2">Pending Keluar</p>
            <p class="text-3xl font-bold text-orange-400">{{ $pendingOutgoing->count() }}</p>
            <p class="text-xs text-gray-500 mt-1">menunggu konfirmasi</p>
        </div>

        <div class="rounded-xl border border-green-700/50 bg-green-900/10 p-4">
            <p class="text-xs text-gray-400 mb-2">Dikonfirmasi Hari Ini</p>
            <p class="text-3xl font-bold text-green-400">{{ $incomingToday }}</p>
            <p class="text-xs text-gray-500 mt-1">barang masuk</p>
        </div>

        <div class="rounded-xl border border-red-700/50 bg-red-900/10 p-4">
            <p class="text-xs text-gray-400 mb-2">Dikonfirmasi Hari Ini</p>
            <p class="text-3xl font-bold text-red-400">{{ $outgoingToday }}</p>
            <p class="text-xs text-gray-500 mt-1">barang keluar</p>
        </div>

    </div>

    {{-- Aksi Cepat --}}
    <div class="rounded-xl border border-gray-700 bg-gray-800 p-5">
        <h3 class="text-sm font-semibold text-white mb-4">Aksi Cepat</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('staff.transactions.create', ['type' => 'Masuk']) }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white font-medium transition">
                + Catat Barang Masuk
            </a>
            <a href="{{ route('staff.transactions.create', ['type' => 'Keluar']) }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium transition">
                − Catat Barang Keluar
            </a>
            <a href="{{ route('staff.products.index') }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white font-medium transition">
                Lihat Produk
            </a>
        </div>
    </div>

    {{-- Dua kolom: pending masuk + pending keluar --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Barang Masuk Pending --}}
        <div class="rounded-xl border border-gray-700 bg-gray-800">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 animate-pulse"></span>
                    <h3 class="text-sm font-semibold text-white">Barang Masuk — Perlu Diperiksa</h3>
                </div>
                <span class="text-xs text-yellow-400 font-medium">{{ $pendingIncoming->count() }} pending</span>
            </div>

            @forelse($pendingIncoming as $tx)
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-700 last:border-0">
                <div>
                    <p class="text-sm text-white font-medium">{{ $tx->product->nama ?? '-' }}</p>
                    <p class="text-xs text-gray-400">
                        Qty: <span class="text-white">{{ $tx->quantity }}</span>
                        · {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}
                        · oleh {{ $tx->user->name ?? '-' }}
                    </p>
                </div>
                <form action="{{ route('staff.transactions.confirm', $tx->id) }}" method="POST" class="ml-3">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-semibold transition whitespace-nowrap">
                        ✓ Konfirmasi
                    </button>
                </form>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-500">
                ✓ Tidak ada barang masuk yang perlu diperiksa
            </div>
            @endforelse

            <div class="px-5 py-3 border-t border-gray-700">
                <a href="{{ route('staff.transactions.incoming') }}"
                    class="text-xs text-blue-400 hover:underline">Lihat semua riwayat →</a>
            </div>
        </div>

        {{-- Barang Keluar Pending --}}
        <div class="rounded-xl border border-gray-700 bg-gray-800">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-400 animate-pulse"></span>
                    <h3 class="text-sm font-semibold text-white">Barang Keluar — Perlu Disiapkan</h3>
                </div>
                <span class="text-xs text-orange-400 font-medium">{{ $pendingOutgoing->count() }} pending</span>
            </div>

            @forelse($pendingOutgoing as $tx)
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-700 last:border-0">
                <div>
                    <p class="text-sm text-white font-medium">{{ $tx->product->nama ?? '-' }}</p>
                    <p class="text-xs text-gray-400">
                        Qty: <span class="text-white">{{ $tx->quantity }}</span>
                        · {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}
                        · oleh {{ $tx->user->name ?? '-' }}
                    </p>
                </div>
                <form action="{{ route('staff.transactions.confirm', $tx->id) }}" method="POST" class="ml-3">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold transition whitespace-nowrap">
                        ✓ Konfirmasi
                    </button>
                </form>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-500">
                ✓ Tidak ada barang keluar yang perlu disiapkan
            </div>
            @endforelse

            <div class="px-5 py-3 border-t border-gray-700">
                <a href="{{ route('staff.transactions.outgoing') }}"
                    class="text-xs text-blue-400 hover:underline">Lihat semua riwayat →</a>
            </div>
        </div>

    </div>

    {{-- Stok Menipis --}}
    @if($lowStockProducts->count())
    <div class="rounded-xl border border-yellow-700/40 bg-yellow-900/5 p-5">
        <h3 class="text-sm font-semibold text-white mb-4">
            ⚠ Stok Menipis
            <span class="ml-2 px-2 py-0.5 rounded-full bg-yellow-600/20 text-yellow-400 text-xs">{{ $lowStock }} produk</span>
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($lowStockProducts as $p)
            <div class="flex items-center justify-between rounded-lg bg-gray-800 border border-gray-700 px-4 py-3">
                <div>
                    <p class="text-sm text-white font-medium">{{ $p->nama }}</p>
                    <p class="text-xs text-gray-400">{{ $p->category->nama ?? '-' }}</p>
                </div>
                <div class="text-right">
                    <span class="text-sm font-bold {{ $p->stok == 0 ? 'text-red-400' : 'text-yellow-400' }}">
                        {{ $p->stok }}
                    </span>
                    <p class="text-xs text-gray-500">min: {{ $p->stok_minimum }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection
