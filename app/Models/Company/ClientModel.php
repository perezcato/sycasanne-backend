<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'ClientIndex';
    public $timestamps = false;

    public function loans()
    {
        return $this->hasMany(NewLoanModel::class);
    }
}
