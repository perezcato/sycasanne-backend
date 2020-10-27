<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private string $token;
    public function __construct($resource, $token)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request):array
    {
        return [
            'id' => $this->MyIndex,
            'username' => $this->UserName,
            'full_name' => $this->RealName,
            'user_token' => $this->token
        ];
    }
}
