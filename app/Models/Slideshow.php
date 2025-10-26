<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Slideshow extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'slideshow';

    protected $fillable = [
        'title',
        'gambar_desktop',
        'gambar_mobile',
        'link',
        'sort',
    ];

    protected $casts = [
        'sort' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'desktop_image_url',
        'mobile_image_url',
    ];

    public function getDesktopImageUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->gambar_desktop);
    }

    public function getMobileImageUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->gambar_mobile);
    }

    private function resolveImageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $normalizedPath = ltrim($path, '/');

        if (Str::startsWith($normalizedPath, 'storage/')) {
            return asset($normalizedPath);
        }

        return asset('storage/' . $normalizedPath);
    }
}



