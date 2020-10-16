<?php

use App\Http\Controllers\Configuration\ESchoolResourceController;
use App\Http\Controllers\MobileBanker\LoanController;
use App\Http\Controllers\MobileBanker\LoanRepaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::post('/config',[ESchoolResourceController::class,'index'])
    ->name('config.index');

Route::get('/test', function (){
    return 'done';
});

Route::middleware(['db'])->group(function(){

    Route::post('/login',[LoginController::class,'login']);
    Route::post('/request-token', [LoginController::class,'requestToken']);
    Route::post('/register-device', [LoginController::class, 'registerDevice']);
    Route::post('/verify-token', [LoginController::class, 'verifyToken']);

    Route::middleware('user.token')->group(function(){
        Route::post('/loans',[LoanController::class, 'index']);
        Route::post('/loans/repayment',[LoanRepaymentController::class, 'index']);
    });
});
