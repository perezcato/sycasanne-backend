<?php

namespace App\Http\Controllers\MobileBanker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\GetLoansRequest;
use App\Http\Resources\MobileBanker\LoanResource;
use App\Models\MobileBanker\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function search(Request $request)
    {
        $loan = $request->input('data.loan_query');

        $loan = is_numeric($loan) ? Loan::select('LApplicIndex','ClientName','ClientRef','Amt')
            ->where('LApplicIndex',$loan)->paginate(15) :
            Loan::select('LApplicIndex','ClientName','ClientRef','Amt')
                ->where('ClientName','LIKE','%'.$loan.'%')->paginate(15);

        return LoanResource::collection($loan);
    }

    public function index():JsonResponse
    {
        return  \App\Http\Resources\LoanResource::collection(Loan::getLoans())->response();
    }
}
