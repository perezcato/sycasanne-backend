<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Company\AgentsModel;
use App\Models\Company\AuthLogModel;
use App\Models\Company\ClientModel;
use App\Models\Company\NewClientModel;
use App\Models\Company\NewLoanModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ClientController extends Controller
{
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
            'token' => $token
        ], 200);
    }

    public function registerAgent(Request $request)
    {
        $firstName = $request->input('data.firstname');
        $surName = $request->input('data.surname');
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
        $agent->agentPic = $agentPic;
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

        error_log($agentId);

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

        $client = NewClientModel::query()
            ->where('MyIndex', $id)
            ->first();

        if(!$client){
            return response()->json([
                'message' => 'Client not found'
            ], 404);
        }

        $client->ClientType = $clientType;
        $client->surname = $surName;
        $client->firstName = $firstName;
        $client->Photo = $picture;
        $client->Telephone = $phoneNumber;
        $client->UserREF = $agentId;
        $client->GovermentPayrollNo = $payrollId;
        $client->IDType = $idType;
        $client->IDNumber = $idNumber;
        $client->IDPhoto = $idImage;
        $client->DateCreated = date('Y-m-d H:i:s');

        $client->save();

        return response()->json([
            'message' => 'Client Received'
        ]);
    }

    public function searchClients(Request $request)
    {
        $clientName = $request->get('clientName');
        $agentId = $request->get('agentId');

        $clients = DB::table('newclients')
            ->where('UserREF',$agentId)
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

        $newLoan = new NewLoanModel();
        $newLoan->ClientREF = $clientId;
        $newLoan->LoanAmount = $loanAmount;
        $newLoan->Tenor = $tenor;
        $newLoan->LoanPurpose = $purpose;
        $newLoan->Affordability = $affordability;
        $newLoan->DateRequested = date('Y-m-d H:i:s');
        $newLoan->LoanStatus = 0;
        $newLoan->agentID = $agentId;
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
}
