<?php

namespace App\Models\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Device extends Model
{
    use HasFactory;

    protected $table = 'appdevices';
    protected $primaryKey = 'DevIndex';
    public $timestamps = false;

    protected $fillable = [
        'DeviceTokenExpiry','DeviceToken',
        'DeviceUUID','DeviceTokenStatus',
        'DeviceStatus'
    ];

    protected $casts = [
        'DeviceTokenExpiry' => 'datetime'
    ];

    public static function register(string $deviceUUID):Device
    {
        return self::create([
            'DeviceUUID' => $deviceUUID,
            'DeviceStatus' => '1'
        ]);
    }

    public static function generateToken(string $deviceUUID, string $contact):string
    {
        $activationToken = Str::random(6);
        self::where('DeviceUUID',$deviceUUID)
            ->update([
                'DeviceToken'=> $activationToken,
                'DeviceTokenExpiry' => (new Carbon())->addHours(2)->toDateTime(),
                'DaviceTokenStatus' => 'valid',
                'AuthTelNumber' => $contact
            ]);
        return $activationToken;
    }

    public static function verifyToken($activationToken):bool
    {
        $device = self::where('DeviceToken',$activationToken)->first();
        $currentDate = Carbon::now();

        if($device && $device->getAttribute('DeviceTokenExpiry') > $currentDate){
            $device->DeviceTokenExpiry = null;
            $device->DaviceTokenStatus = 'verified';
            $device->save();
            return true;
        }

        return false;
    }
}
