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
            'product.CompCODE' => 'required|string',
            'product.SDate' => 'required|string',
            'product.EDate' => 'required|string',
            'product.CBranch' => 'required|string',
            'product.Product' => 'required|string',
            'product.ProductUUID' => 'required|string',
            'product.UserRequesting' => 'required|string',
            'product.UserEmail' => 'required|string',
        ];
    }
}
