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
        'img_layout',
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getFacadeImageUrlAttribute(): ?string
    {
        return $this->img_facade ? asset('storage/'.$this->img_facade) : null;
    }

    public function getLayoutImageUrlAttribute(): ?string
    {
        return $this->img_layout ? asset('storage/'.$this->img_layout) : null;
    }
}
