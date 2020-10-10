<?php

namespace App\Http\Controllers\MobileBanking;

use App\Http\Controllers\Controller;
use App\Models\MobileBanking\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $loanSearch = $request->input('loan_search');
        $clientLoan = is_numeric($loanSearch) ? Loan::where('LApplicIndex',$loanSearch)->paginate(16) :
            Loan::where('ClientName',$loanSearch)->paginate(16);

        return response()->json($clientLoan);
    }
}
