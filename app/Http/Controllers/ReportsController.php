<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ReportsController extends Controller
{
    /**
     * Muestra un reporte específico.
     * La URL no contiene el locale, por lo que se usa App::getLocale().
     *
     * @param string $report_slug
     * @return View
     */
    public function uploadFeaturedImage(Request $request, Report $report)
    {
        $request->validate([
            'featured_image' => ['required','image','mimes:jpg,jpeg,png,webp','max:5120'], // 5 MB
        ]);


         if ($request->hasFile('featured_image_upload')) {
            $report->addMediaFromRequest('featured_image_upload')->toMediaCollection('featured_image');
        }

        else{
            return back()->with('status', 'nada.');
        }

        

        return back()->with('status', 'Imagen destacada actualizada.');
    }


    public function form(Request $request,$ext,$id){


   
        $report = Report::findOrFail($id);

        //$project = Project::findOrFail($id);
        try{
            
            $ruta=public_path("images/{$ext}");
             if (!File::exists($ruta)) {
                echo "aja";
                
                }
        
        else{
        // creare una ubicacion temporal
         $tempPath = storage_path("app/temp_{$ext}");
        File::copy($ruta, $tempPath);
        //Creando el archivo

        $uploadedFile = new UploadedFile(
            $tempPath,
            $ext,
            File::mimeType($tempPath),
            null,
            true // modo test
        );
        //AHora si subire con media
        $media = $report
            ->addMedia($uploadedFile)
            ->preservingOriginal()
            ->toMediaCollection('featured_image'); //subo a gallery

        File::delete($tempPath); //borrar archivo viejo  
    }
        }

        catch(\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }

        /*$report = Report::findOrFail(2);

        return view('uploadRecPic',compact('report'));*/

       
    }

    // Eliminar imagen destacada
    public function deleteFeatured()
    {
       /* $report = Report::findOrFail(63);
        if ($media = $report->getFirstMedia('featured_image')) {
            $media->delete();
        }
        return back()->with('status', 'Imagen destacada eliminada.');*/
    }






    public function show(string $locale, string $report_slug): View
    {
        $currentLocale = App::getLocale();

        $report = Report::where("slug->{$locale}", $report_slug)
            ->where('status', 'published') // Asumiendo que los reportes tienen un status 'published'
            ->where(function ($query) { // Asegura que published_at no sea futuro o sea null
                $query->where('published_at', '<=', now())
                      ->orWhereNull('published_at');
            })
            ->with(['project' => function ($query) {
                // Asegurar que el proyecto padre también esté en un estado visible/publicado
                // Ajusta 'published' si el estado de Project es diferente (ej. 'active')
                $query->where('status', 'published'); 
            }])
            ->with('project')
            ->firstOrFail();

        if (!$report->project) {
            abort(404, 'Parent project not found or not accessible.');
        }
        $viewName = 'reports.report';
        
        if (!view()->exists($viewName)) {
            abort(404, "The view for the report ('{$viewName}') was not found.");
        }
        
        $content = $report->getTranslation('content', $locale, true) ?? [];
        $textEditorContent = $report->getTranslation('text_editor_content', $locale, true);
        $featuredImage = $report->getFirstMediaUrl('featured_image', 'optimized');
        $publishedDate = $report->published_at?->format('d M Y');
        $donationIframe = $report->project->getTranslation('donation_iframe', $locale, false);
        $projectTitle = $report->project->getTranslation('title', $locale, true);
        
        $report->increment('view_count');

        return view('reports.report', [
            'report' => $report,
            'locale' => $locale,
            'content' => $content,
            'textEditorContent' => $textEditorContent,
            'featuredImage' => $featuredImage,
            'publishedDate' => $publishedDate,
            'donationIframe' => $donationIframe,
            'projectTitle' => $projectTitle,
        ]);

        // return view($viewName, compact('report', 'locale'));
    }
}