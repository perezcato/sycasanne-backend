<?php

namespace App\Models\MobileBanker;

use App\Http\Requests\Loan\LoanDescriptionRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDescription extends Model
{
    use HasFactory;

    protected $table = 'loancomments';
    protected $primaryKey = 'MyIndex';
    public $timestamps = false;
    protected $fillable = ['LoanREf','DetDescp','CreatedAt','UserRef','deviceRef'];


    public static function addLoanDescription(LoanDescriptionRequest $request)
    {
        return self::create([
           'LoanREf' => $request->input('data.loan_id'),
           'DetDescp' => $request->input('data.description'),
           'CreatedAt' => Carbon::now(),
           'UserRef' => $request->input('data.user_ref'),
           'deviceRef' => $request->input('data.device_ref')
        ]);
    }

}
