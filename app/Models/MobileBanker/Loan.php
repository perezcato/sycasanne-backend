<?php

namespace App\Models\MobileBanker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'loans';
    public $timestamps = false;

    public static function getLoans()
    {
        return Loan::select('LApplicIndex','ClientName','ClientRef',
            'Amt','ActualDisbursalDate','Tenor','Mime')
            ->where('LStateRef','4')
            ->get();
    }
}
