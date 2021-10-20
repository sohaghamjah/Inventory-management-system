<?php

use Modules\System\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use Modules\System\Http\Controllers\CustomerGroupController;
use Modules\System\Http\Controllers\HRMSettingController;
use Modules\System\Http\Controllers\TaxController;
use Modules\System\Http\Controllers\UnitController;
use Modules\System\Http\Controllers\WarehouseController;

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

    // Warehouse Routes
    Route::get('warehouse', [WarehouseController::class, 'index']) -> name('warehouse');
    Route::group(['prefix' => 'warehouse', 'as' => 'warehouse.'], function(){
        Route::post('datatable-data', [WarehouseController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [WarehouseController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [WarehouseController::class, 'edit']) -> name('edit');
        Route::post('delete', [WarehouseController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [WarehouseController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [WarehouseController::class, 'changeStatus']) -> name('change.status');
    });

    // Tax Routes
    Route::get('customer-group', [CustomerGroupController::class, 'index']) -> name('customer-group');
    Route::group(['prefix' => 'customer-group', 'as' => 'customer-group.'], function(){
        Route::post('datatable-data', [CustomerGroupController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [CustomerGroupController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [CustomerGroupController::class, 'edit']) -> name('edit');
        Route::post('delete', [CustomerGroupController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [CustomerGroupController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [CustomerGroupController::class, 'changeStatus']) -> name('change.status');
    });

    // Unit Routes
    Route::get('unit', [UnitController::class, 'index']) -> name('unit');
    Route::group(['prefix' => 'unit', 'as' => 'unit.'], function(){
        Route::post('datatable-data', [UnitController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [UnitController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [UnitController::class, 'edit']) -> name('edit');
        Route::post('delete', [UnitController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [UnitController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [UnitController::class, 'changeStatus']) -> name('change.status');
        Route::post('base-unit', [UnitController::class, 'BaseUnit']) -> name('base.unit');
    });

    // Unit Routes
    Route::get('hrm-setting', [HRMSettingController::class, 'index']);
    Route::post('hrm-setting/store', [HRMSettingController::class, 'store']);
});