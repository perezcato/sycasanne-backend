<?php

namespace App\Http\Controllers\Estores\Branches;

use App\Http\Controllers\Controller;
use App\Models\Estores\Branch\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $branches = Branch::getBranches($request);
        return response()->json($branches);
    }

    public function branchesLastUpdate(Request $request): JsonResponse
    {
        $branches = Branch::getBranchesLastUpdate($request);
        return response()->json($branches);
    }

}
