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
    protected $fillable = [
        'LoanRef','ClientRef','TheRpAmt','MyKyCd',
        'RPDescp','TheRPDate','TransRefNo','TheStatus'
    ];


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
            'TheStatus' => $request->input('data.status')
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
