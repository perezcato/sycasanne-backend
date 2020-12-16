<?php

namespace App\Http\Resources\Config;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConfigResource extends JsonResource
{

    private string $deviceUUID;

    public function __construct($resource,$deviceUUID)
    {
        parent::__construct($resource);
        $this->deviceUUID = $deviceUUID;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */

    public function toArray($request): array
    {
        return [
            'index' => $this->MyIndex,
            'code' => $this->TheCode,
            'type' => $this->COMPTYPE,
            'company_details' => [
                'name' => $this->CompanyName,
                'logo_url' => $this->LogoURL,
                'deviceUUID' => $this->deviceUUID,
                'logo' => base64_encode($this->CompanyLogo)
            ],
            'database' => $this->when($this->COMPTYPE === 'MFI', [
                'host' => $this->dbHost,
                'name' => $this->dbName,
                'port' => $this->dbPort,
                'username' => $this->dbUsername,
                'password' => $this->dbPassword
            ]),
            'etables' => $this->when($this->COMPTYPE === 'ESTORES', [
                'users' => $this->ConfigUsersTable,
                'products' => $this->ConfigProductsTable,
                'branches' => $this->ConfigBranchesTable,
                'devices' => $this->ConfigDevicesTable,
            ]),
        ];
    }
}
