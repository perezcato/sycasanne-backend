<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
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

    public function registerNewExistingClient(Request $request)
    {
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        $telephone = $request->input('telephone');
        $idNumber  = $request->input('idNumber');
        $dateOfBirth = $request->input('dob');
        $email = $request->input('email');
    }
}
