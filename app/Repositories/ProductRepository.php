<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{
    /**
     * Ambil semua produk beserta kategori.
     */
    public function getAll()
    {
        return Product::with([
            'category',
            'supplier',
            'attributes'
        ])
        ->latest()
        ->paginate(10);
    }

    /**
     * Cari produk berdasarkan ID.
     */
    public function findById($id)
    {
        return Product::findOrFail($id);
    }

    /**
     * Simpan produk baru.
     */
    public function create(array $data)
    {
        return Product::create($data);
    }

    /**
     * Update produk.
     */
    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar lama jika ada gambar baru
        if (isset($data['gambar']) && $product->gambar) {

            Storage::disk('public')->delete($product->gambar);

        }

        $product->update($data);

        return $product;
    }

    /**
     * Hapus produk.
     */
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage
        if ($product->gambar) {

            Storage::disk('public')->delete($product->gambar);

        }

        return $product->delete();
    }
}
