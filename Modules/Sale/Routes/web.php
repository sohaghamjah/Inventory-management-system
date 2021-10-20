<?php
use Illuminate\Support\Facades\Route;
use Modules\Sale\Http\Controllers\SaleController;
use Modules\Sale\Http\Controllers\SalePaymentController;

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
    Route::get('sale', [SaleController::class, 'index']) -> name('sale');
    Route::group(['prefix' => 'sale', 'as' => 'sale.'], function(){
        Route::post('datatable-data', [SaleController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store', [SaleController::class, 'store']) -> name('store');
        Route::post('update', [SaleController::class, 'update']) -> name('update');
        Route::get('add', [SaleController::class, 'create']) -> name('add');
        Route::get('edit/{id}', [SaleController::class, 'edit']) -> name('edit');
        Route::get('details/{id}', [SaleController::class, 'details']) -> name('details');
        Route::post('delete', [SaleController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [SaleController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [SaleController::class, 'changeStatus']) -> name('change.status');
        Route::post('invoice', [SaleController::class, 'invoice']) -> name('invoice');

    });

    Route::post('sale-payment/store-or-update', [SalePaymentController::class, 'storeOrUpdate']) -> name('sale.payment.store.or.update');
    Route::post('sale-payment/view', [SalePaymentController::class, 'show']) -> name('sale.payment.show');
    Route::post('sale-payment/edit', [SalePaymentController::class, 'edit']) -> name('sale.payment.edit');
    Route::post('sale-payment/delete', [SalePaymentController::class, 'delete']) -> name('sale.payment.delete');
});
