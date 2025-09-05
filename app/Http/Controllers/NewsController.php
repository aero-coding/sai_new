<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Page;
use App\Models\Project;
use App\Models\Report;
use App\Models\Tag;

class NewsController extends Controller
{
    /**
     * Muestra la página de noticias (reportes).
     *
     * @param string $locale
     * @return View
     */
    public function index(string $locale): View
    {
        // 1. Cargar el contenido base de la página "news"
        $page = Page::where("slug->{$locale}", 'news')
                    ->orWhere("slug->{$locale}", 'noticias') // Considera el slug en español
                    ->where('status', 'active')
                    ->firstOrFail();

        // 2. Cargar los reportes iniciales (los más leídos) para SSR
        $initialReports = Report::where('status', 'published')
                                ->with(['project', 'media', 'tags'])
                                ->orderBy('view_count', 'desc')
                                ->latest('published_at')
                                ->take(9) // Cargar una cantidad inicial
                                ->get();
        
        // 3. Cargar últimos proyectos para la barra lateral o sección destacada
        $recentArticles = Report::where('status', 'published')
                                //  ->whereNotIn('id', $initialReports->pluck('id'))
                                 ->with(['project', 'media', 'tags'])
                                 ->latest('published_at')
                                 ->take(6)
                                 ->get();

        // 4. Cargar todos los tags para los botones de filtro
        $tags = Tag::all();

        // 5. Pasar todos los datos a la vista
        return view('pages.news', [
            'page' => $page,
            'locale' => $locale,
            'initialReports' => $initialReports,
            'recentArticles' => $recentArticles,
            'tags' => $tags,
        ]);
    }
}
