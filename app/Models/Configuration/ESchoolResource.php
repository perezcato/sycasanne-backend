<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ESchoolResource extends Model
{
    use HasFactory;

    protected $table = 'ConfigDb';
    protected $connection = 'setting_database';
    public $timestamps = false;
}
