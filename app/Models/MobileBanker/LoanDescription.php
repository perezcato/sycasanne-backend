<?php

namespace App\Models\MobileBanker;

use App\Http\Requests\Loan\LoanDescriptionRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDescription extends Model
{
    use HasFactory;

    protected $table = 'loancomments';
    protected $primaryKey = 'MyIndex';
    public $timestamps = false;
    protected $fillable = ['LoanID','description','CreatedAt','UserRef','deviceRef'];


    public static function addLoanDescription(LoanDescriptionRequest $request)
    {
        return self::create([
           'LoanID' => $request->input('data.loan_id'),
           'description' => $request->input('data.description'),
           'CreatedAt' => $request->input('data.created_at'),
           'userRef' => $request->input('data.user_ref'),
           'deviceRef' => $request->input('data.device_ref')
        ]);
    }

}
