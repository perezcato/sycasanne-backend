<?php

namespace App\Http\Controllers\MobileBanker;

use App\Http\Controllers\Controller;
use App\Http\Resources\MobileBanker\LoanResource;
use App\Models\MobileBanker\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loan = $request->input('data.loan_query');
        $loan = is_numeric($loan)? Loan::select('LApplicIndex','ClientName','ClientRef','Amt')
            ->where('LApplicIndex',$loan)->get() :
            Loan::select('LApplicIndex','ClientName','ClientRef','Amt')
                ->where('ClientName','LIKE','%'.$loan.'%')->get();

        return LoanResource::collection($loan);
    }

    public function show($load_id)
    {
        $loan = Loan::select('LApplicIndex','ClientName','ClientRef','Amt')
            ->where('LApplicIndex',$load_id)
            ->get();

        return (new LoanResource($loan))->response();
    }

}
