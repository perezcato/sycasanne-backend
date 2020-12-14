<?php

namespace App\Http\Controllers\Estores\Branches;

use App\Http\Controllers\Controller;
use App\Models\Estores\Branch\Branch;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::getBranches($request);
        return response()->json($branches);
    }
}
