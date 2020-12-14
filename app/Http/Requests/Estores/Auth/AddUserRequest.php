<?php

namespace App\Http\Requests\Estores\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'user.username' => 'required',
            'user.password' => 'required',
            'user.email' => 'required',
            'user.add_users' => 'required',
            'user.change_price' => 'required',
            'user.view_sales' => 'required',
            'user.check_balance' => 'required'
        ];
    }
}
