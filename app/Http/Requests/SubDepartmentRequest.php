<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'Department is required.',
            'department_id.exists' => 'Selected department does not exist.',
            'title.required' => 'Sub-department title is required.',
            'title.max' => 'Sub-department title cannot exceed 255 characters.',
        ];
    }
}