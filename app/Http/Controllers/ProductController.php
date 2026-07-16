<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Menampilkan daftar produk.
     */
    public function index(): View
    {
        $products = $this->productService->getProducts();

        return view('products.index', compact('products'));
    }

    /**
     * Form tambah produk.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Simpan produk.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([

            'kode'           => 'required|unique:products,kode',
            'nama'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'satuan'         => 'required|string|max:100',
            'stok'           => 'required|integer',
            'stok_minimum'   => 'required|integer',
            'harga_beli'     => 'required|numeric',
            'harga_jual'     => 'required|numeric',
            'deskripsi'      => 'nullable|string',

            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {

            $validated['gambar'] = $request
                ->file('gambar')
                ->store('products', 'public');

        }

        $this->productService->createProduct($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit.
     */
    public function edit(int $id): View
    {
        $product = $this->productService->getProductById($id);

        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update produk.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([

            'kode' => 'required|unique:products,kode,' . $id,

            'nama' => 'required|string|max:255',

            'category_id' => 'required|exists:categories,id',

            'satuan' => 'required|string|max:100',

            'stok' => 'required|integer',

            'stok_minimum' => 'required|integer',

            'harga_beli' => 'required|numeric',

            'harga_jual' => 'required|numeric',

            'deskripsi' => 'nullable|string',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        // Upload gambar baru
        if ($request->hasFile('gambar')) {

            $validated['gambar'] = $request
                ->file('gambar')
                ->store('products', 'public');

        }

        $this->productService->updateProduct($id, $validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->productService->deleteProduct($id);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
