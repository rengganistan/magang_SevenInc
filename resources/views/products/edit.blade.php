@extends('layouts.dashboard')

@section('content')

<div class="w-full px-4 py-6 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

        <div>

            <p class="text-sm text-gray-400 mb-2">
                Dashboard / Produk / Edit
            </p>

            <h1 class="text-4xl font-bold text-white">
                Edit Produk
            </h1>

            <p class="text-gray-400 mt-2">
                Perbarui informasi produk yang sudah ada.
            </p>

        </div>

        <a href="{{ route('products.index') }}"
            class="px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">

            ← Kembali

        </a>

    </div>

    {{-- Error --}}
    @if($errors->any())

    <div class="mb-6 rounded-xl border border-red-700 bg-red-900/40 p-5">

        <h3 class="text-red-300 font-semibold mb-3">
            Terjadi Kesalahan
        </h3>

        <ul class="list-disc list-inside text-red-300 space-y-1">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <div class="rounded-2xl bg-gray-800 border border-gray-700 shadow-xl">

        <form
            action="{{ route('products.update',$product->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="p-8">

                {{-- Preview --}}
                <div class="flex flex-col items-center mb-10">

                    @if($product->gambar)

                        <img
                            id="preview-image"
                            src="{{ asset('storage/'.$product->gambar) }}"
                            class="w-48 h-48 rounded-xl object-cover border-4 border-gray-700 shadow-lg">

                    @else

                        <img
                            id="preview-image"
                            src="https://placehold.co/300x300/1F2937/FFFFFF?text=No+Image"
                            class="w-48 h-48 rounded-xl object-cover border-4 border-gray-700 shadow-lg">

                    @endif

                    <p class="mt-3 text-gray-400 text-sm">
                        Preview Produk
                    </p>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kode --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Kode Produk
                        </label>

                        <input
                            type="text"
                            name="kode"
                            value="{{ old('kode',$product->kode) }}"
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
                            value="{{ old('nama',$product->nama) }}"
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

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id',$product->category_id)==$category->id ? 'selected':'' }}>

                                    {{ $category->name }}

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
                            value="{{ old('satuan',$product->satuan) }}"
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
                            value="{{ old('harga_beli',$product->harga_beli) }}"
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
                            value="{{ old('harga_jual',$product->harga_jual) }}"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                    {{-- Stok --}}
                    <div>

                        <label class="block mb-2 text-gray-300 font-semibold">
                            Stok
                        </label>

                        <input
                            type="number"
                            name="stok"
                            value="{{ old('stok',$product->stok) }}"
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
                            value="{{ old('stok_minimum',$product->stok_minimum) }}"
                            class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">

                    </div>

                </div>

                {{-- Deskripsi --}}
                <div class="mt-6">

                    <label class="block mb-2 text-gray-300 font-semibold">
                        Deskripsi
                    </label>

                    <textarea
                        rows="5"
                        name="deskripsi"
                        class="w-full rounded-xl border border-gray-600 bg-gray-700 text-white px-4 py-3">{{ old('deskripsi',$product->deskripsi) }}</textarea>

                </div>

                {{-- Upload --}}
                <div class="mt-6">

                    <label class="block mb-2 text-gray-300 font-semibold">
                        Ganti Foto Produk
                    </label>

                    <input
                        id="gambar"
                        type="file"
                        name="gambar"
                        accept="image/*"
                        class="block w-full rounded-xl border border-gray-600 bg-gray-700 text-white
                        file:bg-blue-600
                        file:border-0
                        file:px-5
                        file:py-3
                        file:text-white
                        file:rounded-lg
                        hover:file:bg-blue-700">

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

                        💾 Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

const input=document.getElementById('gambar');

const preview=document.getElementById('preview-image');

input.addEventListener('change',function(){

    const file=this.files[0];

    if(file){

        const reader=new FileReader();

        reader.onload=function(e){

            preview.src=e.target.result;

        }

        reader.readAsDataURL(file);

    }

});

</script>

@endsection
