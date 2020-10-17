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
    protected $table = 'loanrepyment';
    public $timestamps = false;
    protected $fillable = [
        'LoanRef','ClientRef','TheRpAmt','MyKyCd',
        'RPDescp','TheRPDate'
    ];


    public static function addPayment(LoanRepaymentRequest $request)
    {
        return LoanRepayment::create([
            'LoanRef' => $request->input('data.loan_ref'),
            'ClientRef' => $request->input('data.client_ref'),
            'TheRPAmt' => $request->input('data.loan_amount'),
            'MyKyCd' => Str::uuid(),
            'RPDescp' => $request->input('data.loan_description'),
            'TheRPDate' => date("Y-m-d H:i:s")
        ]);
    }
}
