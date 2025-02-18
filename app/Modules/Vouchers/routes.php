<?php


use Illuminate\Support\Facades\Route;
use App\Modules\Vouchers\Controllers\VoucherController;


Route::middleware(['web','auth'])->group(function(){

    Route::prefix('vouchers')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('vouchers.index');
        Route::get('/filter/{voucher_id}', [VoucherController::class, 'voucherfilter'])->name('vouchers.filter');
    });


});
