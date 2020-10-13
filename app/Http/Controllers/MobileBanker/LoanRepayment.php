<?php

namespace App\Http\Controllers\MobileBanker;

use App\Http\Controllers\Controller;
use App\Models\MobileBanker\LoanRepayment as Repayment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoanRepayment extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request,[
           'data.loan_amount' => ['required'],
           'data.loan_ref' => ['required'],
           'data.client_ref' => ['required'],
           'data.loan_description' => ['required'],
        ]);

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
