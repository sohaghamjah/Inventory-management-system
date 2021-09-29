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
        Route::post('store', [PurchaseController::class, 'store']) -> name('store');
        Route::post('update', [PurchaseController::class, 'update']) -> name('update');
        Route::get('add', [PurchaseController::class, 'create']) -> name('add');
        Route::get('edit/{id}', [PurchaseController::class, 'edit']) -> name('edit');
        Route::get('details/{id}', [PurchaseController::class, 'details']) -> name('details');
        Route::post('delete', [PurchaseController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [PurchaseController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [PurchaseController::class, 'changeStatus']) -> name('change.status');
        Route::post('invoice', [PurchaseController::class, 'invoice']) -> name('invoice');

    });

    Route::post('purchase-payment/store-or-update', [PurchasePaymentController::class, 'storeOrUpdate']) -> name('purchase.payment.store.or.update');
    Route::post('purchase-payment/view', [PurchasePaymentController::class, 'show']) -> name('purchase.payment.show');
    Route::post('purchase-payment/edit', [PurchasePaymentController::class, 'edit']) -> name('purchase.payment.edit');
    Route::post('purchase-payment/delete', [PurchasePaymentController::class, 'delete']) -> name('purchase.payment.delete');
});
