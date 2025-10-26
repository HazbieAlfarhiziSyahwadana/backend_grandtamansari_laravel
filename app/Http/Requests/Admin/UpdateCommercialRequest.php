<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommercialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        $commercialId = $this->route('commercial')?->id ?? null;

        return [
            'name' => ['required', 'string', 'max:225'],
            'slug' => ['nullable', 'string', 'max:191', Rule::unique('commercial', 'slug')->ignore($commercialId)],
            'img_commercial' => ['nullable', 'image', 'max:4096'],
            'img_area' => ['nullable', 'image', 'max:4096'],
            'land_area' => ['required', 'integer', 'min:0'],
            'floor_area' => ['required', 'integer', 'min:0'],
            'hargamulai' => ['required', 'string', 'max:225'],
            'width' => ['required', 'string', 'max:225'],
        ];
    }
}