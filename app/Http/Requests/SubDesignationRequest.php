<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubDesignationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'designation_id' => ['required', 'exists:designations,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'designation_id.required' => 'Designation is required.',
            'designation_id.exists' => 'Selected designation does not exist.',
            'title.required' => 'Sub-designation title is required.',
            'title.max' => 'Sub-designation title cannot exceed 255 characters.',
        ];
    }
}