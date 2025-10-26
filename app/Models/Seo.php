<?php

namespace App\Models;

use App\Enums\SeoPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    protected $table = 'seo';

    protected $fillable = [
        'page',
        'title',
        'keyword',
        'description',
    ];

    protected $casts = [
        'page' => SeoPage::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
