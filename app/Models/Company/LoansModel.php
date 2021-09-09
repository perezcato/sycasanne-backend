<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoansModel extends Model
{
    use HasFactory;

    protected $table = 'loans';
    public $timestamps = false;
    protected $primaryKey = 'LApplicIndex';

    public function client()
    {
        return $this->belongsTo(NewClientModel::class, 'ClientRef');
    }
}
