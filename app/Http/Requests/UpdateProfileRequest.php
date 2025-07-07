<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'age' => ['required', 'integer', 'min:16', 'max:100'],
            'degree_name' => ['required', 'string', 'max:100'],
            'average_grade' => ['required', 'numeric', 'min:0', 'max:100'],
            'act_member' => ['boolean'],
            'leadership' => ['boolean'],
            'avatar' => ['nullable', 'image', 'max:1024'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }
} 