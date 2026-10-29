<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadImportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\StoreBillingController;

use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // dashboard
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');

    // user
    Route::get('user-index', [UserController::class, 'index'])->name('user.index');
    Route::get('get-user', [UserController::class, 'getusers'])->name('user.get');
    Route::get('user-create', [UserController::class, 'create'])->name('user.create');
    Route::post('user-store', [UserController::class, 'store'])->name('user.store');
    Route::get('user-edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::PUT('user-update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user-delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    // Customers
    Route::get('customer-index', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('get-customer', [CustomerController::class, 'getCustomers'])->name('customer.get');
    Route::get('customer-create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer-store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer-edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::PUT('customer-update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('customer-delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

    // products
    Route::get('product-index', [ProductsController::class, 'index'])->name('product.index');
    Route::get('get-product', [ProductsController::class, 'getProducts'])->name('product.get');
    Route::get('product-create', [ProductsController::class, 'create'])->name('product.create');
    Route::post('product-store', [ProductsController::class, 'store'])->name('product.store');
    Route::get('product-edit/{id}', [ProductsController::class, 'edit'])->name('product.edit');
    Route::PUT('product-update/{id}', [ProductsController::class, 'update'])->name('product.update');

  
    // Store Billing
    Route::get('/store-billing', [StoreBillingController::class, 'create'])->name('billing.create');
    Route::get('/store-billing/customer', [StoreBillingController::class, 'customerLookup'])->name('billing.customer');
    Route::post('/store-billing/order', [StoreBillingController::class, 'store'])->name('billing.store');
    Route::get('/store-billing/bill/{order}', [StoreBillingController::class, 'show'])->name('billing.show');

    // Orders
    Route::get('/customer-order-history-view', [CustomerOrderController::class, 'viewOrderHistory'])
        ->name('customer.order.history.view');
    Route::get('/customer/order-history', [CustomerOrderController::class, 'orderHistory'])
        ->name('customer.order.history');

});
