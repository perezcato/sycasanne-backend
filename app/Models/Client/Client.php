<?php

namespace App\Models\Client;

use App\Http\Requests\Client\ClientRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'NewClients';
    protected $primaryKey = 'MyIndex';
    public $timestamps = false;
    protected $fillable = [
        'ClientType', 'Surname', 'Firstname',
        'Telephone', 'DateCreated', 'UserREF',
        'DeviceREF', 'picture'
    ];

    public static function addClient(ClientRequest $clientRequest,string $picture)
    {
        return self::create([
           'ClientType' => $clientRequest->type,
            'Surname' => $clientRequest->name,
            'Firstname' => $clientRequest->firstname,
            'Telephone' => $clientRequest->contact,
            'DateCreated' => $clientRequest->date_created,
            'UserREF' => $clientRequest->user_ref,
            'DeviceREF' => $clientRequest->device_id,
            'picture' => $picture
        ]);
    }


}
