@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
        <div>
            <p class="text-sm text-gray-400 mb-2">Dashboard / Laporan / Stok</p>
            <h1 class="text-3xl lg:text-4xl font-bold text-white">Laporan Stok Barang</h1>
            <p class="mt-2 text-gray-400">Menampilkan seluruh stok barang berdasarkan kategori.</p>
        </div>
        <a href="{{ route('manager.dashboard') }}"
            class="px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">
            ← Dashboard
        </a>
    </div>

    {{-- Filter --}}
    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 mb-8">
        <form method="GET" action="{{ route('manager.reports.stock') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div>
                    <label class="block mb-2 text-gray-300 text-sm font-medium">Kategori</label>
                    <select name="category"
                        class="w-full rounded-xl bg-gray-700 border border-gray-600 text-white px-4 py-3">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-gray-300 text-sm font-medium">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full rounded-xl bg-gray-700 border border-gray-600 text-white px-4 py-3">
                </div>
                <div>
                    <label class="block mb-2 text-gray-300 text-sm font-medium">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full rounded-xl bg-gray-700 border border-gray-600 text-white px-4 py-3">
                </div>
                <div class="flex items-end gap-2">
                    <button class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl text-white font-medium">
                        🔍 Filter
                    </button>
                    @if(request('category') || request('start_date') || request('end_date'))
                        <a href="{{ route('manager.reports.stock') }}"
                            class="px-4 py-3 bg-gray-600 hover:bg-gray-500 rounded-xl text-white">
                            ✕
                        </a>
                    @endif
                </div>
            </div>

            {{-- Active filter badges --}}
            @if(request('category') || request('start_date') || request('end_date'))
            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-700">
                <span class="text-xs text-gray-400">Filter aktif:</span>
                @if(request('category'))
                    <span class="px-2 py-1 rounded-full bg-blue-600/20 text-blue-400 text-xs">
                        Kategori: {{ $categories->firstWhere('id', request('category'))->nama ?? '-' }}
                    </span>
                @endif
                @if(request('start_date'))
                    <span class="px-2 py-1 rounded-full bg-blue-600/20 text-blue-400 text-xs">
                        Dari: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                    </span>
                @endif
                @if(request('end_date'))
                    <span class="px-2 py-1 rounded-full bg-blue-600/20 text-blue-400 text-xs">
                        Sampai: {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                    </span>
                @endif
            </div>
            @endif
        </form>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="rounded-xl border border-gray-700 bg-gray-800 p-4 text-center">
            <p class="text-xs text-gray-400 mb-1">Total Produk</p>
            <p class="text-2xl font-bold text-white">{{ $products->count() }}</p>
        </div>
        <div class="rounded-xl border border-gray-700 bg-gray-800 p-4 text-center">
            <p class="text-xs text-gray-400 mb-1">Stok Aman</p>
            <p class="text-2xl font-bold text-green-400">
                {{ $products->filter(fn($p) => $p->stok > $p->stok_minimum)->count() }}
            </p>
        </div>
        <div class="rounded-xl border border-gray-700 bg-gray-800 p-4 text-center">
            <p class="text-xs text-gray-400 mb-1">Menipis / Habis</p>
            <p class="text-2xl font-bold text-red-400">
                {{ $products->filter(fn($p) => $p->stok <= $p->stok_minimum)->count() }}
            </p>
        </div>
    </div>

    {{-- Table --}}
    @php
        $showAll   = request()->boolean('show_all');
        $displayed = $showAll ? $products : $products->take(25);
        $remaining = $products->count() - 25;
    @endphp

    <div class="overflow-hidden rounded-2xl border border-gray-700 bg-gray-800 shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-gray-300">No</th>
                        <th class="px-6 py-4 text-left text-gray-300">Produk</th>
                        <th class="px-6 py-4 text-left text-gray-300">Kategori</th>
                        <th class="px-6 py-4 text-left text-gray-300">Supplier</th>
                        <th class="px-6 py-4 text-center text-gray-300">Stok</th>
                        <th class="px-6 py-4 text-center text-gray-300">Min</th>
                        <th class="px-6 py-4 text-center text-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($displayed as $product)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-6 py-4 text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-white font-semibold">{{ $product->nama }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $product->category->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $product->supplier->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold text-white">{{ $product->stok }}</td>
                        <td class="px-6 py-4 text-center text-gray-400">{{ $product->stok_minimum }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($product->stok == 0)
                                <span class="px-3 py-1 rounded-full bg-red-600/20 text-red-400 text-xs font-semibold">Habis</span>
                            @elseif($product->stok <= $product->stok_minimum)
                                <span class="px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-xs font-semibold">Menipis</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-green-600/20 text-green-400 text-xs font-semibold">Aman</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center text-gray-400">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer: tombol lihat semua / sembunyikan --}}
        @if($products->count() > 25)
        <div class="border-t border-gray-700 px-6 py-4 flex items-center justify-between">
            <p class="text-sm text-gray-400">
                Menampilkan <span class="text-white font-semibold">{{ $displayed->count() }}</span>
                dari <span class="text-white font-semibold">{{ $products->count() }}</span> produk
            </p>
            @if(!$showAll)
                <a href="{{ request()->fullUrlWithQuery(['show_all' => '1']) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    Lihat Semua (+{{ $remaining }} lainnya)
                </a>
            @else
                <a href="{{ request()->fullUrlWithQuery(['show_all' => null]) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-600 hover:bg-gray-500 text-white text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    </svg>
                    Sembunyikan
                </a>
            @endif
        </div>
        @endif
    </div>

</div>

@endsection
