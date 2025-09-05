<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    protected $fillable = ['name', 'color_bg', 'color_text', 'slug', 'url'];
    
    protected function casts(): array
    {
        return [
            'name' => 'array',
            'url' => 'array'
        ];
    }

    // Relación polimórfica
    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }

    public function reports(): MorphToMany
    {
        return $this->morphedByMany(Report::class, 'taggable');
    }
    
    // Accesorio CORREGIDO
    public function getNameAttribute()
    {
        $nameArray = $this->attributes['name'] ?? [];
        
        // Decodificar si es JSON string
        if (is_string($nameArray)) {
            $nameArray = json_decode($nameArray, true) ?? [];
        }
        
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale');
        
        return $nameArray[$locale] ?? $nameArray[$fallback] ?? ($nameArray ? reset($nameArray) : '');
    }

    // Nuevo método para obtener el nombre crudo
    public function getRawName()
    {
        return $this->attributes['name'] ?? [];
    }
}