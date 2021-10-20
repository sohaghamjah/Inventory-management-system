<?php
use Illuminate\Support\Facades\Route;
use Modules\Account\Http\Controllers\AccountController;

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
    Route::get('account', [AccountController::class, 'index']) -> name('account');
    Route::group(['prefix' => 'account', 'as' => 'account.'], function(){
        Route::post('datatable-data', [AccountController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [AccountController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [AccountController::class, 'edit']) -> name('edit');
        Route::post('delete', [AccountController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [AccountController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [AccountController::class, 'changeStatus']) -> name('change.status');
    });
    Route::get('balance-sheet', [AccountController::class, 'balanceSheet']) -> name('balance.sheet');
});
