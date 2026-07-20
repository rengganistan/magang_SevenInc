<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\StockTransactionController;
use App\Http\Controllers\Admin\StockOpnameController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FinanceReportController;
use App\Http\Controllers\Manager\ManagerProductController;
use App\Http\Controllers\Manager\ManagerStockTransactionController;
use App\Http\Controllers\Manager\ManagerStockOpnameController;
use App\Http\Controllers\Manager\ManagerSupplierController;
use App\Http\Controllers\Manager\ManagerReportController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\StaffStockTransactionController;
use App\Http\Controllers\Staff\StaffProductController;

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

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request')
    ->middleware('guest');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email')
    ->middleware('guest');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset')
    ->middleware('guest');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update')
    ->middleware('guest');

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

    Route::post(
        '/transactions/{id}/confirm',
        [StockTransactionController::class, 'confirm']
    )->name('transactions.confirm');

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

        Route::get('/finance', [FinanceReportController::class, 'index'])
            ->name('reports.finance');
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

Route::middleware(['auth', 'role:admin,manager'])->prefix('manager')->name('manager.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'manager'])
        ->name('dashboard');

    // Produk
    Route::resource('products', ManagerProductController::class);

    // Transaksi Barang
    Route::get('/transactions/incoming', [ManagerStockTransactionController::class, 'incoming'])
        ->name('transactions.incoming');

    Route::get('/transactions/outgoing', [ManagerStockTransactionController::class, 'outgoing'])
        ->name('transactions.outgoing');

    Route::get('/transactions/create', [ManagerStockTransactionController::class, 'create'])
        ->name('transactions.create');

    Route::post('/transactions', [ManagerStockTransactionController::class, 'store'])
        ->name('transactions.store');

    Route::delete('/transactions/{id}', [ManagerStockTransactionController::class, 'destroy'])
        ->name('transactions.destroy');

    Route::post('/transactions/{id}/confirm', [ManagerStockTransactionController::class, 'confirm'])
        ->name('transactions.confirm');

    // Stock Opname
    Route::get('/stock-opname', [ManagerStockOpnameController::class, 'index'])
        ->name('stock-opname.index');

    Route::get('/stock-opname/create', [ManagerStockOpnameController::class, 'create'])
        ->name('stock-opname.create');

    Route::post('/stock-opname', [ManagerStockOpnameController::class, 'store'])
        ->name('stock-opname.store');

    Route::get('/stock-opname/{id}', [ManagerStockOpnameController::class, 'show'])
        ->name('stock-opname.show');

    Route::post('/stock-opname/{id}/selesaikan', [ManagerStockOpnameController::class, 'selesaikan'])
        ->name('stock-opname.selesaikan');

    Route::delete('/stock-opname/{id}', [ManagerStockOpnameController::class, 'destroy'])
        ->name('stock-opname.destroy');

    // Supplier (read-only)
    Route::get('/suppliers', [ManagerSupplierController::class, 'index'])
        ->name('suppliers.index');

    // Laporan
    Route::get('/reports/stock', [ManagerReportController::class, 'stock'])
        ->name('reports.stock');

    Route::get('/reports/transaction', [ManagerReportController::class, 'transaction'])
        ->name('reports.transaction');

});

/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,staff'])->prefix('staff')->name('staff.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])
        ->name('dashboard');

    // Produk (read-only)
    Route::get('/products', [StaffProductController::class, 'index'])
        ->name('products.index');
    Route::get('/products/{id}', [StaffProductController::class, 'show'])
        ->name('products.show');

    // Transaksi
    Route::get('/transactions/incoming', [StaffStockTransactionController::class, 'incoming'])
        ->name('transactions.incoming');
    Route::get('/transactions/outgoing', [StaffStockTransactionController::class, 'outgoing'])
        ->name('transactions.outgoing');
    Route::get('/transactions/create', [StaffStockTransactionController::class, 'create'])
        ->name('transactions.create');
    Route::post('/transactions', [StaffStockTransactionController::class, 'store'])
        ->name('transactions.store');
    Route::post('/transactions/{id}/confirm', [StaffStockTransactionController::class, 'confirm'])
        ->name('transactions.confirm');

});
