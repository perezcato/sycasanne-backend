<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.name' => ['required'],
            'data.contact' => ['required'],
            'data.type' => ['required'],
            'data.date_created' => ['required'],
            'data.user_ref' => ['required'],
            'data.device_id' => ['required'],
        ];
    }
}
