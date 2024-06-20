<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\{HomeController, UserController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman Customer
Route::get('/', [FrontEndController::class, 'index']);
Route::get('/our-products', [FrontEndController::class, 'product']);
Route::post('/our-products/checkout', [FrontEndController::class, 'checkout']);
Route::get('/our-products/checkout/success', [FrontEndController::class, 'checkoutSuccess']);
Route::post('/our-products/checkout/update-stock/{id}', [FrontEndController::class, 'updateStock']);
Route::get('/our-products/{slug}', [FrontEndController::class, 'productDetail']);

// Halaman Admin
Auth::routes([
    'register' => false,
]);
Route::middleware(['auth'])->group(function () {
    Route::prefix('dasbor')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('transactions', TransactionController::class);
    });
});
