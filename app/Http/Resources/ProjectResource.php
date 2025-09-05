<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TagResource; // Asegúrate de importar TagResource

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Usamos el parámetro 'lang' de la URL, o el idioma por defecto de la app.
        $locale = $request->query('lang', app()->getLocale());

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale, true),
            'slug' => $this->getTranslation('slug', $locale, true),
            'excerpt' => $this->getTranslation('excerpt', $locale, true),
            'published_date' => $this->published_at ? $this->published_at->format('M d, Y') : null,
            
            // Carga condicional de relaciones para eficiencia
            'author' => $this->whenLoaded('user', $this->user->name ?? 'N/A'),
            'tags' => TagResource::collection($this->whenLoaded('tags')),

            'featured_image' => [
                'original' => $this->hasMedia('featured_image') ? $this->getFirstMediaUrl('featured_image') : null,
                'optimized' => $this->hasMedia('featured_image') ? $this->getFirstMediaUrl('featured_image', 'optimized') : null,
            ],

            // Enlaces útiles para el frontend
            'links' => [
                'self_api' => route('api.projects.show', ['project' => $this->id]), // Asumiendo que nombras la ruta de la API
                'self_web' => route('projects.show.localized', [
                    'locale' => $locale,
                    'project_slug' => $this->getTranslation('slug', $locale, true)
                ]),
            ]
        ];
    }
}