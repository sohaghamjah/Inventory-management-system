<?php
use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\ProductReportController;
use Modules\Report\Http\Controllers\PurchaseReportController;
use Modules\Report\Http\Controllers\SaleReportController;
use Modules\Report\Http\Controllers\SummaryReportController;

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
    Route::get('summary-report', [SummaryReportController::class, 'index']) -> name('summary.report');
    Route::post('summary-report/details', [SummaryReportController::class, 'details']) -> name('summary.details');
    Route::match(['get','post'], 'product-report', [ProductReportController::class, 'index']);

    // Daily sale report routes
    Route::get('daily-sale', [SaleReportController::class, 'dailySale']);
    Route::post('daily-sale-report', [SaleReportController::class, 'dailySaleReport'])->name('daily.sale.report');

    // Monthly sale report routes
    Route::get('monthly-sale', [PurchaseReportController::class, 'monthlySale']);
    Route::post('monthly-sale-report', [PurchaseReportController::class, 'monthlySaleReport'])->name('monthly.sale.report');

    // Daily purchase report routes
    Route::get('daily-purchase', [PurchaseReportController::class, 'dailyPurchase']);
    Route::post('daily-purchase-report', [PurchaseReportController::class, 'dailyPurchaseReport'])->name('daily.purchase.report');

    // Monthly purchase report routes
    Route::get('monthly-purchase', [PurchaseReportController::class, 'monthlyPurchase']);
    Route::post('monthly-purchase-report', [PurchaseReportController::class, 'monthlyPurchaseReport'])->name('monthly.purchase.report');
});