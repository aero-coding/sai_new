<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = Report::with(['project:id,title', 'creator:id,name', 'editor:id,name'])->latest('published_at');

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $reports = $query->paginate(15);
        
        // Cambiar el nombre de la variable
        $projects = Project::orderBy('title->'.app()->getLocale())->get(['id', 'title']);

        return view('admin.reports.index', compact('reports', 'projects'));
    }

    public function create(Request $request): View
    {
        $projects = Project::orderBy('title->'.app()->getLocale())->get(['id', 'title']);
        $selectedProjectId = $request->query('project_id');
        $tags = Tag::all();
        return view('admin.reports.create', compact('projects', 'selectedProjectId', 'tags'));
    }

    public function createForProject(Project $project): View // Project $project aquí está bien (Route Model Binding para el proyecto padre)
    {
        return view('admin.reports.create', ['selectedProjectId' => $project->id, 'projects' => null, 'fixedProject' => $project]);
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = $this->getValidationRules(); // No necesita $id para store
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $reportData = $request->only([
            'project_id', 'title', 'slug', 'excerpt', 'content', 'status', 'published_at', 'meta', 'text_editor_content'
        ]);
        
        $reportData['creator_id'] = Auth::id();
        $reportData['editor_id'] = Auth::id(); // Para store, creator y editor son el mismo

        // Inicializar content como array si no viene o es null
        if (!isset($reportData['content']) || !is_array($reportData['content'])) {
            $reportData['content'] = [];
        }

        // Manejo del JSON content (textos)
        foreach (config('app.available_locales', ['en']) as $locale) {
            $submittedLocaleContent = $request->input("content.{$locale}", []);
            $textContentToUpdate = [];
            if (is_array($submittedLocaleContent)) {
                foreach ($submittedLocaleContent as $key => $value) {
                    if (!Str::startsWith($key, 'image_')) {
                        $textContentToUpdate[$key] = $value ?? "";
                    }
                }
            }
            // Asegurar que la clave de locale exista en content
            if (!isset($reportData['content'][$locale])) {
                $reportData['content'][$locale] = [];
            }
            $reportData['content'][$locale] = array_merge($reportData['content'][$locale], $textContentToUpdate);
        }
        
        $report = Report::create($reportData);

        if ($project = Project::find($request->project_id)) {
            $report->tags()->sync($project->tags->pluck('id'));
        } else {
            $report->tags()->sync($request->input('tags', []));
        }
        

        // Manejo de imágenes en 'content' (después de que el reporte tiene ID)
        foreach (config('app.available_locales', ['en']) as $locale) {
            if ($request->hasFile("content_media.{$locale}")) {
                $currentContent = $report->getTranslation('content', $locale, false) ?? [];
                if (!is_array($currentContent)) $currentContent = []; // Asegurar que es un array

                foreach ($request->file("content_media.{$locale}") as $key => $file) {
                    $media = $report->addMedia($file)
                                     ->usingName(Str::slug($key) . '-' . time())
                                     ->toMediaCollection($key);
                    $currentContent[$key] = $media->getUrl('optimized');
                }
                $report->setTranslation('content', $locale, $currentContent);
            }
        }

        if ($request->hasFileStartingWith("content_media")) { // Chequeo más genérico
             $report->save(); // Guardar una vez si hubo cambios en media
        }

        if ($request->hasFile('featured_image_upload')) {
            $report->addMediaFromRequest('featured_image_upload')->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.reports.index')->with('success', 'Report created successfully!');
    }

    /**
     * Show the form for editing the specified report.
     * MODIFICADO: Acepta $id en lugar de Report $report
     */
    public function edit($id): View
    {
        $report = Report::with('tags')->findOrFail($id); // Carga manual del modelo
        $report->load('project'); // Carga la relación con el proyecto
        
        // $projects es usado para el dropdown en la vista de edición si permites cambiar el proyecto padre
        // Si el proyecto padre no se puede cambiar, esta variable no es estrictamente necesaria para el form de edición del Report.
        // Pero si tu vista 'admin.reports.edit' la espera (ej. para un select aunque esté disabled), mantenla.
        $projectsForDropdown = Project::orderBy('title->'.app()->getLocale())->get(['id', 'title']);
        $tags = Tag::all();

        return view('admin.reports.edit', compact('report', 'projectsForDropdown', 'tags'));
    }

    /**
     * Update the specified report in storage.
     * MODIFICADO: Acepta $id en lugar de Report $report
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $report = Report::findOrFail($id); // Carga manual del modelo
        $rules = $this->getValidationRules($report->id); // Pasar el ID para la regla unique
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $reportData = $request->only([
            'project_id', // Si permites cambiarlo, sino quítalo del $only y no lo actualices
            'title', 'slug', 'excerpt', 'status', 'published_at', 'meta', 'text_editor_content'
        ]);
        $reportData['editor_id'] = Auth::id();

        // --- Dynamic Media within 'content' ---
        foreach (config('app.available_locales', ['en']) as $locale) {
            $currentContent = $report->getTranslation('content', $locale, false) ?? [];
            if (!is_array($currentContent)) $currentContent = [];

            if ($request->has("remove_content_media.{$locale}")) {
                // foreach ($request->input("remove_content_media.{$locale}") as $key => $value) {
                //     if ($value == '1') {
                //         $report->clearMediaCollection($key);
                //         $currentContent[$key] = "";
                //     }
                // }
                foreach ($request->input("content_media_from_library.{$locale}") as $key => $mediaId) {
                    if (!empty($mediaId)) {
                        // Limpiar la colección existente
                        $report->clearMediaCollection($key);
                        
                        // Obtener la media de la biblioteca
                        $mediaItem = Media::find($mediaId);
                        
                        if ($mediaItem) {
                            // Copiar el archivo al reporte
                            $copiedMedia = $report->addMedia($mediaItem->getPath())
                                                ->toMediaCollection($key);
                            
                            $currentContent[$key] = $copiedMedia->getUrl('optimized');
                        }
                    }
                }
            }

            if ($request->hasFile("content_media.{$locale}")) {
                foreach ($request->file("content_media.{$locale}") as $key => $file) {
                    if ($report->getMedia($key)->isNotEmpty()) {
                        $report->clearMediaCollection($key);
                    }
                    $media = $report->addMedia($file)
                                     ->usingName(Str::slug($key) . '-' . time())
                                     ->toMediaCollection($key);
                    $currentContent[$key] = $media->getUrl('optimized');
                }
            }
            $report->setTranslation('content', $locale, $currentContent);
        }
        
        // --- Non-image 'content' fields ---
        foreach (config('app.available_locales', ['en']) as $locale) {
            $submittedLocaleContent = $request->input("content.{$locale}", []);
            $existingOrMediaModifiedContent = $report->getTranslation('content', $locale, false) ?? [];
            if (!is_array($existingOrMediaModifiedContent)) $existingOrMediaModifiedContent = [];

            $textContentToUpdate = [];
            if (is_array($submittedLocaleContent)) {
                foreach ($submittedLocaleContent as $key => $value) {
                    if (!Str::startsWith($key, 'image_')) {
                        $textContentToUpdate[$key] = $value ?? "";
                    }
                }
            }
            $mergedContent = array_merge($existingOrMediaModifiedContent, $textContentToUpdate);
            $report->setTranslation('content', $locale, $mergedContent);
        }

        $report->fill($reportData);
        $report->save();

        $report->tags()->sync($request->input('tags', []));

        // Featured Image
        // if ($request->has('remove_featured_image') && $request->input('remove_featured_image') == '1') {
        //     $report->clearMediaCollection('featured_image');
        // }
        // if ($request->hasFile('featured_image_upload')) {
        //     // Elimina la anterior si existe antes de añadir la nueva
        //     if ($report->hasMedia('featured_image')) {
        //          $report->clearMediaCollection('featured_image');
        //     }
        //     $report->addMediaFromRequest('featured_image_upload')->toMediaCollection('featured_image');
        // }
        
        // --- NUEVA LÓGICA PARA GESTIONAR LA IMAGEN DESTACADA ---
    
        // 1. Si se marcó para borrar
        if ($request->input('remove_featured_image') == '1') {
            $report->clearMediaCollection('featured_image');
        }
        // 2. Si se seleccionó una imagen de la biblioteca
        elseif ($request->filled('featured_image_from_library')) {
            $report->clearMediaCollection('featured_image'); // Limpiar la anterior
            $mediaItem = Media::find($request->input('featured_image_from_library'));
            if ($mediaItem) {
                // Copia el archivo al reporte
                $report->addMedia($mediaItem->getPath())->toMediaCollection('featured_image');
            }
        }
        // 3. Si se subió un nuevo archivo (el caso original)
        elseif ($request->hasFile('featured_image_upload')) {
            $report->clearMediaCollection('featured_image'); // Limpiar la anterior
            $report->addMediaFromRequest('featured_image_upload')->toMediaCollection('featured_image');
        }
        
        // --- FIN DE LA NUEVA LÓGICA ---

        // Renombrado para evitar conflicto de variable
        // $projects = Project::orderBy('title->'.app()->getLocale())->get(['id', 'title']); // Esto no es necesario aquí
        return redirect()->route('admin.reports.edit', $report->id)->with('success', 'Report updated successfully!');
    }

    /**
     * Remove the specified report from storage.
     * MODIFICADO: Acepta $id en lugar de Report $report
     */
    public function destroy($id): RedirectResponse
    {
        $report = Report::findOrFail($id); // Carga manual del modelo
        $report->delete();
        return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully.');
    }

    private function getValidationRules($reportId = null): array // $reportId para la regla unique
    {
        $rules = [
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'featured_image_upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];

        foreach (config('app.available_locales', ['en']) as $locale) {
            $slugRule = Rule::unique('reports', "slug->{$locale}");
            if ($reportId) {
                $slugRule->ignore($reportId);
            }
            $rules["slug.{$locale}"] = ['required', 'string', 'max:255', $slugRule];
            $rules["title.{$locale}"] = 'required|string|max:255';
            $rules["excerpt.{$locale}"] = 'nullable|string';
            
            $rules["content_media.{$locale}.*"] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
            $rules["content.{$locale}"] = 'nullable|array'; 
            $rules["content.{$locale}.*"] = 'nullable|string';

            $rules["text_editor_content.{$locale}"] = 'nullable|string';

            $rules["meta.{$locale}.seo_title"] = 'nullable|string|max:70';
            $rules["meta.{$locale}.seo_description"] = 'nullable|string|max:160';
            $rules["meta.{$locale}.keywords"] = 'nullable|string';
            $rules["meta.{$locale}.og_title"] = 'nullable|string|max:70';
            $rules["meta.{$locale}.og_description"] = 'nullable|string|max:200';
        }
        return $rules;
    }

    // Helper para $request->hasFileStartingWith (usado en store)
    private function hasFileStartingWith(Request $request, string $prefix): bool
    {
        foreach ($request->allFiles() as $key => $file) {
            if (Str::startsWith($key, $prefix)) {
                return true;
            }
        }
        return false;
    }

    public function uploadImage(Request $request, $id): JsonResponse
    {
        // Validación básica para asegurarnos de que se envió un archivo
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120', // Límite de 5MB
        ]);

        try {
            // Buscamos el reporte para asociarle la imagen
            $report = Report::findOrFail($id);

            // Usamos Spatie Media Library para añadir la imagen.
            // La guardamos en una nueva colección llamada 'content_images' para no mezclarla con la 'featured_image'.
            $media = $report->addMediaFromRequest('file')
                            ->toMediaCollection('content_images');

            // TinyMCE espera una respuesta JSON con la clave "location" que contenga la URL de la imagen.
            return response()->json(['location' => $media->getUrl()]);

        } catch (\Exception $e) {
            // En caso de error, devolvemos una respuesta de error.
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }
}