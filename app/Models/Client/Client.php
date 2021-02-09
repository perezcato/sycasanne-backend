<?php

namespace App\Models\Client;

use App\Http\Requests\Client\ClientRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;

    protected $table = 'NewClients';
    protected $primaryKey = 'MyIndex';
    public $timestamps = false;
    protected $fillable = [
        'ClientType', 'Surname', 'Firstname',
        'Telephone', 'DateCreated', 'UserREF',
        'DeviceREF', 'PicturePath'
    ];

    public static function addClient(ClientRequest $clientRequest,string $picture)
    {
        return self::create([
           'ClientType' => $clientRequest->input('data.type'),
            'Surname' => $clientRequest->input('data.name'),
            'Firstname' => $clientRequest->input('data.firstname'),
            'Telephone' => $clientRequest->input('data.contact'),
            'DateCreated' => $clientRequest->input('data.date_created'),
            'UserREF' => $clientRequest->input('data.user_ref'),
            'DeviceREF' => $clientRequest->input('data.device_id'),
            'PicturePath' => $picture,
            'GroupName' => $clientRequest->input('data.groupName')
        ]);
    }

    public static function storeClientProfile(ClientRequest $request):string
    {
        $base64image = $request->input('data.photograph');
        $base64image = Str::replaceFirst('/^data:image\/\w+;base64,','',$base64image);
        $base64image = str_replace(' ','+',$base64image);
        $imageName = $request->input('meta.company_name').'/clients/'.Str::random(10).'.'.$request->input('data.extension');
        Storage::disk('public')->put($imageName,base64_decode($base64image));
        return $imageName;
    }
}
