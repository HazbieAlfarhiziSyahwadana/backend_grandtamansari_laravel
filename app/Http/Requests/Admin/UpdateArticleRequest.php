<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        $articleId = (int) $this->route('article')?->id;

        return [
            'articletype_id' => ['required', 'exists:articletype,id'],
            'title' => ['required', 'string', 'max:225'],
            'slug' => ['nullable', 'string', 'max:191', Rule::unique('article', 'slug')->ignore($articleId)],
            'caption' => ['nullable', 'string', 'max:225'],
            'content' => ['required', 'string'],
            'keyword' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ];
    }
}