<?php

namespace App\Models\MobileBanker;

use App\Http\Requests\Loan\UpdateImageRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LoanImage extends Model
{
    use HasFactory;
    protected $table = 'loanImages';
    protected $primaryKey = 'LImgINdex';
    protected $fillable = [
        'LoanRef','Descp','LoanImage','Mime'
    ];

    public static function saveImageFromRequest(UpdateImageRequest $request)
    {
        $image = $request->input('data.loan_image');
        $image = Str::replaceFirst('/^data:image\/\w+;base64,','',$image);
        $image = str_replace(' ','+',$image);

        return self::create([
           'LoanRef' => $request->input('data.id'),
            'Descp' => $request->input('data.description'),
            'LoanImage' => $image,
            'Mime' => $request->input('data.mime')
        ]);
    }
}
