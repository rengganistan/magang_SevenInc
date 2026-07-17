<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [

        'kode',

        'nama',

        'category_id',

        'supplier_id',

        'satuan',

        'stok',

        'stok_minimum',

        'harga_beli',

        'harga_jual',

        'gambar',

        'deskripsi'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
