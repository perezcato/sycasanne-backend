<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientStatementRequest;
use App\Jobs\Client\CreateClientStatement;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class ClientStatementController extends Controller
{
    public function index(ClientStatementRequest $request)
    {
        //CreateClientStatement::dispatch($request);
        try{
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.client-statement');
            $filename = Str::random(14);
            $pdf->save(storage_path()."/app/public/{$filename}.pdf");
            return response()->json(['pdf_name' => asset("/storage/{$filename}.pdf")]);
        }catch (Exception $e){
            return response()->json([],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
