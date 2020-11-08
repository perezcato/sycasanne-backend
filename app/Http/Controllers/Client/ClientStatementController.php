<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientStatementRequest;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class ClientStatementController extends Controller
{
    public function index(ClientStatementRequest $request)
    {
        try{
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.client-statement');
            $pdf->save(storage_path()."/app/public/{$request->input('data.filename')}.pdf");
            return response()->json(['pdf_name' => asset("/storage/{$request->input('data.filename')}.pdf")]);
        }catch (Exception $e){
            return response()->json([],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
