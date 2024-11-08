<?php

namespace App\Http\Requests;


class LoginRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            'email'    => 'required',
            'password' => 'required|min:6',
        ];
    }

    
    public function authorize(): bool
    {
        return true;
    }

    
    public function messages(): array
    {
        return [
            'email.required'    => 'Please give your email',
            'password.required' => 'Please give your password',
        ];
    }
}
