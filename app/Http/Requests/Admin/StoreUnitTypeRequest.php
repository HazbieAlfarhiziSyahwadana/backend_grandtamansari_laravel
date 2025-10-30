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
            'img_facade' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'img_facade_mobile' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'img_layout' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'img_gallery' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'img_gallery_mobile' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
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

    public function messages(): array
    {
        return [
            'img_facade.required' => 'Gambar facade desktop wajib diupload.',
            'img_facade.image' => 'File facade desktop harus berupa gambar.',
            'img_facade.mimes' => 'Gambar facade desktop harus berformat jpeg, png, jpg, atau webp.',
            'img_facade.max' => 'Ukuran gambar facade desktop maksimal 4MB.',
            
            'img_facade_mobile.image' => 'File facade mobile harus berupa gambar.',
            'img_facade_mobile.mimes' => 'Gambar facade mobile harus berformat jpeg, png, jpg, atau webp.',
            'img_facade_mobile.max' => 'Ukuran gambar facade mobile maksimal 4MB.',
            
            'img_layout.required' => 'Gambar layout wajib diupload.',
            'img_layout.image' => 'File layout harus berupa gambar.',
            'img_layout.mimes' => 'Gambar layout harus berformat jpeg, png, jpg, atau webp.',
            'img_layout.max' => 'Ukuran gambar layout maksimal 4MB.',
            
            'img_gallery.image' => 'File gallery desktop harus berupa gambar.',
            'img_gallery.mimes' => 'Gambar gallery desktop harus berformat jpeg, png, jpg, atau webp.',
            'img_gallery.max' => 'Ukuran gambar gallery desktop maksimal 4MB.',
            
            'img_gallery_mobile.image' => 'File gallery mobile harus berupa gambar.',
            'img_gallery_mobile.mimes' => 'Gambar gallery mobile harus berformat jpeg, png, jpg, atau webp.',
            'img_gallery_mobile.max' => 'Ukuran gambar gallery mobile maksimal 4MB.',
        ];
    }
}