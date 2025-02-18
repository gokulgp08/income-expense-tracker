<?php


use Illuminate\Support\Facades\Route;
use App\Modules\Reports\Controllers\MonthlyReportController;


Route::middleware(['web','auth'])->group(function(){

    Route::prefix('reports')->group(function () {
        Route::get('/', [MonthlyReportController::class, 'index'])->name('reports.index');
        Route::get('/filter', [MonthlyReportController::class, 'reportfilter'])->name('reports.filter');
    
        // Report downloads
        Route::get('/download/pdf', [MonthlyReportController::class, 'downloadPdf'])->name('reports.pdf');
        Route::get('/download/excel', [MonthlyReportController::class, 'downloadExcel'])->name('reports.excel');
    });


});
