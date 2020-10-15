<?php

namespace App\Http\Requests\MobileBanker;

use Illuminate\Foundation\Http\FormRequest;

class LoanRepaymentRequest extends FormRequest
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
            'data.loan_amount' => ['required'],
            'data.loan_ref' => ['required'],
            'data.client_ref' => ['required'],
            'data.loan_description' => ['required']
        ];
    }
}
