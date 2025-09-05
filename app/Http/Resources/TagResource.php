<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // Gracias a tu accesor en el modelo, no necesitamos lógica de traducción aquí.
            // Laravel automáticamente llamará a getNameAttribute().
            'name' => $this->name, 
            'slug' => $this->slug,
            'colors' => [
                'background' => $this->color_bg,
                'text' => $this->color_text,
            ],
        ];
    }
}