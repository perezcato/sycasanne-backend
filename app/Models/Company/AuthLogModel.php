<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthLogModel extends Model
{
    use HasFactory;

    protected $table = 'agentsLogin';

    public $timestamps = false;
    protected $primaryKey = 'id';
}
