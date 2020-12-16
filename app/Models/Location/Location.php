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

    protected $fillable = ['UserID','Logitude','Latitude','MyTimeStamp','DeviceID'];

    public static function storeLocation(LocationRequest $request)
    {
        return self::create([
           'UserID' => $request->input('data.user_id'),
           'Logitude' =>  $request->input('data.longitude'),
            'Latitude' => $request->input('data.latitude'),
            'MyTimeStamp' => $request->input('data.date_time'),
            'DeviceID' => $request->input('data.device_unique_id')
        ]);
    }
}
