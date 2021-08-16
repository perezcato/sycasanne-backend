<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentsModel extends Model
{
    use HasFactory;


    protected $table = 'agencyagents';
    protected $primaryKey = 'AgentID';

    public $timestamps = false;
}
