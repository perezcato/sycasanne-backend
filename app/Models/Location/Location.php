<?php

namespace App\Models\Location;

use App\Http\Requests\Location\LocationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'fieldagenttracker';
    protected $primaryKey = 'MyIndex';
    public $timestamps = false;

    protected $fillable = ['UserID','Logitude','Latitude','MyTimeStamp'];

    public static function storeLocation(LocationRequest $request)
    {
        return self::create([
           'UserID' => $request->input('data.user_id'),
           'Logitude' =>  $request->input('data.longitude'),
            'Latitude' => $request->input('data.Latitude'),
            'MyTimeStamp' => $request->input('data.date_time'),
        ]);
    }
}
