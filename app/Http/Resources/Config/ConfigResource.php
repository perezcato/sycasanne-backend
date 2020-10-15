<?php

namespace App\Http\Resources\Config;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ConfigResource extends JsonResource
{
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
            'company_details' => [
                'name' => $this->CompanyName,
                'logo_url' => asset('/company_logos/'.$this->LogoURL),
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
