<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [

        'product_id',

        'supplier_id',

        'user_id',

        'type',

        'quantity',

        'date',

        'status',

        'notes'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIncomingTransactions()
{
    return $this->repository->incoming();
}

public function getOutgoingTransactions()
{
    return $this->repository->outgoing();
}
}
