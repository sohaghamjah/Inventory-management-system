<?php
use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;

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
    Route::get('category', [CategoryController::class, 'index']) -> name('category');
    Route::group(['prefix' => 'category', 'as' => 'category.'], function(){
        Route::post('datatable-data', [CategoryController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [CategoryController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [CategoryController::class, 'edit']) -> name('edit');
        Route::post('delete', [CategoryController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [CategoryController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [CategoryController::class, 'changeStatus']) -> name('change.status');
    });
});
