<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'unit_type';

    protected $fillable = [
        'name',
        'slug',
        'img_facade',
        'img_facade_mobile',
        'img_layout',
        'img_gallery',
        'img_gallery_mobile',
        'land_area',
        'floor_area',
        'bedroom',
        'bathroom',
        'floor',
        'electricity',
        'carport',
        'width',
        'price',
        'promo_price',
        'sisa_unit',
        'specification',
        'keyword',
        'caption',
        'alt_text',
        'sort',
        'active',
        'gallery_active',
    ];

    protected $casts = [
        'land_area' => 'integer',
        'floor_area' => 'integer',
        'bedroom' => 'integer',
        'bathroom' => 'integer',
        'floor' => 'integer',
        'electricity' => 'integer',
        'carport' => 'integer',
        'sisa_unit' => 'integer',
        'sort' => 'integer',
        'active' => 'boolean',
        'gallery_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Accessor untuk 'facade_image_url' - URL gambar facade desktop
     */
    public function getFacadeImageUrlAttribute(): ?string
    {
        if (!$this->img_facade) {
            return null;
        }

        // Jika sudah full URL, return as is
        if (filter_var($this->img_facade, FILTER_VALIDATE_URL)) {
            return $this->img_facade;
        }

        return asset('storage/' . $this->img_facade);
    }

    /**
     * Accessor untuk 'facade_mobile_image_url' - URL gambar facade mobile
     * Fallback ke desktop jika mobile tidak ada
     */
    public function getFacadeMobileImageUrlAttribute(): ?string
    {
        // Jika tidak ada mobile image, fallback ke desktop
        if (!$this->img_facade_mobile) {
            return $this->facade_image_url;
        }

        // Jika sudah full URL, return as is
        if (filter_var($this->img_facade_mobile, FILTER_VALIDATE_URL)) {
            return $this->img_facade_mobile;
        }

        return asset('storage/' . $this->img_facade_mobile);
    }

    /**
     * Accessor untuk 'layout_image_url' - URL gambar layout
     */
    public function getLayoutImageUrlAttribute(): ?string
    {
        if (!$this->img_layout) {
            return null;
        }

        // Jika sudah full URL, return as is
        if (filter_var($this->img_layout, FILTER_VALIDATE_URL)) {
            return $this->img_layout;
        }

        return asset('storage/' . $this->img_layout);
    }

    /**
     * Accessor untuk 'gallery_image_url' - URL gambar gallery desktop
     */
    public function getGalleryImageUrlAttribute(): ?string
    {
        if (!$this->img_gallery) {
            return null;
        }

        // Jika sudah full URL, return as is
        if (filter_var($this->img_gallery, FILTER_VALIDATE_URL)) {
            return $this->img_gallery;
        }

        return asset('storage/' . $this->img_gallery);
    }

    /**
     * Accessor untuk 'gallery_mobile_image_url' - URL gambar gallery mobile
     * Fallback ke desktop jika mobile tidak ada
     */
    public function getGalleryMobileImageUrlAttribute(): ?string
    {
        // Jika tidak ada mobile image, fallback ke desktop
        if (!$this->img_gallery_mobile) {
            return $this->gallery_image_url;
        }

        // Jika sudah full URL, return as is
        if (filter_var($this->img_gallery_mobile, FILTER_VALIDATE_URL)) {
            return $this->img_gallery_mobile;
        }

        return asset('storage/' . $this->img_gallery_mobile);
    }

    /**
     * Cek apakah unit type aktif
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Cek apakah gallery aktif
     */
    public function isGalleryActive(): bool
    {
        return $this->gallery_active;
    }

    /**
     * Scope untuk filter hanya unit yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope untuk filter hanya galeri yang aktif
     */
    public function scopeGalleryActive($query)
    {
        return $query->where('gallery_active', true);
    }

    /**
     * Scope untuk order by sort
     */
    public function scopeOrderBySort($query, $direction = 'asc')
    {
        return $query->orderBy('sort', $direction);
    }

    /**
     * Scope untuk search by name atau keyword
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('keyword', 'like', "%{$term}%");
        });
    }

    /**
     * Scope untuk filter by bedroom
     */
    public function scopeByBedroom($query, $bedroom)
    {
        return $query->where('bedroom', $bedroom);
    }

    /**
     * Scope untuk filter by price range
     */
    public function scopeByPriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->whereRaw('CAST(price AS UNSIGNED) >= ?', [$minPrice]);
        }
        
        if ($maxPrice) {
            $query->whereRaw('CAST(price AS UNSIGNED) <= ?', [$maxPrice]);
        }
        
        return $query;
    }
}