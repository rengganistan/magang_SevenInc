@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-white">Dashboard Manajer Gudang</h1>
        <p class="text-sm text-gray-400 mt-1">
            Selamat datang, <span class="text-white font-medium">{{ auth()->user()->name }}</span>
            — {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="rounded-xl border border-gray-700 bg-gray-800 p-4">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 rounded-lg bg-blue-600/20">
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v2H4V5zm0 4h3v2H4V9zm5 0h3v2H9V9zm5 0h2v2h-2V9zm-10 4h3v2H4v-2zm5 0h3v2H9v-2zm5 0h2v2h-2v-2z"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400">Total Produk</p>
            </div>
            <p class="text-3xl font-bold text-white">{{ $totalProducts }}</p>
            <a href="{{ route('manager.products.index') }}" class="text-xs text-blue-400 hover:underline mt-1 block">Lihat produk →</a>
        </div>

        <div class="rounded-xl border border-gray-700 bg-gray-800 p-4">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 rounded-lg bg-yellow-600/20">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400">Stok Menipis</p>
            </div>
            <p class="text-3xl font-bold text-yellow-400">{{ $lowStock }}</p>
            <a href="{{ route('manager.products.index') }}" class="text-xs text-yellow-400 hover:underline mt-1 block">Periksa stok →</a>
        </div>

        <div class="rounded-xl border border-gray-700 bg-gray-800 p-4">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 rounded-lg bg-green-600/20">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400">Masuk Hari Ini</p>
            </div>
            <p class="text-3xl font-bold text-green-400">{{ $incomingToday }}</p>
            <a href="{{ route('manager.transactions.incoming') }}" class="text-xs text-green-400 hover:underline mt-1 block">Lihat transaksi →</a>
        </div>

        <div class="rounded-xl border border-gray-700 bg-gray-800 p-4">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 rounded-lg bg-red-600/20">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-3.707-8.707l3-3a1 1 0 011.414 1.414L9.414 9H13a1 1 0 110 2H9.414l1.293 1.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400">Keluar Hari Ini</p>
            </div>
            <p class="text-3xl font-bold text-red-400">{{ $outgoingToday }}</p>
            <a href="{{ route('manager.transactions.outgoing') }}" class="text-xs text-red-400 hover:underline mt-1 block">Lihat transaksi →</a>
        </div>

    </div>

    {{-- Grafik + Stok Menipis --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Grafik Transaksi --}}
        <div class="xl:col-span-2 rounded-xl border border-gray-700 bg-gray-800 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-white">Transaksi 6 Bulan Terakhir</h3>
                <div class="flex gap-3 text-xs text-gray-400">
                    <span class="flex items-center gap-1">
                        <span class="inline-block w-2 h-2 rounded-full bg-green-400"></span>Masuk
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>Keluar
                    </span>
                </div>
            </div>
            <canvas id="transactionChart" height="90"></canvas>
        </div>

        {{-- Stok Menipis --}}
        <div class="rounded-xl border border-gray-700 bg-gray-800 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-white">Stok Menipis</h3>
                <span class="text-xs text-yellow-400 font-medium">{{ $lowStockProducts->count() }} produk</span>
            </div>
            @forelse($lowStockProducts as $p)
            <div class="flex items-center justify-between py-2 border-b border-gray-700 last:border-0">
                <div>
                    <p class="text-sm text-white font-medium truncate max-w-[130px]">{{ $p->nama }}</p>
                    <p class="text-xs text-gray-400">{{ $p->category->nama ?? '-' }}</p>
                </div>
                <div class="text-right">
                    <span class="text-sm font-bold text-red-400">{{ $p->stok }}</span>
                    <p class="text-xs text-gray-500">min: {{ $p->stok_minimum }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-6">Semua stok aman ✓</p>
            @endforelse
        </div>

    </div>

    {{-- Transaksi Terbaru --}}
    <div class="rounded-xl border border-gray-700 bg-gray-800">
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-700">
            <h3 class="text-sm font-semibold text-white">Transaksi Terbaru</h3>
            <div class="flex gap-3">
                <a href="{{ route('manager.transactions.incoming') }}" class="text-xs text-green-400 hover:underline">Masuk →</a>
                <a href="{{ route('manager.transactions.outgoing') }}" class="text-xs text-red-400 hover:underline">Keluar →</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-700/50">
                        <th class="px-5 py-3 text-left text-gray-400 font-medium">Produk</th>
                        <th class="px-5 py-3 text-left text-gray-400 font-medium">Tipe</th>
                        <th class="px-5 py-3 text-left text-gray-400 font-medium">Jumlah</th>
                        <th class="px-5 py-3 text-left text-gray-400 font-medium">Petugas</th>
                        <th class="px-5 py-3 text-left text-gray-400 font-medium">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($recentTransactions as $tx)
                    <tr class="hover:bg-gray-700/40 transition">
                        <td class="px-5 py-3 text-white font-medium">{{ $tx->product->nama ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if($tx->type === 'Masuk')
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-600/20 text-green-400">Masuk</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-red-600/20 text-red-400">Keluar</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-300">{{ $tx->quantity }}</td>
                        <td class="px-5 py-3 text-gray-300">{{ $tx->user->name ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500 text-sm">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('transactionChart'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Masuk',
                    data: @json($chartIncoming),
                    borderColor: '#4ade80',
                    backgroundColor: 'rgba(74,222,128,0.08)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#4ade80',
                    borderWidth: 2,
                },
                {
                    label: 'Keluar',
                    data: @json($chartOutgoing),
                    borderColor: '#f87171',
                    backgroundColor: 'rgba(248,113,113,0.08)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#f87171',
                    borderWidth: 2,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: '#6b7280', font: { size: 11 } }, grid: { color: '#1f2937' } },
                y: { ticks: { color: '#6b7280', font: { size: 11 }, stepSize: 1 }, grid: { color: '#374151' }, beginAtZero: true }
            }
        }
    });
</script>

@endsection
