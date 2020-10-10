<?php

namespace App\Models\MobileBanker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    use HasFactory;

    protected $connection = 'company_database';
    protected $table = 'LoanRepayment';
}
