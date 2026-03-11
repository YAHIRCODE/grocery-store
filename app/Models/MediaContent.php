<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaContent extends Model
{
    protected $fillable = [
        'file_path',
        'file_type',
        'section',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Solo imágenes activas del carrusel
     */
    public static function getCarouselImages()
    {
        return self::where('section', 'carousel')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}