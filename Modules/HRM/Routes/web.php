<?php
use Illuminate\Support\Facades\Route;
use Modules\HRM\Http\Controllers\AttendanceController;
use Modules\HRM\Http\Controllers\DepartmentController;
use Modules\HRM\Http\Controllers\EmployeeController;
use Modules\HRM\Http\Controllers\PayrollController;

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
    // Depertment Routes
    Route::get('department', [DepartmentController::class, 'index']) -> name('department');
    Route::group(['prefix' => 'department', 'as' => 'department.'], function(){
        Route::post('datatable-data', [DepartmentController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [DepartmentController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [DepartmentController::class, 'edit']) -> name('edit');
        Route::post('delete', [DepartmentController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [DepartmentController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [DepartmentController::class, 'changeStatus']) -> name('change.status');
    });
    // Employee Routes
    Route::get('employee', [EmployeeController::class, 'index']) -> name('employee');
    Route::group(['prefix' => 'employee', 'as' => 'employee.'], function(){
        Route::post('datatable-data', [EmployeeController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [EmployeeController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [EmployeeController::class, 'edit']) -> name('edit');
        Route::post('show', [EmployeeController::class, 'show']) -> name('show');
        Route::post('delete', [EmployeeController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [EmployeeController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [EmployeeController::class, 'changeStatus']) -> name('change.status');
    });
    // Attemdamce Routes
    Route::get('attendance', [AttendanceController::class, 'index']) -> name('attendance');
    Route::group(['prefix' => 'attendance', 'as' => 'attendance.'], function(){
        Route::post('datatable-data', [AttendanceController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [AttendanceController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [AttendanceController::class, 'edit']) -> name('edit');
        Route::post('show', [AttendanceController::class, 'show']) -> name('show');
        Route::post('delete', [AttendanceController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [AttendanceController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [AttendanceController::class, 'changeStatus']) -> name('change.status');
    });
    // Attemdamce Routes
    Route::get('payroll', [PayrollController::class, 'index']) -> name('payroll');
    Route::group(['prefix' => 'payroll', 'as' => 'payroll.'], function(){
        Route::post('datatable-data', [PayrollController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [PayrollController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [PayrollController::class, 'edit']) -> name('edit');
        Route::post('show', [PayrollController::class, 'show']) -> name('show');
        Route::post('delete', [PayrollController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [PayrollController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('change-status', [PayrollController::class, 'changeStatus']) -> name('change.status');
    });
});