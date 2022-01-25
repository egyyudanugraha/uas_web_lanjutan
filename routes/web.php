<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('get/list_category', [ProductController::class, 'list_category'])->name('product.category');
Route::resource('/', DashboardController::class);
Route::resource('product', ProductController::class);
Route::resource('category', CategoryController::class);
Route::resource('warehouse', WarehouseController::class);
Route::resource('inventory', InventoryController::class);
