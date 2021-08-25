<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Auth::routes(['register' => false]);


Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('unauthorized', [HomeController::class, 'unauthorized'])->name('unauthorized');
    
    // Menu Routes
    Route::get('menu', [MenuController::class, 'index']) -> name('menu');
    Route::group(['prefix' => 'menu', 'as' => 'menu.'], function(){
        Route::post('datatable-data', [MenuController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [MenuController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [MenuController::class, 'edit']) -> name('edit');
        Route::post('delete', [MenuController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [MenuController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('order/{id}', [MenuController::class, 'orderItem']) -> name('order');

        // Module Route
        Route::get('builder/{id}', [ModuleController::class, 'index'])-> name('builder');

        Route::group(['prefix' => 'module', 'as' => 'module.'], function () {
            Route::get('create/{menu}', [ModuleController::class, 'create'])-> name('create');
            Route::post('store-or-update', [ModuleController::class, 'storeOrUpdate'])-> name('store.or.update');
            Route::get('{menu}/edit/{module}', [ModuleController::class, 'edit'])-> name('edit');
            Route::delete('delete/{module}', [ModuleController::class, 'destroy'])-> name('delete');

            // Module Permission

            Route::get('permission', [PermissionController::class, 'index']) -> name('permission');
            Route::group(['prefix' => 'permission', 'as' => 'permission.'], function(){
                Route::post('datatable-data', [PermissionController::class, 'getDataTableData']) -> name('datatable.data');
                Route::post('store', [PermissionController::class, 'store']) -> name('store');
                Route::post('edit', [PermissionController::class, 'edit']) -> name('edit');
                Route::post('update', [PermissionController::class, 'update']) -> name('update');
                Route::post('delete', [PermissionController::class, 'delete']) -> name('delete');
                Route::post('bulk-delete', [PermissionController::class, 'bulkDelete']) -> name('bulk.delete');
            });
        });
    });

    // Role Permission

    Route::get('role', [RoleController::class, 'index']) -> name('role');
    Route::group(['prefix' => 'role', 'as' => 'role.'], function(){
        Route::get('create', [RoleController::class, 'create']) -> name('create');
        Route::post('datatable-data', [RoleController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [RoleController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::get('edit/{id}', [RoleController::class, 'edit']) -> name('edit');
        Route::get('view/{id}', [RoleController::class, 'show']) -> name('view');
        Route::post('delete', [RoleController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [RoleController::class, 'bulkDelete']) -> name('bulk.delete');
    });

    // User Routes
    Route::get('user', [UserController::class, 'index']) -> name('user');
    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::post('datatable-data', [UserController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [UserController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [UserController::class, 'edit']) -> name('edit');
        Route::post('show', [UserController::class, 'show']) -> name('show');
        Route::post('delete', [UserController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [UserController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [UserController::class, 'changeStatus']) -> name('change.status');
    });
    
    // Setting Route
    Route::get('setting', [SettingController::class, 'index']) -> name('setting');
    Route::post('general-setting', [SettingController::class, 'generalSetting']) -> name('general.setting');
    Route::post('mail-setting', [SettingController::class, 'mailSetting']) -> name('mail.setting');

});
