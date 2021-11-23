<?php
use Illuminate\Support\Facades\Route;
use Modules\Stock\Http\Controllers\StockController;

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

Route::middleware(['auth'])->group(function () {
    // Menu Routes
    Route::get('stock', [StockController::class, 'index']) -> name('stock');
    Route::group(['prefix' => 'stock', 'as' => 'stock.'], function(){
        Route::post('datatable-data', [StockController::class, 'getDataTableData']) ->name('datatable.data');
    });
});