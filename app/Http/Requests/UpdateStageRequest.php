<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'to_stage' => 'required|in:applied,phone_screen,interview,hired,rejected',
            'notes' => 'nullable|string'
        ];
    }
}
