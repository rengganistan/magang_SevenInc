<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\StockTransaction;

class ReportRepository
{
    public function stock()
    {
        return Product::with('category')
            ->orderBy('nama')
            ->get();
    }

    public function incoming()
    {
        return StockTransaction::with(['product', 'user'])
            ->where('type', 'Masuk')
            ->latest()
            ->get();
    }

    public function outgoing()
    {
        return StockTransaction::with(['product', 'user'])
            ->where('type', 'Keluar')
            ->latest()
            ->get();
    }
}
