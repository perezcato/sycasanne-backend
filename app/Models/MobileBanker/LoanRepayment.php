<?php

namespace App\Models\MobileBanker;

use App\Http\Requests\MobileBanker\LoanRepaymentRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LoanRepayment extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'loanrepaymentapi';
    public $timestamps = false;
    protected $fillable = [];


    public static function addPayment(LoanRepaymentRequest $request)
    {
        return self::create([
            'LoanRef' => $request->input('data.loan_ref'),
            'ClientRef' => $request->input('data.client_ref'),
            'TheRPAmt' => $request->input('data.loan_amount'),
            'MyKyCd' => Str::uuid(),
            'RPDescp' => $request->input('data.loan_description'),
            'TheRPDate' => date("Y-m-d H:i:s"),
            'TransRefNo' => $request->input('data.transfer_reference'),
            'TheStatus' => $request->input('data.status'),
            'Longitute' => $request->input('data.longitude'),
            'Latitude' => $request->input('data.latitude'),
            'UserRef' => $request->input('data.user_ref'),
            'DeviceID' => $request->input('data.device_unique_id')
        ]);
    }

    public static function checkPayment(LoanRepaymentRequest $request): bool
    {
        $loanRepayment = self::where('LoanRef',$request->input('data.loan_ref'))
            ->where('ClientRef',$request->input('data.client_ref'))
            ->where('TheRPAmt',$request->input('data.loan_amount'))
            ->where('TransRefNo',$request->input('data.transfer'))
            ->where('ClientRef',$request->input('data.transfer_reference'))
            ->where('TheStatus',$request->input('data.status'))
            ->get();

        return $loanRepayment ? true : false;
    }
}
