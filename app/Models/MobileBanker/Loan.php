<?php

namespace App\Models\MobileBanker;

use App\Http\Requests\Loan\GetLoansRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'loans';

    public static function getLoans()
    {
        return Loan::select('LApplicIndex','ClientName','ClientRef',
            'Amt','ActualDisbursalDate','Tenor')
            ->where('LStateRef','4')
            ->get();
    }
}
