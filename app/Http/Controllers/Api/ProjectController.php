<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource; // Asegúrate de que esto esté usando tu ProjectResource

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     * Can be filtered by a search term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        // El locale se toma del parámetro 'lang' o del idioma por defecto de la app
        $locale = $request->query('lang', app()->getLocale());

        // Consulta base
        $query = Project::query()
                        ->where('status', 'published')
                        ->with(['media', 'tags']); // Carga media y tags para el Resource

        // Si se proporciona un término de búsqueda
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            
            // Agrupamos las condiciones de búsqueda para que no interfieran con el 'status'
            $query->where(function ($q) use ($searchTerm, $locale) {
                // Buscar en el título traducido
                $q->where("title->{$locale}", 'LIKE', "%{$searchTerm}%")
                  // Buscar en las palabras clave del meta JSON traducido
                  ->orWhere("meta->{$locale}->keywords", 'LIKE', "%{$searchTerm}%");
            });
        }

        $projects = $query->latest('published_at')->paginate(10);

        // Devolvemos la colección a través del API Resource
        return ProjectResource::collection($projects);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(Project $project)
    {
        // Asegurarse que solo se muestren los publicados
        if ($project->status !== 'published') {
            abort(404);
        }
        
        // Carga relaciones y devuelve a través del Resource
        return new ProjectResource($project->load(['media', 'tags']));
    }
}
