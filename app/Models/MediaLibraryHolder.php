<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibraryHolder extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Define las colecciones de medios para este modelo.
     * ESTA FUNCIÓN ES LA SOLUCIÓN PARA AMBOS PROBLEMAS (SUBIR Y BORRAR).
     */
    public function registerMediaCollections(): void
    {
        // Le dice a Spatie que la colección 'default' debe usar el disco 'public'.
        $this->addMediaCollection('default')
             ->useDisk('public'); 
    }

    /**
     * Define las conversiones de imágenes (thumbnails, etc.).
     * Esto ya lo tenías, lo mantenemos igual.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // La conversión 'thumbnail' que tu vista está pidiendo.
        $this->addMediaConversion('thumbnail')
            ->width(300)
            ->height(200)
            ->quality(80)
            ->nonQueued();

        // Es buena idea añadir también la conversión 'optimized' para consistencia.
        $this->addMediaConversion('optimized')
            ->width(1200)
            ->quality(85)
            ->withResponsiveImages()
            ->nonQueued();

        $this->addMediaConversion('gallery-thumb')
            ->width(400)
            ->height(300)
            ->quality(85)
            ->nonQueued();
    }

    public function getPathAttribute()
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $this->getPath());
    }
}