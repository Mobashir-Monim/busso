<?php

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
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
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\d)(?=.*[!@#$%^&*]).*$/'
        ];
    }

    public function messages()
    {
        return [
            'password.requrired' => 'Must include a password.',
            'password.confirmed' => 'Passwords must match.',
            'password.min' => 'Password must be of at least 8 characters.',
            'password.regex' => 'Password must include at least one upper case, one lower case, one number and a special character'
        ];
    }
}
