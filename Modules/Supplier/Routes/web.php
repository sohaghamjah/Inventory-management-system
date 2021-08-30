<?php

use Illuminate\Support\Facades\Route;
use Modules\Supplier\Http\Controllers\SupplierController;

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

// Supplier Routes
Route::get('supplier', [SupplierController::class, 'index']) -> name('supplier');
Route::group(['prefix' => 'supplier', 'as' => 'supplier.'], function(){
    Route::post('datatable-data', [SupplierController::class, 'getDataTableData']) -> name('datatable.data');
    Route::post('store-or-update', [SupplierController::class, 'storeOrUpdate']) -> name('store.or.update');
    Route::post('edit', [SupplierController::class, 'edit']) -> name('edit');
    Route::post('show', [SupplierController::class, 'show']) -> name('show');
    Route::post('delete', [SupplierController::class, 'delete']) -> name('delete');
    Route::post('bulk-delete', [SupplierController::class, 'bulkDelete']) -> name('bulk.delete');
    Route::post('change-status', [SupplierController::class, 'changeStatus']) -> name('change.status');
});