<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DeliveryController;

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


Route::get('/', [LoginController::class, 'showLogin'])->name('login'); 
Route::post('/login', [LoginController::class, 'login'])->name('postlogin');


// Rute untuk menampilkan daftar stock
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::put('/stock/{id}', [StockController::class, 'update'])->name('stock.update');
Route::delete('/stock/{id}', [StockController::class, 'destroy'])->name('stock.destroy');
// Route::post('/stock/import', [StockController::class, 'importExcel'])->name('stock.import');

// Rute untuk menampilkan daftar produksi
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::post('/productstore', [ProductController::class, 'store'])->name('product.store');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/prdoduct/import', [ProductController::class, 'importExcelProduct'])->name('product.import');


// Rute untuk menampilkan daftar delivery
Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery.index');
// Route::post('/productstore', [ProductController::class, 'store'])->name('product.store');
// Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
// Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
// Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/delivery/import', [DeliveryController::class, 'uploadDelivery'])->name('delivery.import');


// planning
Route::get('/planning', [PlanningController::class, 'index'])->name('planning.index');
Route::post('/planning/store', [PlanningController::class, 'store'])->name('planning.store');
Route::put('/planning/update/{id}', [PlanningController::class, 'update'])->name('planning.update');
Route::delete('/planning/delete/{id}', [PlanningController::class, 'destroy'])->name('planning.destroy');
Route::post('/planning/import', [PlanningController::class, 'import'])->name('planning.import');
