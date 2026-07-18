@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <p class="text-sm text-gray-400 mb-1">Dashboard / Laporan / Keuangan</p>
            <h1 class="text-3xl lg:text-4xl font-bold text-white">Laporan Keuangan</h1>
            <p class="mt-1 text-gray-400 text-sm">
                Periode: <span class="text-white font-medium">{{ $start->format('d M Y') }}</span>
                s/d <span class="text-white font-medium">{{ $end->format('d M Y') }}</span>
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
            class="self-start lg:self-auto px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">
            ← Dashboard
        </a>
    </div>

    {{-- Filter Periode --}}
    <div class="rounded-2xl border border-gray-700 bg-gray-800 p-6">
        <form action="{{ route('reports.finance') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block mb-2 text-gray-300 text-sm font-medium">Dari Tanggal</label>
                    <input type="date" name="start_date"
                        value="{{ request('start_date', $start->toDateString()) }}"
                        class="w-full rounded-xl bg-gray-700 border border-gray-600 text-white px-4 py-3">
                </div>
                <div>
                    <label class="block mb-2 text-gray-300 text-sm font-medium">Sampai Tanggal</label>
                    <input type="date" name="end_date"
                        value="{{ request('end_date', $end->toDateString()) }}"
                        class="w-full rounded-xl bg-gray-700 border border-gray-600 text-white px-4 py-3">
                </div>
                <div class="flex items-end gap-2">
                    <button class="flex-1 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium">
                        🔍 Filter
                    </button>
                    {{-- Shortcut periode --}}
                    <a href="{{ route('reports.finance', ['start_date' => now()->startOfMonth()->toDateString(), 'end_date' => now()->toDateString()]) }}"
                        class="px-3 py-3 rounded-xl bg-gray-600 hover:bg-gray-500 text-white text-xs whitespace-nowrap">
                        Bulan Ini
                    </a>
                    <a href="{{ route('reports.finance', ['start_date' => now()->startOfYear()->toDateString(), 'end_date' => now()->toDateString()]) }}"
                        class="px-3 py-3 rounded-xl bg-gray-600 hover:bg-gray-500 text-white text-xs whitespace-nowrap">
                        Tahun Ini
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Modal Masuk --}}
        <div class="rounded-xl border border-green-700/50 bg-green-900/10 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="p-2 rounded-lg bg-green-600/20">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-400">Total Modal Masuk</p>
            </div>
            <p class="text-2xl font-bold text-green-400">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-500 mt-1">{{ $qtyMasuk }} item masuk × harga beli</p>
        </div>

        {{-- Nilai Keluar --}}
        <div class="rounded-xl border border-red-700/50 bg-red-900/10 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="p-2 rounded-lg bg-red-600/20">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-3.707-8.707l3-3a1 1 0 011.414 1.414L9.414 9H13a1 1 0 110 2H9.414l1.293 1.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-400">Nilai Barang Keluar</p>
            </div>
            <p class="text-2xl font-bold text-red-400">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-500 mt-1">{{ $qtyKeluar }} item keluar × harga jual</p>
        </div>

        {{-- Keuntungan / Selisih --}}
        <div class="rounded-xl border border-{{ $selisih >= 0 ? 'blue' : 'orange' }}-700/50 bg-{{ $selisih >= 0 ? 'blue' : 'orange' }}-900/10 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="p-2 rounded-lg bg-{{ $selisih >= 0 ? 'blue' : 'orange' }}-600/20">
                    <svg class="w-5 h-5 text-{{ $selisih >= 0 ? 'blue' : 'orange' }}-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-400">{{ $selisih >= 0 ? 'Keuntungan' : 'Kerugian' }}</p>
            </div>
            <p class="text-2xl font-bold text-{{ $selisih >= 0 ? 'blue' : 'orange' }}-400">
                {{ $selisih >= 0 ? '+' : '' }}Rp {{ number_format(abs($selisih), 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-500 mt-1">Nilai keluar − modal masuk</p>
        </div>

        {{-- Total Transaksi --}}
        <div class="rounded-xl border border-gray-700 bg-gray-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="p-2 rounded-lg bg-gray-600/30">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-400">Total Transaksi</p>
            </div>
            <p class="text-2xl font-bold text-white">{{ $allTransactions->count() }}</p>
            <p class="text-xs text-gray-500 mt-1">
                <span class="text-green-400">{{ $qtyMasuk }} masuk</span>
                · <span class="text-red-400">{{ $qtyKeluar }} keluar</span>
            </p>
        </div>

    </div>

    {{-- Grafik --}}
    <div class="rounded-2xl border border-gray-700 bg-gray-800 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-sm font-semibold text-white">Pergerakan Keuangan 6 Bulan Terakhir</h3>
            <div class="flex gap-4 text-xs text-gray-400">
                <span class="flex items-center gap-1.5">
                    <span class="inline-block w-3 h-3 rounded-full bg-green-400"></span>Modal Masuk
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="inline-block w-3 h-3 rounded-full bg-red-400"></span>Nilai Keluar
                </span>
            </div>
        </div>
        <canvas id="financeChart" height="80"></canvas>
    </div>

    {{-- Tabel Detail --}}
    @php
        $showAll   = request()->boolean('show_all');
        $displayed = $showAll ? $allTransactions : $allTransactions->take(25);
        $remaining = $allTransactions->count() - 25;
    @endphp

    <div class="rounded-2xl border border-gray-700 bg-gray-800 shadow-xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-700">
            <h3 class="text-sm font-semibold text-white">Detail Transaksi</h3>
            <span class="text-xs text-gray-400">{{ $allTransactions->count() }} transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-5 py-3 text-left text-gray-300 text-sm">No</th>
                        <th class="px-5 py-3 text-left text-gray-300 text-sm">Tanggal</th>
                        <th class="px-5 py-3 text-left text-gray-300 text-sm">Produk</th>
                        <th class="px-5 py-3 text-center text-gray-300 text-sm">Tipe</th>
                        <th class="px-5 py-3 text-center text-gray-300 text-sm">Qty</th>
                        <th class="px-5 py-3 text-right text-gray-300 text-sm">Harga Satuan</th>
                        <th class="px-5 py-3 text-right text-gray-300 text-sm">Total Nilai</th>
                        <th class="px-5 py-3 text-left text-gray-300 text-sm">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($displayed as $tx)
                    @php
                        $hargaSatuan = $tx->type === 'Masuk'
                            ? ($tx->product->harga_beli ?? 0)
                            : ($tx->product->harga_jual ?? 0);
                    @endphp
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="px-5 py-3 text-white text-sm">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3 text-gray-300 text-sm whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="text-white text-sm font-medium">{{ $tx->product->nama ?? '-' }}</div>
                            <div class="text-xs text-gray-400">{{ $tx->product->kode ?? '' }}</div>
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if($tx->type === 'Masuk')
                                <span class="px-2 py-1 rounded-full bg-green-600/20 text-green-400 text-xs font-semibold">↑ Masuk</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-red-600/20 text-red-400 text-xs font-semibold">↓ Keluar</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-center text-white font-semibold text-sm">{{ $tx->quantity }}</td>
                        <td class="px-5 py-3 text-right text-gray-300 text-sm">
                            Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3 text-right font-bold text-sm {{ $tx->type === 'Masuk' ? 'text-green-400' : 'text-red-400' }}">
                            Rp {{ number_format($tx->nilai, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3 text-gray-400 text-sm">{{ $tx->user->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-16 text-center text-gray-400">
                            Tidak ada transaksi pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                {{-- Total Footer --}}
                @if($allTransactions->count() > 0)
                <tfoot class="bg-gray-700/60">
                    <tr>
                        <td colspan="6" class="px-5 py-3 text-right text-gray-300 font-semibold text-sm">
                            Total Nilai Periode:
                        </td>
                        <td class="px-5 py-3 text-right text-sm font-bold text-white">
                            Rp {{ number_format($allTransactions->sum('nilai'), 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        {{-- Lihat semua --}}
        @if($allTransactions->count() > 25)
        <div class="border-t border-gray-700 px-6 py-4 flex items-center justify-between">
            <p class="text-sm text-gray-400">
                Menampilkan <span class="text-white font-semibold">{{ $displayed->count() }}</span>
                dari <span class="text-white font-semibold">{{ $allTransactions->count() }}</span> transaksi
            </p>
            @if(!$showAll)
                <a href="{{ request()->fullUrlWithQuery(['show_all' => '1']) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    Lihat Semua (+{{ $remaining }} lainnya)
                </a>
            @else
                <a href="{{ request()->fullUrlWithQuery(['show_all' => null]) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-600 hover:bg-gray-500 text-white text-sm font-semibold transition">
                    Sembunyikan
                </a>
            @endif
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('financeChart'), {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Modal Masuk (Rp)',
                    data: @json($chartBeli),
                    backgroundColor: 'rgba(74,222,128,0.7)',
                    borderRadius: 4,
                    borderSkipped: false,
                },
                {
                    label: 'Nilai Keluar (Rp)',
                    data: @json($chartJual),
                    backgroundColor: 'rgba(248,113,113,0.7)',
                    borderRadius: 4,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.dataset.label + ': Rp ' +
                                new Intl.NumberFormat('id-ID').format(ctx.raw);
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#6b7280', font: { size: 11 } },
                    grid: { color: '#1f2937' }
                },
                y: {
                    ticks: {
                        color: '#6b7280',
                        font: { size: 10 },
                        callback: function(v) {
                            if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1) + 'jt';
                            if (v >= 1000) return 'Rp ' + (v/1000).toFixed(0) + 'rb';
                            return 'Rp ' + v;
                        }
                    },
                    grid: { color: '#374151' },
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
