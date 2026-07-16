<?php

namespace App\Http\Controllers;

use App\Services\ReportService;

class ReportController extends Controller
{
    protected $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function stock()
    {
        $products = $this->service->stock();

        return view('reports.stock', compact('products'));
    }

    public function incoming()
    {
        $transactions = $this->service->incoming();

        return view('reports.incoming', compact('transactions'));
    }

    public function outgoing()
    {
        $transactions = $this->service->outgoing();

        return view('reports.outgoing', compact('transactions'));
    }
}
