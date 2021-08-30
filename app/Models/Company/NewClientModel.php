<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewClientModel extends Model
{
    use HasFactory;

    protected $table = 'newclients';
    protected $primaryKey = 'MyIndex';

    public $timestamps = false;
}
