<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

    Route::resource('categories', CategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | PRODUCT IMPORT EXPORT
    |--------------------------------------------------------------------------
    */

    Route::get('/products/export', [ProductController::class, 'export'])
        ->name('products.export');

    Route::post('/products/import', [ProductController::class, 'import'])
        ->name('products.import');

    Route::get(
    '/products/template',
    [ProductController::class, 'downloadTemplate']
)->name('products.template');

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS
    |--------------------------------------------------------------------------
    */

    Route::resource('products', ProductController::class)
        ->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | PRODUCT ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/products/{productId}/attributes',
        [ProductAttributeController::class, 'store']
    )->name('product-attributes.store');

    Route::delete(
        '/products/{productId}/attributes/{id}',
        [ProductAttributeController::class, 'destroy']
    )->name('product-attributes.destroy');

    /*
    |--------------------------------------------------------------------------
    | SUPPLIER
    |--------------------------------------------------------------------------
    */

    Route::resource('suppliers', SupplierController::class);

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI BARANG
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transactions/incoming',
        [StockTransactionController::class, 'incoming']
    )->name('transactions.incoming');

    Route::get(
        '/transactions/outgoing',
        [StockTransactionController::class, 'outgoing']
    )->name('transactions.outgoing');

    Route::get(
        '/transactions/create',
        [StockTransactionController::class, 'create']
    )->name('transactions.create');

    Route::post(
        '/transactions',
        [StockTransactionController::class, 'store']
    )->name('transactions.store');

    Route::get(
        '/transactions/{id}/edit',
        [StockTransactionController::class, 'edit']
    )->name('transactions.edit');

    Route::put(
        '/transactions/{id}',
        [StockTransactionController::class, 'update']
    )->name('transactions.update');

    Route::delete(
        '/transactions/{id}',
        [StockTransactionController::class, 'destroy']
    )->name('transactions.destroy');

    /*
    |--------------------------------------------------------------------------
    | STOCK OPNAME
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/stock-opname',
        [StockOpnameController::class, 'index']
    )->name('stock-opname.index');

    Route::get(
        '/stock-opname/create',
        [StockOpnameController::class, 'create']
    )->name('stock-opname.create');

    Route::post(
        '/stock-opname',
        [StockOpnameController::class, 'store']
    )->name('stock-opname.store');

    Route::get(
        '/stock-opname/{id}',
        [StockOpnameController::class, 'show']
    )->name('stock-opname.show');

    Route::post(
        '/stock-opname/{id}/selesaikan',
        [StockOpnameController::class, 'selesaikan']
    )->name('stock-opname.selesaikan');

    Route::delete(
        '/stock-opname/{id}',
        [StockOpnameController::class, 'destroy']
    )->name('stock-opname.destroy');

    /*
    |--------------------------------------------------------------------------
    | REPORT
    |--------------------------------------------------------------------------
    */

    Route::prefix('reports')->group(function () {

        Route::get('/stock', [ReportController::class, 'stock'])
            ->name('reports.stock');

        Route::get('/transaction', [ReportController::class, 'transaction'])
            ->name('reports.transaction');

        Route::get('/activity', [ReportController::class, 'activity'])
            ->name('reports.activity');
    });

    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/settings',
        [SettingController::class, 'index']
    )->name('settings.index');

    Route::put(
        '/settings/{id}',
        [SettingController::class, 'update']
    )->name('settings.update');

});

/*
|--------------------------------------------------------------------------
| MANAGER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    Route::get('/manager/dashboard', [DashboardController::class, 'manager'])
        ->name('manager.dashboard');

});

/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {

    Route::get('/staff/dashboard', [DashboardController::class, 'staff'])
        ->name('staff.dashboard');

});
