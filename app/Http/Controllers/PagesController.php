<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\App; // Para App::getLocale()
use App\Models\Project; // Importar modelo Project
use App\Models\Report; // Importar modelo Report

class PagesController extends Controller
{
    public function showHome(): View
    {
        $currentLocale = App::getLocale();
        $page = Page::where("slug->{$currentLocale}", 'home')
                     ->where('status', 'active')
                     ->firstOrFail();

        $featuredProjects = Project::where('is_featured', true)->take(5)->get();
        $initialProjects = Project::where('status', 'published')->orderBy('published_at', 'desc')->take(6)->get();

        $viewName = 'pages.home';

        if (!view()->exists($viewName)) {
            abort(404, "The view for the page wasnt found.");
        }
        
        // return view($viewName, compact('page'));
        // return view($viewName, compact('page', 'featuredProjects'));
        return view('pages.home', compact('featuredProjects', 'initialProjects'));
    }

    // Método para páginas con slug localizado en la URL
    public function show(string $locale, string $page_slug): View
    {
        // El locale ya debería estar establecido por el middleware
        // $currentLocale = App::getLocale(); // Debería ser igual a $locale

        $page = Page::where("slug->{$locale}", $page_slug)
                     ->where('status', 'active')
                     ->firstOrFail();

        // Determinar la vista Blade a usar.
        // Puedes tener una convención como 'pages.{slug_en_formato_blade}'
        // o un campo en tu modelo Page que especifique la plantilla Blade a usar.
        // Por simplicidad, usaremos el slug original (ej. 'about-us' se convierte en 'pages.about_us')
        // Necesitarás una forma consistente de mapear el slug (que ahora es traducible)
        // a un nombre de vista. Podrías usar el slug del idioma por defecto como base para el nombre de la vista.
        $defaultLocaleSlug = $page->getTranslation('slug', config('app.fallback_locale', 'en'));
        $viewName = 'pages.' . str_replace('-', '_', $defaultLocaleSlug);

        if (!view()->exists($viewName)) {
            abort(404, "The view for the page'{$page_slug}' (original slug: {$defaultLocaleSlug}) wasnt found.");
        }

        return view($viewName, compact('page'));
    }

    // Opcional: Método para rutas sin prefijo de idioma (usa locale por defecto)
    /*
    public function showDefaultLocale(string $page_slug): View
    {
        $currentLocale = App::getLocale(); // Será el locale por defecto/fallback
        $page = Page::where("slug->{$currentLocale}", $page_slug)
                     ->where('status', 'active')
                     ->firstOrFail();

        $viewName = 'pages.' . str_replace('-', '_', $page_slug); // Asume que $page_slug es el del locale por defecto

        if (!view()->exists($viewName)) {
            abort(404);
        }
        return view($viewName, compact('page'));
    }
    */
}