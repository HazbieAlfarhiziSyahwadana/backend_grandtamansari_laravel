<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        return [
            'modul_link' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'numeric', 'between:0,9.99'],
        ];
    }
}
