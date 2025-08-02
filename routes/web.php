<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () { return redirect()->route('dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');

    Route::resource('clients', ClientController::class);
    Route::post('clients/import', [ClientController::class, 'import'])->name('clients.import');

    Route::resource('quotations', QuotationController::class)->except(['show']);
    Route::get('quotations/{quotation}/pdf', [QuotationController::class, 'pdf'])->name('quotations.pdf');
    Route::get('quotations/{quotation}/show', [QuotationController::class, 'show'])->name('quotations.show');

    Route::resource('sales', SaleController::class)->except(['show']);
    Route::get('sales/{sale}/show', [SaleController::class, 'show'])->name('sales.show');

    Route::resource('costs', CostController::class)->except(['show','edit','update']);
    Route::get('costs/{cost}/download', [CostController::class, 'download'])->name('costs.download');
    Route::get('/costs/{cost}/preview', [CostController::class, 'preview'])->name('costs.preview');


    Route::resource('providers', ProviderController::class)->except(['show']);
});
