<?php
use Illuminate\Support\Facades\Route;
use Modules\Expense\Http\Controllers\ExpenseCategoryController;
use Modules\Expense\Http\Controllers\ExpenseController;

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
    Route::get('expense', [ExpenseController::class, 'index']) -> name('expense');
    Route::group(['prefix' => 'expense', 'as' => 'expense.'], function(){
        Route::post('datatable-data', [ExpenseController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [ExpenseController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [ExpenseController::class, 'edit']) -> name('edit');
        Route::post('delete', [ExpenseController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [ExpenseController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [ExpenseController::class, 'changeStatus']) -> name('change.status');

        Route::get('category', [ExpenseCategoryController::class, 'index']) -> name('category');
        Route::group(['prefix' => 'category', 'as' => 'category.'], function(){
            Route::post('datatable-data', [ExpenseCategoryController::class, 'getDataTableData']) -> name('datatable.data');
            Route::post('store-or-update', [ExpenseCategoryController::class, 'storeOrUpdate']) -> name('store.or.update');
            Route::post('edit', [ExpenseCategoryController::class, 'edit']) -> name('edit');
            Route::post('delete', [ExpenseCategoryController::class, 'delete']) -> name('delete');
            Route::post('bulk-delete', [ExpenseCategoryController::class, 'bulkDelete']) -> name('bulk.delete');
            Route::post('change-status', [ExpenseCategoryController::class, 'changeStatus']) -> name('change.status');
        });
    });
});