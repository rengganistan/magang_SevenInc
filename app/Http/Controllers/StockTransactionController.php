<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\StockTransactionService;

class StockTransactionController extends Controller
{
    protected StockTransactionService $service;

    public function __construct(
        StockTransactionService $service
    )
    {
        $this->service = $service;
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function incoming()
{
    $transactions = $this->service
        ->getIncomingTransactions();

    return view(
        'stock-transactions.incoming',
        compact('transactions')
    );
}

public function outgoing()
{
    $transactions = $this->service
        ->getOutgoingTransactions();

    return view(
        'stock-transactions.outgoing',
        compact('transactions')
    );
}

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $products = Product::orderBy('nama')
            ->get();

        return view(
            'stock-transactions.create',
            compact('products')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'product_id' => 'required|exists:products,id',

            'type' => 'required|in:Masuk,Keluar',

            'quantity' => 'required|integer|min:1',

            'date' => 'required|date',

            'status' => 'required',

            'notes' => 'nullable'

        ]);

        $validated['user_id'] = Auth::id();

        $this->service
            ->createTransaction($validated);

       return redirect()
    ->route('transactions.incoming');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $transaction = $this->service
            ->getTransactionById($id);

        $products = Product::orderBy('nama')
            ->get();

        return redirect()
    ->route('transactions.incoming');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    )
    {
        $validated = $request->validate([

            'product_id' => 'required',

            'type' => 'required',

            'quantity' => 'required|integer',

            'date' => 'required|date',

            'status' => 'required',

            'notes' => 'nullable'

        ]);

        $this->service
            ->updateTransaction(
                $id,
                $validated
            );

        return redirect()
    ->route('transactions.incoming');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $this->service
            ->deleteTransaction($id);

        return redirect()
            ->route('stock-transactions.index')
            ->with(
                'success',
                'Transaksi berhasil dihapus.'
            );
    }


    }


