<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewLoanModel extends Model
{
    use HasFactory;

    protected $table = 'newloans';
    public $timestamps = false;
}
