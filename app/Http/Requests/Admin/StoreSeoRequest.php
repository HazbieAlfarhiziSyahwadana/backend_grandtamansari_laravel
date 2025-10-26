<?php

namespace App\Http\Requests\Admin;

use App\Enums\SeoPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSeoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        return [
            'page' => ['required', Rule::enum(SeoPage::class), 'unique:seo,page'],
            'title' => ['required', 'string', 'max:255'],
            'keyword' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }
}
