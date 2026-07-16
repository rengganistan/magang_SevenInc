<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {

        $table->id();

        $table->foreignId('category_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('supplier_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        $table->string('kode')->unique();

        $table->string('nama');

        $table->integer('stok')->default(0);

        $table->integer('stok_minimum')->default(5);

        $table->string('satuan');

        $table->decimal('harga_beli',15,2);

        $table->decimal('harga_jual',15,2);

        $table->string('gambar')->nullable();

        $table->text('deskripsi')->nullable();

        $table->timestamps();

    });
}
};
