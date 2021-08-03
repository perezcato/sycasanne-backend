<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\LoansModel;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    public function getClientLoans(Request $request)
    {
        $clientRef = $request->input('data.clientRef');
        $loans = LoansModel::where('ClientRef',$clientRef)->get();
        return response()->json(['loans' => $loans]);
    }
}
