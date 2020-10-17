<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyTokenRequest extends FormRequest
{

    public function authorize():bool
    {
        return true;
    }


    public function rules():array
    {
        return [
            'data.verification_token' => ['required']
        ];
    }
}
