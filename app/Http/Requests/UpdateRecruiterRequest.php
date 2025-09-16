<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecruiterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:recuiters,email,' . $this->route('id'),
        ];

        // Add password validation rules if password is being updated
        if ($this->has('password')) {
            $rules['current_password'] = 'required|string';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Current password is required when updating password',
            'password.confirmed' => 'New password confirmation does not match'
        ];
    }
}
