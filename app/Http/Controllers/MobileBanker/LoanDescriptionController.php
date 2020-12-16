<?php

namespace App\Http\Controllers\MobileBanker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\LoanDescriptionRequest;
use App\Models\MobileBanker\LoanDescription;
use Illuminate\Http\Request;

class LoanDescriptionController extends Controller
{
    public function store(LoanDescriptionRequest $request)
    {
        $loanDescription = LoanDescription::addLoanDescription($request);
        return response()->json([$loanDescription]);
    }
}
