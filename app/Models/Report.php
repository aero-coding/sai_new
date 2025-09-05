<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Laravel 11 podría no necesitar esto por defecto si no usas factories para este modelo.
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Tag;

class Report extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;
    // Si usas factories para Report, descomenta:
    // use HasFactory;

    protected $fillable = [
        'project_id',
        'slug',
        'title',
        'excerpt',
        'content',
        'text_editor_content',
        'status',
        'view_count',
        'published_at',
        'creator_id',
        'editor_id', 
        'meta'
    ];

    public array $translatable = [
        'slug',
        'title',
        'excerpt',
        'content',
        'text_editor_content',
        'meta'
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'array',
            'title' => 'array',
            'excerpt' => 'array',
            'content' => 'array',
            'text_editor_content' => 'array',
            'meta' => 'array',
            'published_at' => 'datetime',
            'view_count' => 'integer',
        ];
    }

    /**
     * Relación: Un Reporte pertenece a un Proyecto.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relación: Usuario que creó el Reporte.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Relación: Usuario que editó por última vez el Reporte.
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    /**
     * Registrar colecciones de media.
     * Por ahora, solo una imagen destacada. Las imágenes de contenido se manejan dinámicamente.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->useDisk('public'); // Asegúrate que tu disco 'public' está configurado
    }

    /**
     * Registrar conversiones de media.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('optimized')
            ->width(1200) // O el tamaño que prefieras
            ->quality(80)
            ->withResponsiveImages()
            ->nonQueued(); // Procesamiento inmediato (opcional)

        $this->addMediaConversion('thumbnail')
            ->width(300) // Para vistas previas
            ->height(200)
            ->quality(75)
            ->nonQueued();
    }
    
    // Para usar el ID en las rutas de admin, si no usas Route Model Binding con el modelo directamente
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}