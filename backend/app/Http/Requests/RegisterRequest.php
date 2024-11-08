<?php

namespace App\Http\Requests;


class RegisterRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            'username'     => 'required|string|max:50',
            'email'    => 'required|max:255|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|integer',
        ];
    }

    
    public function authorize()
    {
        return true;
    }

    
    public function messages()
    {
        return [
            'username.required'     => 'Please give your username',
            'username.max'          => 'Please give your username between 50 characters',
            'email.required'    => 'Please give your email',
            'email.unique'      => 'User already exists by this email, please try with another email.',
            'password.required' => 'Please give your password'
        ];
    }
}
