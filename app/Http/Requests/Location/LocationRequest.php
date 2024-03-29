<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
            'data.user_id' => ['required'],
            'data.longitude' => ['required'],
            'data.latitude' => ['required'],
            'data.date_time' => ['required'],
            'data.device_unique_id' => ['required']
        ];
    }
}
