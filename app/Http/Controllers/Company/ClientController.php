<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Company\AgentsModel;
use App\Models\Company\AuthLogModel;
use App\Models\Company\ClientLoanModel;
use App\Models\Company\ClientModel;
use App\Models\Company\LoanCommentModel;
use App\Models\Company\LoansModel;
use App\Models\Company\NewClientModel;
use App\Models\Company\NewLoanModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function loginClient(Request $request)
    {
        $phoneNumber = $request->input('data.phoneNumber');
        $password = md5($request->input('data.password'));

        $client = NewClientModel::query()
            ->where('Tel1', $phoneNumber)
            ->where('LoginPASS', $password)
            ->select('Tel1','Email','ClientIndex','Photo','Firstname','Surname')
            ->first();

        if(!$client){
            return response()->json([
                'error' => 'Invalid telephone/password'
            ], 401);
        }

        return response()->json([
            'client' => $client
        ], 200);

    }

    public function registerExistingClient(Request $request)
    {
        $clientId = $request->input('clientId');
        $telephone = $request->input('telephone');

        $client = ClientModel::where('ClientIndex', $clientId)
            ->where('Tel1', $telephone)
            ->first();

        if(!$client){
            return response()->json([
               'message' => 'No client found'
            ], 404);
        }

        $password = Str::random(8);
        $hashPassword = md5($password);

        $user = new User();

        $user->MyIndex = $client->ClientIndex;
        $user->UserName = $client->Firstname;
        $user->Userpass = $hashPassword;
        $user->RealName = "{$client->Firstname} {$client->Surname}";
        $user->TelephoneA = $client->Tel1;
        $user->Email = $client->Email;
        $user->save();

        Http::get('https://sms.arkesel.com/sms/api', [
            'action' => 'send-sms',
            'api_key' => 'cE9QRUdCakRKdW9LQ3lxSXF6dD0=',
            'to' => $client->Tel1,
            'from' => 'Sycasane',
            'sms' => "Your username: {$client->Firstname} \nPassword: {$password}"
        ]);

        return response()->json([ 'client' => [
            'Username'=> $client->Firstname,
            'Userpass' => $password
        ]], 200);
    }

    public function registerNewClient(Request $request)
    {

        $firstName = $request->input('data.firstname');
        $surName = $request->input('data.surname');
        $phoneNumber = $request->input('data.phonenumber');
        $picture = $request->input('data.picture');
        $payrollId = $request->input('data.payrollId');
        $idType = $request->input('data.idType');
        $idNumber = $request->input('data.idNumber');
        $idImage = $request->input('data.idImage');
        $email = $request->input('data.email');

        $existingClient = NewClientModel::query()
            ->where('ExtClientIDA', $payrollId)
            ->first();

        if($existingClient){
            return response()->json([
                'message' => 'Payroll Id already exists'
            ], 422);
        }


        $client = new NewClientModel();
        $client->Surname = $surName;
        $client->Firstname = $firstName;
        $client->Photo = $picture;
        $client->Tel1 = $phoneNumber;
        $client->ExtClientIDA = $payrollId;
        $client->IDType = $idType;
        $client->ClientID = $idNumber;
        $client->IDPhoto = $idImage;
        $client->Email = $email;
        $client->DateEnrolled = date('Y-m-d H:i:s');

        Http::get('https://sms.arkesel.com/sms/api', [
            'action' => 'send-sms',
            'api_key' => 'cE9QRUdCakRKdW9LQ3lxSXF6dD0=',
            'to' => $client->Tel1,
            'from' => 'Sycasane',
            'sms' => "Your application is being processed we will notify you once it's done"
        ]);

        $client->save();

        return response()->json([
            'message' => 'Application received'
        ]);

    }

    public function sendPasswordToAgent(Request $request)
    {
        $phoneNumber = $request->input('data.phoneNumber');
        $agent = AgentsModel::where('AgentTel1',$phoneNumber)->first();

        if(!$agent){
            return response()->json([
                'error' => 'Invalid agent'
            ], 401);
        }

        $password = Str::random(8);

        $agent->LoginPass = md5($password);
        $agent->save();

        Http::get('https://sms.arkesel.com/sms/api', [
            'action' => 'send-sms',
            'api_key' => 'cE9QRUdCakRKdW9LQ3lxSXF6dD0=',
            'to' => $phoneNumber,
            'from' => 'Sycasane',
            'sms' => "Your Telephone: {$phoneNumber} \nPassword: {$password}"
        ]);

        return response()->json([
            'message' => 'Password sent to your phone number'
        ]);
    }

    public function loginAgent(Request $request)
    {
        $phoneNumber = $request->input('data.phoneNumber');
        $password = md5($request->input('data.password'));

        $agent = AgentsModel::where('AgentTel1', $phoneNumber)
            ->where('LoginPass', $password)
            ->where('isALLOWED', 1)
            ->where('isCERTIFIED', 1)
            ->first();

        $agent_test = AgentsModel::query()
            ->where('AgentTel1', $phoneNumber)
            ->first();

        error_log($password);

        error_log(print_r($agent_test->LoginPass, true));
        error_log(print_r($agent_test->IsCERTIFIED, true));
        error_log(print_r($agent_test->IsALLOWED, true));

        if(!$agent){
            return response()->json([
                'error' => 'Invalid telephone/password'
            ], 401);
        }

        $token = Str::uuid();

        $authLog = new AuthLogModel();
        $authLog->agentId = $agent->AgentID;
        $authLog->loginToken = $token;
        $authLog->loginTime = date('Y-m-d H:i:s');
        $authLog->save();

        return response()->json([
            'id' => $agent->AgentID,
            'name' => $agent->AgentName,
            'email' => $agent->AgentEMail,
            'token' => $token,
            'picture' => $agent->AgentPIC,
            'LoanOfficerAssigned' => $agent->LoanOfficerAssigned
        ], 200);
    }

    public function registerAgent(Request $request)
    {
        $firstName = $request->input('data.firstname');
        $surName = $request->input('data.lastname');
        $dob = $request->input('data.dob');
        $phoneNumber = $request->input('data.phonenumber');
        $idType = $request->input('data.idtype');
        $idNumber = $request->input('data.idnumber');
        $idImage = $request->input('data.idimage');
        $agentPic = $request->input('data.agentpic');
        $email = $request->input('data.email');


        $existingAgent = AgentsModel::query()
            ->where('AgentTel1', $phoneNumber)
            ->first();

        if($existingAgent){
            return response()->json([
               'message' => 'Agent already exists'
            ], 401);
        }

        $agent = new AgentsModel();
        $agent->AgentName = "{$surName} {$firstName}";
        $agent->AgentTel1 = $phoneNumber;
        $agent->AgentIDType = $idType;
        $agent->AgentIDNumber = $idNumber;
        $agent->AgentIDPic = $idImage;
        $agent->IsCERTIFIED = 0;
        $agent->IsALLOWED = 0;
        $agent->AgentPIC = $agentPic;
        $agent->AgentEMail = $email;

        $agent->save();

        Http::get('https://sms.arkesel.com/sms/api', [
            'action' => 'send-sms',
            'api_key' => 'cE9QRUdCakRKdW9LQ3lxSXF6dD0=',
            'to' => $phoneNumber,
            'from' => 'Sycasane',
            'sms' => 'Your Application to become a loan agent has been received and is under review. Thank you'
        ]);

        return response()->json([
           'message' => 'Application received'
        ]);
    }

    public function createClient(Request $request)
    {
        $firstName = $request->input('data.firstname');
        $surName = $request->input('data.surname');
        $phoneNumber = $request->input('data.phonenumber');
        $picture = $request->input('data.picture');
        $agentId = $request->input('data.agentId');
        $clientType = $request->input('data.clienttype');
        $payrollId = $request->input('data.payrollId');
        $idType = $request->input('data.idType');
        $idNumber = $request->input('data.idNumber');
        $idImage = $request->input('data.idImage');
        $email = $request->input('data.email');

        $existingClient = NewClientModel::query()
            ->where('ExtClientIDA', $payrollId)
            ->first();

        if($existingClient){
            return response()->json([
               'message' => 'Payroll Id already exists'
            ], 422);
        }


        $client = new NewClientModel();
        $client->ClientTypeStr = $clientType;
        $client->Surname = $surName;
        $client->Firstname = $firstName;
        $client->Photo = $picture;
        $client->Tel1 = $phoneNumber;
        $client->AgentRef = $agentId;
        $client->ExtClientIDA = $payrollId;
        $client->IDType = $idType;
        $client->ClientID = $idNumber;
        $client->IDPhoto = $idImage;
        $client->Email = $email;
        $client->DateEnrolled = date('Y-m-d H:i:s');

        $client->save();

        return response()->json([
            'message' => 'Application received'
        ]);
    }

    public function editClient(Request $request, $id)
    {

        $firstName = $request->input('data.firstname');
        $surName = $request->input('data.surname');
        $phoneNumber = $request->input('data.phonenumber');
        $picture = $request->input('data.picture');
        $agentId = $request->input('data.agentId');
        $clientType = $request->input('data.clienttype');
        $payrollId = $request->input('data.payrollId');
        $idType = $request->input('data.idType');
        $idNumber = $request->input('data.idNumber');
        $idImage = $request->input('data.idImage');
        $email = $request->input('data.email');

        $client = NewClientModel::query()
            ->where('ClientIndex', $id)
            ->first();

        if(!$client){
            return response()->json([
                'message' => 'Client not found'
            ], 404);
        }

        $client->ClientTypeStr = $clientType;
        $client->Surname = $surName;
        $client->Firstname = $firstName;
        $client->Photo = $picture;
        $client->Tel1 = $phoneNumber;
        $client->AgentRef = $agentId;
        $client->ExtClientIDA = $payrollId;
        $client->IDType = $idType;
        $client->ClientID = $idNumber;
        $client->IDPhoto = $idImage;
        $client->Email = $email;
        $client->DateEnrolled = date('Y-m-d H:i:s');

        $client->save();

        return response()->json([
            'message' => 'Client Received'
        ]);
    }

    public function searchClients(Request $request)
    {
        $clientName = $request->get('clientName');
        $agentId = $request->get('agentId');

        $clients = DB::table('clients')
            ->where('AgentRef',$agentId)
            ->where(function($query) use($clientName){
                $query->where('Surname','LIKE', "%{$clientName}%")
                    ->orWhere('Firstname','LIKE', "%{$clientName}%");
            })
            ->get();

        return response()->json([
            'clients' => $clients
        ]);
    }

    public function bookLoan(Request $request){
        $loanAmount = $request->input('data.amount');
        $tenor = $request->input('data.tenor');
        $purpose = $request->input('data.purpose');
        $affordability = $request->input('data.affordability');
        $clientId = $request->input('data.clientId');
        $agentId = $request->input('data.agentId');
        $loanType = $request->input('data.loanType');

        $newLoan = new NewLoanModel();

        $newLoan->ClientREF = $clientId;
        $newLoan->Amt = $loanAmount;
        $newLoan->Tenor = $tenor;
        $newLoan->LoanPurpose = $purpose;
        $newLoan->Affordability = $affordability;
        $newLoan->ApplicDate = date('Y-m-d H:i:s');
        $newLoan->LoanTypeRef = $loanType;
        $newLoan->agentID = $agentId;
        $newLoan->LStateRef = 1;

        $newLoan->save();

        return response()->json([
           'message' => 'Loan Booked successfully'
        ]);
    }

    public function clientBookLoan(Request $request){

        $loanAmount = $request->input('data.amount');
        $tenor = $request->input('data.tenor');
        $purpose = $request->input('data.purpose');
        $affordability = $request->input('data.affordability');
        $clientId = $request->input('data.clientId');

        $newLoan = new ClientLoanModel();

        $newLoan->ClientREF = $clientId;
        $newLoan->LoanAmount = $loanAmount;
        $newLoan->Tenor = $tenor;
        $newLoan->LoanPurpose = $purpose;
        $newLoan->Affordability = $affordability;
        $newLoan->DateRequested = date('Y-m-d H:i:s');
        $newLoan->ELStateRef = 1;

        $newLoan->save();

        return response()->json([
            'message' => 'Loan Booked successfully'
        ]);
    }

    public function changePassword(Request $request)
    {
        $agentId = $request->input('data.agentId');
        $oldPassword = md5($request->input('data.oldPassword'));
        $newPassword = md5($request->input('data.newPassword'));

        $agent = AgentsModel::query()
            ->where('AgentID', $agentId)
            ->where('LoginPass', $oldPassword)
            ->first();

        if(!$agent){
            return response()->json([
                'message' => 'Invalid agent'
            ]);
        }

        $agent->LoginPass = $newPassword;
        $agent->save();

        return response()->json([
            'message' => 'Password Successfully Changed'
        ]);
    }

    public function clientChangePassword(Request $request)
    {
        $clientId = $request->input('data.clientId');
        $oldPassword = md5($request->input('data.oldPassword'));
        $newPassword = md5($request->input('data.newPassword'));

        $client = NewClientModel::query()
            ->where('ClientIndex', $clientId)
            ->where('LoginPASS', $oldPassword)
            ->first();

        if(!$client){
            return response()->json([
                'message' => 'Invalid agent'
            ], 404);
        }

        $client->LoginPass = $newPassword;
        $client->save();

        return response()->json([
            'message' => 'Password Successfully Changed'
        ]);
    }

    public function getLoanTypes (){
        $loanTypes = DB::table('agentloantypes')
            ->get();

        return response()->json([
           'loanTypes' => $loanTypes
        ]);
    }

    public function addLoanComment (Request $request){
        $loanId = $request->input('data.loanId');
        $loanComment = $request->input('data.comment');
        $agentId = $request->input('data.agentId');

        $comment = new LoanCommentModel();
        $comment->LoanREf = $loanId;
        $comment->Descp = $loanComment;
        $comment->UserRef = $agentId;
        $comment->TheDate = date('Y-m-d');

        $comment->save();

        return response()->json([
            'message' => 'comment added'
        ]);
    }

    public function getAgentLoans(Request $request)
    {
        $agentId = $request->get('agentId');

        $loans = LoansModel::query()
            ->select('Tenor','Amt','ApplicDate','LApplicIndex','ClientRef')
            ->where('AgentID', $agentId)
            ->with(['client' => function($query){
                $query->select('ClientIndex','Firstname', 'Surname','Tel1');
            },])->get();

        return response()->json([
            'loans' => $loans
        ]);
    }

    public function getClientLoans(Request $request)
    {
        $clientId = $request->get('clientId');

        $loans = ClientLoanModel::query()
            ->select('Tenor','LoanAmount','DateRequested','MyLoanID', 'LoanPurpose', 'Affordability')
            ->where('ClientREF', $clientId)
            ->get();

        return response()->json([
            'loans' => $loans
        ]);
    }

    public function getAgentDashboardOverview(Request $request)
    {
        $agentId = $request->get('agentId');

        $totalLoans = LoansModel::query()
            ->where('agentId', $agentId)
            ->count();

        $currentDate = date('Y-m-d');
        $dailyLoans = LoansModel::query()
            ->where('ApplicDate', $currentDate)
            ->where('agentId', $agentId)
            ->count();

        $totalClients = ClientModel::query()
            ->where('AgentRef', $agentId)
            ->count();

        $dailyClients = ClientModel::query()
            ->where('AgentRef', $agentId)
            ->where('DateEnrolled', $currentDate)
            ->count();

        return response()->json([
           'totalClients' => $totalClients,
           'totalLoans' => $totalLoans,
           'dailyClients' => $dailyClients,
           'dailyLoans' => $dailyLoans
        ]);

    }

    public function getLoanComments(Request $request)
    {
        $loanId = $request->get('loanId');

        $comments = LoanCommentModel::query()
            ->select('CIndex','Descp','TheDate')
            ->where('LoanREf',$loanId)
            ->get();

        return response()->json([
           'comments' => $comments
        ]);
    }

    public function getAgentClients(Request $request)
    {
        $agentId = $request->get('agentId');

        $clients = ClientModel::query()
            ->select(
                'ClientIndex',
                'Firstname',
                'Surname',
                'Tel1',
                'Photo',
                'Email',
                'DateEnrolled',
                'ExtClientIDA',
                'IDType',
                'IDPhoto',
                'ClientID'
            )
            ->where('AgentRef', $agentId)
            ->with(['loans' => function($query){
                $query->select('Tenor','Amt', 'ApplicDate','LApplicIndex','ClientRef');
            },])->get();

        return response()->json([
            'clients' => $clients
        ]);
    }
}
