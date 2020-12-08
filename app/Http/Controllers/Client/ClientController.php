<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientRequest;
use App\Models\Client\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function store(ClientRequest $clientRequest)
    {
        $picture = Client::storeClientProfile($clientRequest);
        $client = Client::addClient($clientRequest,$picture);
        return response()->json([$client],Response::HTTP_CREATED);
    }
}
