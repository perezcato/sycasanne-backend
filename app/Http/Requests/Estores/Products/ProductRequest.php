<?php

namespace App\Http\Requests\Estores\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'products.item_name' => 'required|string',
            'products.universal_id' => 'required|string',
            'products.sp' => 'required|string',
            'products.cp' => 'required|string',
        ];
    }
}
