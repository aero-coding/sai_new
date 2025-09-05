<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Page;
use App\Models\Project;
use App\Models\Tag;

class ExploreController extends Controller
{
    /**
     * Muestra la página de exploración de proyectos.
     *
     * @param string $locale
     * @return View
     */
    public function index(string $locale): View
    {
        // 1. Cargar el contenido base de la página "explore"
        // Esta lógica busca el slug traducido (ej. 'explore' o 'explorar')
        $page = Page::where("slug->{$locale}", request()->segment(2))
                    ->where('status', 'active')
                    ->firstOrFail();

        // 2. Cargar los 3 proyectos iniciales para la vista (SSR para SEO)
        // La búsqueda y paginación se harán con la API en el lado del cliente.
        $initialProjects = Project::where('status', 'published')
                                  ->with(['media', 'tags']) // Eager-load para eficiencia
                                  ->inRandomOrder() // O latest('published_at') si prefieres los más nuevos
                                  ->take(3)
                                  ->get();

        // 3. Cargar todos los tags para un posible filtro futuro
        $tags = Tag::all();

        // 4. Pasar todos los datos a la vista
        return view('pages.explore', [
            'page' => $page,
            'locale' => $locale,
            'initialProjects' => $initialProjects,
            'tags' => $tags
        ]);
    }
}
