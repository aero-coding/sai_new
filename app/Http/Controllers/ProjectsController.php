<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;

class ProjectsController extends Controller
{
    public function index(string $locale): View
    {
        $projects = Project::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('projects.index', compact('projects', 'locale'));
    }

    // public function show(string $locale, string $project_slug): View
    // {
    //     // Obtener el proyecto por slug y locale
    //     $project = Project::with('tags')
    //         ->where("slug->{$locale}", $project_slug)
    //         ->where('status', 'published')
    //         ->firstOrFail();

    //     // Nombre de vista basado en slug por defecto
    //     $defaultLocaleSlug = $project->getTranslation(
    //         'slug', 
    //         config('app.fallback_locale', 'en'),
    //         useFallbackLocale: true
    //     );
        
    //     // $viewName = 'projects.' . str_replace('-', '_', $defaultLocaleSlug);
    //     $viewName = 'projects.project';


    //     if (!view()->exists($viewName)) {
    //         $viewName = 'projects.show'; // Vista genérica de respaldo
    //     }

    //     return view($viewName, compact('project', 'locale'));
    // }

        public function show2(string $locale, string $project_slug): View
    {
 
        $project = Project::where("slug->{$locale}", $project_slug)->firstOrFail();


            $viewName = 'projects.project2';
            return view($viewName);
    }







    
    public function show(string $locale, string $project_slug): View
    {
        //$project =Project::find(121);
        //$project->addMedia(storage_path('app/public/tmp/8lkWrF8zk3ytXh3r85M9.jpg'))
        //->toMediaCollection('gallery');

        
        //$project =Project::find(121);
        //$project->clearMediaCollection('gallery');
        // 1. Obtener el proyecto por su slug en el idioma actual.
        $project = Project::where("slug->{$locale}", $project_slug)->firstOrFail();
            //->where('status', 'published')
            //->firstOrFail();

        // 2. Cargar eficientemente todas las relaciones necesarias para la vista
        // Esto evita múltiples consultas a la base de datos (problema N+1)
        $project->load([
            'tags', // Carga los tags del proyecto
            'media', // Carga toda la media del proyecto (featured y gallery)
            'user', // Carga el autor del proyecto
            'reports' => function ($query) {
                // Carga los reportes asociados que estén publicados
                $query->where('status', 'published')
                      ->with(['media', 'tags', 'creator']) // Para cada reporte, carga su media, tags y autor
                      ->latest('published_at');
            }
        ]);

        // 3. Preparar las variables para la vista para que el código sea más limpio
        $content = $project->getTranslation('content', $locale, true) ?? [];
        $featuredImage = $project->getFirstMediaUrl('featured_image', 'optimized');
        $galleryImages = $project->getMedia('gallery');
        $donationIframe = $project->getTranslation('donation_iframe', $locale, true);
        $textEditorContent = $project->getTranslation('text_editor_content', $locale, true);
        $videoIframe = $project->getTranslation('video_iframe', $locale, true);
        
        // El nombre de la vista que se usará.
        $viewName = 'projects.project';

        if (!view()->exists($viewName)) {
            abort(404, "The view for projects ('{$viewName}') was not found.");
        }

        // 4. Pasar todas las variables a la vista
        return view($viewName, compact(
            'project', 
            'locale', 
            'content', 
            'featuredImage', 
            'galleryImages', 
            'donationIframe',
            'textEditorContent',
            'videoIframe' 
        ));

        
        
    }
}