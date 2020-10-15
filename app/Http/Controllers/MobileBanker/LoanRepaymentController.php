<?php

namespace App\Http\Controllers\MobileBanker;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileBanker\LoanRepaymentRequest;
use App\Models\MobileBanker\LoanRepayment;
use App\Models\MobileBanker\LoanRepayment as Repayment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoanRepaymentController extends Controller
{
    public function index(LoanRepaymentRequest $request)
    {
        $loanRepayment = Repayment::create([
            'LoanRef' => $request->input('data.loan_ref'),
            'ClientRef' => $request->input('data.client_ref'),
            'TheRPAmt' => $request->input('data.loan_amount'),
            'MyKyCd' => Str::uuid(),
            'RPDescp' => $request->input('data.loan_description'),
            'TheRPDate' => date("Y-m-d H:i:s")
        ]);

        if(!$loanRepayment){
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json([], Response::HTTP_CREATED);
    }
}
