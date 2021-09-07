<?php
use Illuminate\Support\Facades\Route;
use Modules\Purchase\Http\Controllers\PurchaseController;
use Modules\Purchase\Http\Controllers\PurchasePaymentController;

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
    Route::get('purchase', [PurchaseController::class, 'index']) -> name('purchase');
    Route::group(['prefix' => 'purchase', 'as' => 'purchase.'], function(){
        Route::post('datatable-data', [PurchaseController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [PurchaseController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::get('add', [PurchaseController::class, 'create']) -> name('add');
        Route::get('edit', [PurchaseController::class, 'edit']) -> name('edit');
        Route::get('delete', [PurchaseController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [PurchaseController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('invoice', [PurchaseController::class, 'invoice']) -> name('invoice');
        Route::post('payment/add', [PurchasePaymentController::class, 'add']) -> name('payment.add');
        Route::post('payment/edit', [PurchasePaymentController::class, 'edit']) -> name('payment.edit');
        Route::post('payment/view', [PurchasePaymentController::class, 'view']) -> name('payment.view');
        Route::post('payment/delete', [PurchasePaymentController::class, 'delete']) -> name('payment.delete');
    });
});
