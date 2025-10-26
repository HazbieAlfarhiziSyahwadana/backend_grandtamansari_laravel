<?php

namespace App\Http\Requests\Admin;

use App\Enums\SeoPage;
use App\Models\Seo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSeoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        /** @var Seo|null $seo */
        $seo = $this->route('seo');

        return [
            'page' => ['required', Rule::enum(SeoPage::class), Rule::unique('seo', 'page')->ignore($seo?->id)],
            'title' => ['required', 'string', 'max:255'],
            'keyword' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }
}
