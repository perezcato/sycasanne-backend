<?php

namespace App\Http\Controllers\Company\Staff;

use App\Http\Controllers\Controller;
use App\Models\Company\AgentsModel;
use App\Models\Company\NewLoanModel;
use App\Models\Company\Staff\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('data.username');
        $password = md5($request->input('data.password'));

        $staff = UsersModel::query()
            ->where('UserName', $username)
            ->where('Userpass', $password)
            ->first();

        if(!$staff){
            return response()->json([
                'message' => 'Invalid username/password',
            ], 404);
        }

        return response()->json([
         'staff' => $staff
        ], 200);
    }

    public function searchClients (Request $request)
    {
        $clientName = $request->get('clientName');

        $clients = DB::table('clients')
            ->where('Surname','LIKE', "%{$clientName}%")
            ->orWhere('Firstname','LIKE', "%{$clientName}%")
            ->get();

        return response()->json([
            'clients' => $clients
        ]);
    }

    public function searchAgents (Request $request)
    {
        $agentName = $request->get('clientName');

        $clients = DB::table('agencyagents')
            ->where('IsCERTIFIED', 0)
            ->where('AgentName', 'LIKE', "%{$agentName}%")
            ->get();

        return response()->json([
            'agents' => $clients
        ]);
    }

    public function certifyAgent (Request $request)
    {
        $agentId = $request->input('data.agentId');

        $agent = AgentsModel::query()
            ->where('AgentID', $agentId)
            ->first();

        if(!$agent){
            return response()->json([
               'message' => 'Agent does not exist'
            ], 404);
        }

        $password = Str::random(8);


        $agent->IsCERTIFIED = 1;
        $agent->IsALLOWED = 1;
        $agent->save();

        return response()->json([
            'agents' => 'Agent Certified'
        ]);
    }

    public function searchLoans (Request $request)
    {
        $loanID = $request->get('loanid');

        $loans = DB::table('loans')
            ->where('LApplicIndex', 'LIKE' ,"%{$loanID}%")
            ->where('LStateRef', 1)
            ->get();

        return response()->json([
            'loans' => $loans
        ]);
    }

    public function searchAllLoans (Request $request)
    {
        $loanID = $request->get('loanid');

        $loans = DB::table('loans')
            ->where('LApplicIndex', 'LIKE' ,"%{$loanID}%")
            ->get();

        return response()->json([
            'loans' => $loans
        ]);
    }

    public function approveLoan (Request $request)
    {
        $loanID = $request->input('data.loanid');

        $loan = NewLoanModel::query()
            ->where('MyLoanID', $loanID)
            ->first();

        if(!$loan){
            return response()->json([
                'message' => 'Agent does not exist'
            ], 404);
        }

        $loan->lStateRef = 4;
        $loan->save();

        return response()->json([
            'loans' => 'Loan approved'
        ]);
    }
}
