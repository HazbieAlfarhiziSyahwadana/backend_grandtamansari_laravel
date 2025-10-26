<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        return [
            'company' => ['required', 'string', 'max:225'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string', 'max:225'],
            'telp' => ['required', 'string', 'max:225'],
            'whatsapp' => ['required', 'string', 'max:225'],
            'email' => ['nullable', 'email', 'max:225'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
