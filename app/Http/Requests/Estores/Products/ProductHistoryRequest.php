<?php

namespace App\Http\Requests\Estores\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductHistoryRequest extends FormRequest
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
            'CompCODE' => 'required|string',
            'SDate' => 'required|string',
            'EDate' => 'required|string',
            'CBranch' => 'required|string',
            'Product' => 'required|string',
            'ProductUUID' => 'required|string',
            'UserRequesting' => 'required|string',
            'UserEmail' => 'required|string',
        ];
    }
}
