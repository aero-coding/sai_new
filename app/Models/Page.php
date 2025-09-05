<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations; // Importante para los campos traducibles
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations; // Añadir los traits

    protected $fillable = [
        'slug',         // JSON
        'title',       // Ahora es un array para traducciones
        'excerpt',     // Ahora es un array para traducciones
        'status',       // String
        'donation_iframe',  // JSON
        'video_iframe',     // JSON
        'content',     // Ahora es un array/JSON para traducciones
        'meta',     // JSON
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'array',
            'title' => 'array',
            'excerpt' => 'array',
            'content' => 'array',
            'donation_iframe' => 'array',
            'video_iframe' => 'array',
            'meta' => 'array',
            // created_at/updated_at:
            // 'published_at' => 'datetime',
        ];
    }

    public array $translatable = [
        'slug',
        'title',
        'excerpt',
        'content',
        'donation_iframe',
        'video_iframe',
        'meta',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->useDisk('public')
            ->withResponsiveImages();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('optimized')
            ->width(1200) // Ancho máximo
            ->height(800) // Alto máximo
            ->quality(80) // Calidad JPEG/Webp
            ->withResponsiveImages() // Generar versiones responsivas
            ->nonQueued(); // Para procesamiento inmediato (opcional)
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}