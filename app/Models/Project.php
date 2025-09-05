<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tag;
use App\Models\Report;

class Project extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'donation_iframe',
        'video_iframe',
        'status',
        'meta',
        'content',
        'text_editor_content',
        'social_links',
        'published_at',
        'user_id'
    ];

    

    public $translatable = [
        'slug',
        'title',
        'excerpt',
        'donation_iframe',
        'video_iframe',
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
            'donation_iframe' => 'array',
            'video_iframe' => 'array',
            'content' => 'array',
            'text_editor_content' => 'array',
            'meta' => 'array',
            'social_links' => 'array',
            'published_at' => 'datetime',
        ];
    }

    // Relación con el usuario (editor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Media: Imagen destacada + Galería
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->useDisk('public');

        $this->addMediaCollection('gallery')
            ->useDisk('public');
    }

    // Conversiones de imágenes
    public function registerMediaConversions(?Media $media = null): void
    {

        $this->addMediaConversion('thumbnail')
        ->width(300)
        ->height(200)
        ->quality(80)
        ->nonQueued();

        $this->addMediaConversion('optimized')
            ->width(1200)
            ->quality(80)
            //->withResponsiveImages();
            ->nonQueued();

        $this->addMediaConversion('gallery-thumb')
        ->width(400)
        ->height(300)
        ->quality(85)
        ->nonQueued();
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'project_id');
    }


    
}
