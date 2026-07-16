<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\SupplierService;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    protected SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index(): View
    {
        $suppliers = $this->supplierService->getSuppliers();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([

            'name' => 'required|max:255',

            'address' => 'nullable',

            'phone' => 'nullable|max:20',

            'email' => 'nullable|email'

        ]);

        $this->supplierService->createSupplier($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $supplier = $this->supplierService->getSupplierById($id);

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([

            'name' => 'required|max:255',

            'address' => 'nullable',

            'phone' => 'nullable|max:20',

            'email' => 'nullable|email'

        ]);

        $this->supplierService->updateSupplier($id, $validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->supplierService->deleteSupplier($id);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
