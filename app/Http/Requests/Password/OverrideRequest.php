<?php

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class OverrideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'super_admin_password' => 'required',
            'new_password' => 'required'
        ];
    }
}
