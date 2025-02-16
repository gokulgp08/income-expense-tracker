<?php

use App\Http\Controllers\AccountHeadController;
use App\Http\Controllers\AccountLedgerController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('AccountHeads', AccountHeadController::class);
    Route::resource('transactions', TransactionController::class);
    Route::get('/account-head', [AccountHeadController::class, 'accountList'])->name('accountList');
    Route::get('/payment-method', [AccountHeadController::class, 'paymentMethod'])->name('paymentMethod');
    Route::get('/history', [TransactionHistoryController::class, 'index'])->name('history');
    Route::get('/ledger', [AccountLedgerController::class, 'index'])->name('ledger');
    Route::get('/filter', [AccountLedgerController::class, 'filter'])->name('transactions.filter');
    Route::get('/voucher', [VoucherController::class, 'index'])->name('voucher');
    Route::get('/voucherfilter/{voucher_id}', [VoucherController::class, 'voucherfilter'])->name('voucherfilter');
    Route::get('/report', [MonthlyReportController::class, 'index'])->name('report');
    Route::get('/reportfilter',[MonthlyReportController::class, 'reportfilter'])->name('reportfilter');
    Route::get('reports/download/pdf', [MonthlyReportController::class, 'downloadPdf'])->name('report.pdf');
    Route::get('reports/download/excel', [MonthlyReportController::class, 'downloadExcel'])->name('report.excel');
    Route::get('ledger/download/pdf', [AccountLedgerController::class, 'downloadPdf'])->name('ledger.pdf');
    Route::get('ledger/download/excel', [AccountLedgerController::class, 'downloadExcel'])->name('ledger.excel');


    

});


require __DIR__.'/auth.php';
