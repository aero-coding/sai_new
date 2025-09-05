<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Page;
use App\Models\Project;
use App\Models\Report;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio con todo su contenido dinámico.
     *
     * @param string|null $locale
     * @return View
     */
    public function index(?string $locale = null): View
    {
        // Si no viene un locale de la URL (ruta '/'), usa el de la app.
        // Si viene, el middleware 'setlocale' ya lo habrá establecido.
        $currentLocale = $locale ?? app()->getLocale();

        // 1. Cargar el contenido base de la página "home"
        // Asume que el slug del idioma por defecto para la home page es 'home'
        $page = Page::where('slug->' . config('app.fallback_locale'), 'home')
                    ->where('status', 'active')
                    ->firstOrFail();

        // 2. Proyectos para el carrusel principal (ej. los 5 más recientes)
        $carouselProjects = Project::where('status', 'published')
                                   ->with('media') // Eager-load para eficiencia
                                   ->latest('published_at')
                                   ->take(5)
                                   ->get();

        // 3. Proyectos para las 3 tarjetas de proyectos (ej. al azar)
        $projectCards = Project::where('status', 'published')
                               ->with('media')
                               ->inRandomOrder()
                               ->take(3)
                               ->get();

        // 4. Reportes para las 5 tarjetas de reportes (los 5 más recientes)
        $reportCards = Report::where('status', 'published')
                             ->with(['media', 'project']) // Carga el reporte y su proyecto padre
                             ->latest('published_at')
                             ->take(5)
                             ->get();

        // 5. Pasar todos los datos a la vista
        return view('pages.home', [
            'page' => $page,
            'locale' => $currentLocale,
            'carouselProjects' => $carouselProjects,
            'projectCards' => $projectCards,
            'reportCards' => $reportCards,
        ]);
    }
}
