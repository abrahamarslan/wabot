<?php

namespace App\Http\Requests\authentication\registration;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationStoreRequest extends FormRequest
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
            'email'             =>      'required|email|unique:users',
            'username'          =>      'required|unique:users',
            'name'              =>      'required|min:3',
            'password'          =>      'required|between:3,32',
            'password_confirm'  =>      'required|same:password',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'                => __('authentication/validation.login.email_required'),
            'name.required'                 => __('authentication/validation.login.name_required'),
            'password.required'             => __('authentication/validation.login.password_required'),
            'email.unique'                  => __('authentication/validation.login.email_unique'),
        ];
    }
}
