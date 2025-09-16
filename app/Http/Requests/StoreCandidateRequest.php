<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ];
    }
}
