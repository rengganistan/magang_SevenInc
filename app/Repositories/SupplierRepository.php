<?php

namespace App\Repositories;

use App\Models\Supplier;

class SupplierRepository
{
    public function getAll()
    {
        return Supplier::latest()->get();
    }

    public function findById($id)
    {
        return Supplier::findOrFail($id);
    }

    public function create(array $data)
    {
        return Supplier::create($data);
    }

    public function update($id, array $data)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update($data);

        return $supplier;
    }

    public function delete($id)
    {
        return Supplier::destroy($id);
    }
}
