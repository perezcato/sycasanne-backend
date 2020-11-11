<?php

namespace App\Http\Controllers\MobileBanker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\UpdateImageRequest;
use App\Http\Resources\LoanResource as Loans;
use App\Http\Resources\MobileBanker\LoanResource;
use App\Models\MobileBanker\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LoanController extends Controller
{
    public function search(Request $request)
    {
        $loan = $request->input('data.loan_query');

        $loan = is_numeric($loan) ? Loan::select('LApplicIndex','ClientName','ClientRef','Amt')
            ->where('LApplicIndex',$loan)->paginate(15) :
            Loan::select('LApplicIndex','ClientName','ClientRef','Amt')
                ->where('ClientName','LIKE','%'.$loan.'%')->paginate(15);

        return LoanResource::collection($loan);
    }

    public function index():JsonResponse
    {
        return  Loans::collection(Loan::getLoans())->response();
    }

    public function updateImage (UpdateImageRequest $request)
    {
        $image = $request->input('data.loan_image');
        $image = Str::replaceFirst('/^data:image\/\w+;base64,','',$image);
        $image = str_replace(' ','+',$image);
        Loan::where('LApplicIndex',$request->input('data.id'))->update([
            'LoanImage' =>  $image,
            'Mime' => $request->input('data.mime')
        ]);
        return response()->json([],Response::HTTP_OK);
    }
}
