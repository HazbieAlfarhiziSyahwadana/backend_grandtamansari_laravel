<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-content') ?? false;
    }

    public function rules(): array
    {
        $unitTypeId = $this->route('unit_type')?->id ?? $this->route('unitType')?->id;

        return [
            'name' => ['required', 'string', 'max:225'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:unit_type,slug,' . $unitTypeId],
            'img_facade' => ['nullable', 'image', 'max:4096'],
            'img_facade_mobile' => ['nullable', 'image', 'max:4096'], // BARU
            'img_layout' => ['nullable', 'image', 'max:4096'],
            'img_gallery' => ['nullable', 'image', 'max:4096'],
            'img_gallery_mobile' => ['nullable', 'image', 'max:4096'], // BARU
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
            'caption' => ['nullable', 'string', 'max:225'],
            'alt_text' => ['nullable', 'string', 'max:225'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['sometimes', 'boolean'],
            'gallery_active' => ['sometimes', 'boolean'],
        ];
    }
}