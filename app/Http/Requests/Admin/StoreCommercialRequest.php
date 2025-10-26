<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommercialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:225'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:commercial,slug'],
            'img_commercial' => ['required', 'image', 'max:4096'],
            'img_area' => ['required', 'image', 'max:4096'],
            'land_area' => ['required', 'integer', 'min:0'],
            'floor_area' => ['required', 'integer', 'min:0'],
            'hargamulai' => ['required', 'string', 'max:225'],
            'width' => ['required', 'string', 'max:225'],
        ];
    }
}