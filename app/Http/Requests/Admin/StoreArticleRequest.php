<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        return [
            'articletype_id' => ['required', 'exists:articletype,id'],
            'title' => ['required', 'string', 'max:225'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:article,slug'],
            'caption' => ['nullable', 'string', 'max:225'],
            'content' => ['required', 'string'],
            'keyword' => ['nullable', 'string'],
            'gambar' => ['required', 'image', 'max:2048'],
        ];
    }
}