<?php

namespace App\Http\Resources\Config;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ConfigResource extends JsonResource
{
    private string $deviceUUID;

    public function __construct($resource, $deviceUUID)
    {
        parent::__construct($resource);
        $this->deviceUUID = $deviceUUID;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'index' => $this->MyIndex,
            'code' => $this->TheCode,
            'company_details' => [
                'name' => $this->CompanyName,
                'logo_url' => secure_asset('/company_logos/'.$this->LogoURL),
                'deviceUUID' => $this->deviceUUID,
            ],
            'database' => [
                'host' => $this->dbHost,
                'name' => $this->dbName,
                'port' => $this->dbPort,
                'username' => $this->dbUsername,
                'password' => $this->dbPassword
            ],

        ];
    }
}
