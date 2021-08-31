<?php

namespace App\Models\Company\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'users';
    protected $primaryKey = 'MyIndex';
}
