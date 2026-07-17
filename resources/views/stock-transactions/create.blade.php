@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

        <div>

            <p class="text-sm text-gray-400 mb-2">
                Dashboard / Transaksi /
                {{ $type === 'Masuk' ? 'Barang Masuk' : 'Barang Keluar' }}
                / Tambah
            </p>

            <h1 class="text-3xl lg:text-4xl font-bold text-white">
                Tambah {{ $type === 'Masuk' ? 'Barang Masuk' : 'Barang Keluar' }}
            </h1>

            <p class="mt-2 text-gray-400">
                Catat transaksi {{ $type === 'Masuk' ? 'penerimaan' : 'pengeluaran' }} barang.
            </p>

        </div>

        <a href="{{ $type === 'Masuk' ? route('transactions.incoming') : route('transactions.outgoing') }}"
            class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">

            ← Kembali

        </a>

    </div>

    {{-- Error --}}
    @if ($errors->any())

    <div class="mb-6 rounded-xl border border-red-700 bg-red-900/40 p-4">

        <ul class="list-disc list-inside text-red-300">

            @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <div class="rounded-2xl border border-gray-700 bg-gray-800 shadow-xl">

        <form action="{{ route('transactions.store') }}" method="POST">

            @csrf

            {{-- Type tersimpan sebagai hidden, tidak perlu dropdown --}}
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Produk --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Produk
                        </label>

                        <select
                            name="product_id"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                            <option value="">-- Pilih Produk --</option>

                            @foreach($products as $product)

                            <option
                                value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>

                                {{ $product->nama }} (Stok: {{ $product->stok }})

                            </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Supplier (hanya tampil saat Barang Masuk) --}}
                    @if($type === 'Masuk')

                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Supplier
                        </label>

                        <select
                            name="supplier_id"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                            <option value="">-- Pilih Supplier --</option>

                            @foreach($suppliers as $supplier)

                            <option
                                value="{{ $supplier->id }}"
                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>

                                {{ $supplier->nama }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    @endif

                    {{-- Qty --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Jumlah Barang
                        </label>

                        <input
                            type="number"
                            min="1"
                            name="quantity"
                            value="{{ old('quantity') }}"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                    {{-- Tanggal --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            name="date"
                            value="{{ old('date', date('Y-m-d')) }}"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                    {{-- Status --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Status
                        </label>

                        <select
                            name="status"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                            @if($type === 'Masuk')

                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Diterima" {{ old('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>

                            @else

                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Dikeluarkan" {{ old('status') == 'Dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                                <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>

                            @endif

                        </select>

                    </div>

                </div>

                {{-- Catatan --}}
                <div class="mt-6">

                    <label class="block mb-2 text-gray-300 font-semibold">
                        Catatan
                    </label>

                    <textarea
                        name="notes"
                        rows="4"
                        placeholder="Tambahkan catatan (opsional)..."
                        class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3 resize-none">{{ old('notes') }}</textarea>

                </div>

            </div>

            <div class="border-t border-gray-700 p-6">

                <div class="flex flex-col sm:flex-row justify-end gap-3">

                    <a href="{{ $type === 'Masuk' ? route('transactions.incoming') : route('transactions.outgoing') }}"
                        class="px-6 py-3 rounded-xl bg-gray-600 hover:bg-gray-500 text-white text-center">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl {{ $type === 'Masuk' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white">

                        💾 Simpan {{ $type === 'Masuk' ? 'Barang Masuk' : 'Barang Keluar' }}

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
