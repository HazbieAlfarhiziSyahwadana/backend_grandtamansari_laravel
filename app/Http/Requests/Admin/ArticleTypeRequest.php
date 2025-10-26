<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        $typeId = $this->route('article_type')?->id ?? null;

        return [
            'type' => [
                'required',
                'string',
                'max:225',
                Rule::unique('articletype', 'type')->ignore($typeId),
            ],
        ];
    }
}