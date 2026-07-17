@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

        <div>

            <p class="text-sm text-gray-400 mb-2">
                Dashboard / Produk / Tambah
            </p>

            <h1 class="text-4xl font-bold text-white">
                Tambah Produk
            </h1>

            <p class="text-gray-400 mt-2">
                Tambahkan produk baru ke dalam sistem inventory.
            </p>

        </div>

        <a
            href="{{ route('products.index') }}"
            class="px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">

            ← Kembali

        </a>

    </div>

    {{-- Error --}}
    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-700 bg-red-900/40 p-5">

            <h3 class="text-red-300 font-semibold mb-2">
                Terjadi kesalahan
            </h3>

            <ul class="list-disc list-inside text-red-300 space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="rounded-2xl border border-gray-700 bg-gray-800 shadow-xl">

        <form
            action="{{ route('products.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kode --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Kode Produk
                        </label>

                        <input
                            type="text"
                            name="kode"
                            value="{{ old('kode') }}"
                            placeholder="PRD001"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3 focus:ring-2 focus:ring-blue-500">

                    </div>

                    {{-- Nama --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Nama Produk
                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Nama Produk"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3 focus:ring-2 focus:ring-blue-500">

                    </div>

                    {{-- Kategori --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Kategori
                        </label>

                        <select
                            name="category_id"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                            <option value="">-- Pilih Kategori --</option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id')==$category->id?'selected':'' }}>

                                    {{ $category->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Supplier --}}
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
                                    {{ old('supplier_id')==$supplier->id ? 'selected' : '' }}>

                                    {{ $supplier->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Satuan --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Satuan
                        </label>

                        <input
                            type="text"
                            name="satuan"
                            value="{{ old('satuan') }}"
                            placeholder="pcs / box / kg"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                    {{-- Harga Beli --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Harga Beli
                        </label>

                        <input
                            type="number"
                            name="harga_beli"
                            value="{{ old('harga_beli') }}"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                    {{-- Harga Jual --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Harga Jual
                        </label>

                        <input
                            type="number"
                            name="harga_jual"
                            value="{{ old('harga_jual') }}"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                    {{-- Stok --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Stok Awal
                        </label>

                        <input
                            type="number"
                            name="stok"
                            value="{{ old('stok',0) }}"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                    {{-- Minimum --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Stok Minimum
                        </label>

                        <input
                            type="number"
                            name="stok_minimum"
                            value="{{ old('stok_minimum',5) }}"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                </div>

                {{-- Deskripsi --}}
                <div class="mt-6">

                    <label class="block mb-2 text-gray-300 font-semibold">
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="5"
                        class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">{{ old('deskripsi') }}</textarea>

                </div>

                {{-- Upload --}}
                <div class="mt-8">

                    <label class="block mb-2 text-gray-300 font-semibold">
                        Foto Produk
                    </label>

                    <input
                        id="gambar"
                        type="file"
                        name="gambar"
                        accept="image/*"
                        class="block w-full rounded-xl border border-gray-600 bg-gray-700 text-white
                        file:bg-blue-600
                        file:border-0
                        file:text-white
                        file:px-5
                        file:py-3
                        file:rounded-lg
                        hover:file:bg-blue-700">

                </div>

                {{-- Preview --}}
                <div class="mt-6">

                    <img
                        id="preview-image"
                        src="#"
                        class="hidden w-48 h-48 rounded-xl object-cover border-2 border-gray-600 shadow-lg">

                </div>

            </div>

            <div class="border-t border-gray-700 p-6">

                <div class="flex flex-col sm:flex-row justify-end gap-3">

                    <a
                        href="{{ route('products.index') }}"
                        class="px-6 py-3 rounded-xl bg-gray-600 hover:bg-gray-500 text-white text-center">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold">

                        💾 Simpan Produk

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- Preview Image --}}
<script>

const input=document.getElementById('gambar');

const preview=document.getElementById('preview-image');

input.addEventListener('change',function(){

const file=this.files[0];

if(file){

const reader=new FileReader();

reader.onload=function(e){

preview.src=e.target.result;

preview.classList.remove('hidden');

}

reader.readAsDataURL(file);

}

});

</script>

@endsection
