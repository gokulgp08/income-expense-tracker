<?php


use Illuminate\Support\Facades\Route;
use App\Modules\AccountHeads\Controllers\AccountHeadController;


Route::middleware(['web','auth'])->group(function(){

    Route::prefix('AccountHeads')->group(function () {
        Route::get('/create', [AccountHeadController::class,'create'])->name('AccountHeads.create');
    
        Route::get('/account-list', [AccountHeadController::class, 'accountList'])->name('accountHeads.accountList');
        Route::get('/payment-method', [AccountHeadController::class, 'paymentMethod'])->name('accountHeads.paymentMethod');
    });


});