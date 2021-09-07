<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\CustomerController;

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
Route::middleware(['auth'])->group(function () {
    Route::get('customer', [CustomerController::class, 'index']) -> name('customer');
    Route::group(['prefix' => 'customer', 'as' => 'customer.'], function(){
        Route::post('datatable-data', [CustomerController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [CustomerController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [CustomerController::class, 'edit']) -> name('edit');
        Route::post('show', [CustomerController::class, 'show']) -> name('show');
        Route::post('delete', [CustomerController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [CustomerController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [CustomerController::class, 'changeStatus']) -> name('change.status');
    });
});
