<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Company\AgentsModel;
use App\Models\Company\AuthLogModel;
use App\Models\Company\ClientModel;
use Illuminate\Http\Request;
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
                'error' => 'Invalid agent'
            ], 401);
        }

        $token = Str::uuid();

        $authLog = new AuthLogModel();
        $authLog->agentId = $agent->AgentID;
        $authLog->loginToken = $token;
        $authLog->loginTime = date('Y-m-d H:i:s');
        $authLog->save();

        return response()->json([
            'name' => $agent->AgentName,
            'email' => $agent->AgentEMail,
            'token' => $token
        ], 200);
    }
}
