<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:225'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:unit_type,slug'],
            'img_facade' => ['required', 'image', 'max:4096'],
            'img_layout' => ['required', 'image', 'max:4096'],
            'land_area' => ['required', 'integer', 'min:0'],
            'floor_area' => ['required', 'integer', 'min:0'],
            'bedroom' => ['required', 'integer', 'min:0'],
            'bathroom' => ['required', 'integer', 'min:0'],
            'floor' => ['required', 'integer', 'min:0'],
            'electricity' => ['required', 'integer', 'min:0'],
            'carport' => ['required', 'integer', 'min:0'],
            'width' => ['required', 'string', 'max:225'],
            'price' => ['nullable', 'string', 'max:150'],
            'promo_price' => ['nullable', 'string', 'max:150'],
            'sisa_unit' => ['nullable', 'integer', 'min:0'],
            'specification' => ['nullable', 'string'],
            'keyword' => ['nullable', 'string'],
        ];
    }
}