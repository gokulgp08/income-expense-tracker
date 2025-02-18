<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Transactions\Controllers\TransactionController;
use App\Modules\Transactions\Controllers\TransactionHistoryController;
use App\Modules\Transactions\Controllers\AccountLedgerController;

Route::get('/hai',function(){
    echo "Route is working!";
    die();
});

Route::middleware(['web','auth'])->group(function(){

    Route::prefix('transactions')->group(function () {

        Route::get('/', [TransactionController::class,'index'])->name('transactions.index');
        Route::get('/create', [TransactionController::class,'create'])->name('transactions.create');
        Route::get('/store', [TransactionController::class,'store'])->name('transactions.store');


        
        // Transaction history
        Route::get('/history', [TransactionHistoryController::class, 'index'])->name('transactions.history');

        // Ledger
        Route::get('/ledger', [AccountLedgerController::class, 'index'])->name('transactions.ledger');
        Route::get('/filter', [AccountLedgerController::class, 'filter'])->name('transactions.filter');
        Route::get('ledger/download/pdf', [AccountLedgerController::class, 'downloadPdf'])->name('ledger.pdf');
        Route::get('ledger/download/excel', [AccountLedgerController::class, 'downloadExcel'])->name('ledger.excel');

    });

});




