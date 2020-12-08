<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
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
            'data.id' => 'required',
            'data.client_name' => 'required',
            'data.client_reference' => 'required',
            'data.disbursement_date' => 'required',
            'data.amount' => 'required',
            'data.tenor' => 'required',
            'data.loan_image' => 'required',
            'data.mime' => 'required',
        ];
    }
}
