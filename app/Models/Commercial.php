<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commercial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'commercial';

    protected $fillable = [
        'name',
        'slug',
        'img_commercial',
        'img_area',
        'land_area',
        'floor_area',
        'hargamulai',
        'width',
    ];

    protected $casts = [
        'land_area' => 'integer',
        'floor_area' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getCommercialImageUrlAttribute(): ?string
    {
        return $this->img_commercial ? asset('storage/'.$this->img_commercial) : null;
    }

    public function getAreaImageUrlAttribute(): ?string
    {
        return $this->img_area ? asset('storage/'.$this->img_area) : null;
    }
}
