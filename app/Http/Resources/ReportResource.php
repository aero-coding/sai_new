<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->query('lang', app()->getLocale());
        
        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale, true),
            'slug' => $this->getTranslation('slug', $locale, true),
            'excerpt' => $this->getTranslation('excerpt', $locale, true),
            'published_date' => $this->published_at?->format('M d, Y'),
            'view_count' => $this->view_count,
            
            'creator' => [
                'name' => $this->creator->name ?? 'N/A',
            ],
            
            'project' => [
                'id' => $this->project->id,
                'title' => $this->project->getTranslation('title', $locale, true),
                'slug' => $this->project->getTranslation('slug', $locale, true),
            ],
            
            'featured_image' => [
                'original' => $this->getFirstMediaUrl('featured_image'),
                'thumbnail' => $this->getFirstMediaUrl('featured_image', 'thumbnail'),
            ],
            
            'tags' => $this->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'color_bg' => $tag->color_bg,
                    'color_text' => $tag->color_text,
                ];
            }),
            
            'links' => [
                'self_web' => route('report.show.localized', [
                    'locale' => $locale,
                    'report_slug' => $this->getTranslation('slug', $locale, true)
                ]),
            ]
        ];
    }
}