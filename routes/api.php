<?php

use App\Http\Controllers\Configuration\ESchoolResourceController;
use Illuminate\Support\Facades\Route;

Route::post('/config',[ESchoolResourceController::class,'index'])
    ->name('config.index');

Route::middleware(['db.connect'])->group(function(){
    Route::post('/login',[LoginContoller::class,'login']);
});
