<?php

use App\Http\Controllers\Configuration\ESchoolResourceController;
use App\Http\Controllers\MobileBanker\LoanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::post('/config',[ESchoolResourceController::class,'index'])
    ->name('config.index');

Route::get('/test', function (){
    return 'done';
});

Route::middleware(['db'])->group(function(){
    Route::post('/login',[LoginController::class,'login']);
    Route::post('/loans',[LoanController::class, 'index']);
});
