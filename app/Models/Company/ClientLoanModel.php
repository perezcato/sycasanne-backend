<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLoanModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'newloans';
    protected $primaryKey = 'MyLoanID';
}
