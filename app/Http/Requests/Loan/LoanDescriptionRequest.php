<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class LoanDescriptionRequest extends FormRequest
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
            'data.loan_id' => ['required'],
            'data.description' => ['required'],
            'data.created_at' => ['required'],
            'data.user_ref' => ['required'],
            'data.device_ref' => ['required'],
        ];
    }
}
