<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('action');        // e.g. 'Tambah Produk', 'Login', 'Import Produk'
            $table->string('model')->nullable();   // e.g. 'Produk', 'Kategori', 'Supplier'
            $table->string('model_name')->nullable(); // nama item, e.g. nama produk
            $table->text('keterangan')->nullable();   // detail tambahan jika ada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
