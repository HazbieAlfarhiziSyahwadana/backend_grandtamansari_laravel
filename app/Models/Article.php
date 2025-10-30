<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'article';

    protected $fillable = [
        'articletype_id',
        'title',
        'slug',
        'gambar',
        'caption',
        'content',
        'keyword',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ⭐ PENTING: Tambahkan ini agar image_url muncul otomatis! ⭐
    protected $appends = [
        'image_url',
    ];

    // Scope untuk artikel aktif
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ArticleType::class, 'articletype_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return null;
        }

        if (Str::startsWith($this->gambar, ['http://', 'https://'])) {
            return $this->gambar;
        }

        $normalizedPath = ltrim($this->gambar, '/');

        if (Str::startsWith($normalizedPath, 'storage/')) {
            return asset($normalizedPath);
        }

        return asset('storage/' . $normalizedPath);
    }
}