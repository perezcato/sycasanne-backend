<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCommentModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'loancomments';
    protected $primaryKey = 'CIndex';

    public function loan()
    {
        return $this->belongsTo(LoansModel::class, 'LoanREF');
    }
}
