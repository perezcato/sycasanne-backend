<?php

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ClientStatementController;
use App\Http\Controllers\Configuration\ESchoolResourceController;
use App\Http\Controllers\Estores\Auth\AuthController;
use App\Http\Controllers\Estores\Branches\BranchesController;
use App\Http\Controllers\Estores\Products\ProductsController;
use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\MobileBanker\LoanController;
use App\Http\Controllers\MobileBanker\LoanDescriptionController;
use App\Http\Controllers\MobileBanker\LoanRepaymentController;
use App\Http\Controllers\User\UserController;
use App\Models\Auth\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::post('/config',[ESchoolResourceController::class,'index']);

Route::middleware(['db'])->group(function(){
    Route::post('/login',[LoginController::class,'login']);
    Route::post('/unlock-device', function (){
        return response()->json(['message'=>'device unlocked']);
    });

    Route::post('/register-device', [LoginController::class, 'registerDevice']);
    Route::post('/request-token', [LoginController::class, 'requestToken']);
    Route::post('/verify-token', [LoginController::class, 'verifyToken']);

    Route::middleware(['user.locked'])->group(static function (){
        Route::get('/loans',[LoanController::class, 'index']);
        Route::get('/users', [UserController::class,'index']);
        Route::post('/loans/repayment',[LoanRepaymentController::class, 'store']);
        Route::post('/loans/check-repayment',[LoanRepaymentController::class, 'checkLoanPayment']);
        Route::post('/loans/search',[LoanController::class, 'search']);
        Route::post('/location',[LocationController::class,'store']);
        Route::post('/client',[ClientController::class,'store']);
        Route::post('/loan/description', [LoanDescriptionController::class, 'store']);
        Route::post('/loan/client-statement', [ClientStatementController::class, 'index']);
        Route::post('/loan/update-image', [LoanController::class, 'updateImage']);
    });

    Route::get('/database', function (Request $request) {
       return Device::all();
    });
});

Route::middleware(['estores.locked'])->prefix('estores')->group(function(){
    Route::post('/signin',[AuthController::class, 'signIn']);
    Route::middleware(['estores.auth'])->group(function(){
        Route::post('/adduser',[AuthController::class,'addUser']);
        Route::get('/products/search',[ProductsController::class,'searchProduct']);
        Route::get('/branches',[BranchesController::class,'index']);
        Route::post('/products/{id}',[ProductsController::class,'update']);
        Route::post('/products',[ProductsController::class,'store']);
    });

});
