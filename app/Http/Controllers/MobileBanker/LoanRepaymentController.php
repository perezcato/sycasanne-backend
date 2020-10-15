<?php

namespace App\Http\Controllers\MobileBanker;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileBanker\LoanRepaymentRequest;
use App\Models\MobileBanker\LoanRepayment;
use Illuminate\Http\Response;

class LoanRepaymentController extends Controller
{
    public function index(LoanRepaymentRequest $request)
    {
        LoanRepayment::addPayment($request);
        return response()->json([], Response::HTTP_CREATED);
    }
}
