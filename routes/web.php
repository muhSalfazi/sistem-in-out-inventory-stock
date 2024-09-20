<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [LoginController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('postlogin')->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['role:admin']], function () {

  // routes dashboard
  Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // route untuk stock
   Route::get('/admin/stock', [StockController::class, 'index'])->name('admin.stock.index');
  Route::delete('/stock/{id}', [StockController::class, 'destroy'])->name('stock.destroy');

  // Rute untuk menampilkan daftar delivery
  Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery.index');
  Route::post('/delivery/import', [DeliveryController::class, 'uploadDelivery'])->name('delivery.import');
  // Rute untuk menampilkan daftar produksi
  Route::get('/product', [ProductController::class, 'index'])->name('product.index');
  Route::post('/productstore', [ProductController::class, 'store'])->name('product.store');
  Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
  Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
  Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
  Route::post('/prdoduct/import', [ProductController::class, 'importExcelProduct'])->name('product.import');
});

// Route::get('/stocks', [StockController::class, 'getStocks'])->name('user.stock.getStocks');
// Route::get('/stock', [StockController::class, 'index'])->middleware('role:admin,user')->name('stock.index');
// Middleware untuk user
Route::group(['middleware' => ['role:user']], function () {
  // route show data stok
  Route::get('user/stock', [StockController::class, 'index'])->name('user.stock.index');


  Route::get('user/planning', [PlanningController::class, 'index'])->name('user.planning.index');
  Route::post('/planning/store', [PlanningController::class, 'store'])->name('planning.store');
  Route::put('/planning/update/{id}', [PlanningController::class, 'update'])->name('planning.update');
  Route::post('/planning/import', [PlanningController::class, 'importExcel'])->name('planning.import');
  Route::delete('/planning/delete/{id}', [PlanningController::class, 'destroy'])->name('planning.destroy');

});

