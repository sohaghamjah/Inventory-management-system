<?php

use Modules\System\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use Modules\System\Http\Controllers\TaxController;

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
    // Brand Routes
    Route::get('brand', [BrandController::class, 'index']) -> name('brand');
    Route::group(['prefix' => 'brand', 'as' => 'brand.'], function(){
        Route::post('datatable-data', [BrandController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [BrandController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [BrandController::class, 'edit']) -> name('edit');
        Route::post('delete', [BrandController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [BrandController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [BrandController::class, 'changeStatus']) -> name('change.status');
    });

    // Tax Routes
    Route::get('tax', [TaxController::class, 'index']) -> name('tax');
    Route::group(['prefix' => 'tax', 'as' => 'tax.'], function(){
        Route::post('datatable-data', [TaxController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [TaxController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [TaxController::class, 'edit']) -> name('edit');
        Route::post('delete', [TaxController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [TaxController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [TaxController::class, 'changeStatus']) -> name('change.status');
    });
});