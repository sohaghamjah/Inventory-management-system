<?php
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\BarcodeController;
use Modules\Product\Http\Controllers\ProductController;

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

// Product Routes
Route::middleware(['auth'])->group(function () {
    Route::get('product', [ProductController::class, 'index']) -> name('product');
    Route::group(['prefix' => 'product', 'as' => 'product.'], function(){
        Route::post('datatable-data', [ProductController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [ProductController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [ProductController::class, 'edit']) -> name('edit');
        Route::post('show', [ProductController::class, 'show']) -> name('show');
        Route::post('delete', [ProductController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [ProductController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [ProductController::class, 'changeStatus']) -> name('change.status');
    });
    Route::get('generate-code', [ProductController::class, 'generateCode']);
    Route::get('populate-unit/{id}', [ProductController::class, 'populateUnit']);
    
    Route::get('print-barcode', [BarcodeController::class, 'index']);
    Route::post('generate-barcode', [BarcodeController::class, 'generateBarcode']);

    Route::post('product-autocomplete-search', [ProductController::class, 'productAutoComplete']);
    Route::post('product-search', [ProductController::class, 'productSearch']);
});