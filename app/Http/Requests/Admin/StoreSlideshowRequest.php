<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSlideshowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:225'],
            'link' => ['nullable', 'string', 'max:225'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'gambar_desktop' => ['required', 'image', 'max:4096'],
            'gambar_mobile' => ['required', 'image', 'max:4096'],
        ];
    }
}
