<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:500',
            'status' => 'nullable|in:open,closed'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'recruiter_id.required' => 'The recruiter ID is required',
            'recruiter_id.exists' => 'The selected recruiter does not exist',
            'title.required' => 'The job title is required',
            'title.max' => 'The job title must not exceed 255 characters',
            'location.max' => 'The location must not exceed 500 characters',
            'status.in' => 'The status must be either open or closed'
        ];
    }
}
