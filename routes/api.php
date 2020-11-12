<?php

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ClientStatementController;
use App\Http\Controllers\Configuration\ESchoolResourceController;
use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\MobileBanker\LoanController;
use App\Http\Controllers\MobileBanker\LoanDescriptionController;
use App\Http\Controllers\MobileBanker\LoanRepaymentController;
use App\Http\Controllers\User\UserController;
use App\Models\Auth\Device;
use App\Models\Configuration\ESchoolResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::post('/config',[ESchoolResourceController::class,'index']);

Route::middleware(['db'])->group(function(){
    Route::post('/login',[LoginController::class,'login']);

    Route::post('/register-device', [LoginController::class, 'registerDevice']);
    Route::post('/request-token', [LoginController::class, 'requestToken']);
    Route::post('/verify-token', [LoginController::class, 'verifyToken']);

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

    Route::get('/database', function (Request $request) {
        ['CompanyName' => $companyName] =


        $sendSms = Http::get('https://sms.arkesel.com/sms/api', [
            'action' => 'send-sms',
            'api_key' => 'TWRvYW5nb0ZpQmRraWhCRE9Pckg=',
            'to' => '0550220451',
            'from' => 'company',
            'sms' => "Please your verification token is 1234"
        ]);
       return 'working';
    });
});
