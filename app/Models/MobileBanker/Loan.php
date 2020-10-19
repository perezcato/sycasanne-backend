<?php

namespace App\Models\MobileBanker;

use App\Http\Requests\Loan\GetLoansRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table='loans';

    public static function getLoansFromRequest()
    {
        return Loan::where('LStateRef','4')->get();
    }
}
