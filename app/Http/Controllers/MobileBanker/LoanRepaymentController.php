<?php

namespace App\Http\Controllers\MobileBanker;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileBanker\LoanRepaymentRequest;
use App\Models\MobileBanker\LoanRepayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoanRepaymentController extends Controller
{
    public function store(LoanRepaymentRequest $request)
    {
        LoanRepayment::addPayment($request);
        return response()->json([], Response::HTTP_CREATED);
    }

    public function checkLoanPayment(LoanRepaymentRequest $request):JsonResponse
    {
        $loanRepayment = LoanRepayment::checkPayment($request);
        return $loanRepayment ? response()->json(['message' => 'loan repayment found'],Response::HTTP_OK):
            response()->json(['message' => 'Loan repayment not found'], Response::HTTP_NOT_FOUND);
    }
}
