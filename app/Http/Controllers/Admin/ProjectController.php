<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project; // Asegúrate que el modelo User esté importado si lo usas
use App\Models\User; // Importa el modelo User
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Para obtener el usuario autenticado
use Illuminate\Support\Str;
use App\Models\Tag;
use App\Models\Uphoto;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */



    public function index2()
{
    $projects = Project::all(); // O con filtros, como 'published'

    return view('test.loco', compact('projects')); //qie gei
}
    public function index(): View
    {
        $projects = Project::with('user') // Carga la relación con el usuario para mostrar el autor
            ->orderBy('published_at', 'desc')
            ->orderBy('title->' . app()->getLocale())
            ->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        $tags = Tag::all();
        return view('admin.projects.create', compact('tags')); // Necesitarás crear esta vista
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación (adaptar reglas según necesidad para 'create')
        $rules = $this->getValidationRules();
        // User ID no es parte del form, se añade aquí
        // Tags y social_links podrían necesitar un pre-procesamiento si vienen como strings

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $projectData = $request->only([
            'title', 'slug', 'excerpt', 'status', 'donation_iframe',
            'video_iframe', 'content', 'meta', 'published_at', 'text_editor_content'
        ]);

        // Manejo de 'tags' (si vienen como string separado por comas)
        if ($request->filled('tags_input')) {
            $projectData['tags'] = array_map('trim', explode(',', $request->input('tags_input')));
        } else {
            $projectData['tags'] = [];
        }

        // Manejo de 'social_links'
        $projectData['social_links'] = array_filter($request->input('social_links', []));


        $project = new Project();
        $project->user_id = Auth::id(); // Asignar el usuario actual
        $project->fill($projectData); // Fill se encarga de los translatables
        $project->save(); // Guarda para obtener un ID antes de añadir media

        // $project->tags()->sync($request->input('tags', []));

        if ($request->has('tags')) {
            $project->tags()->sync($request->input('tags'));
        } else {
            $project->tags()->detach();
        }

        // Manejar featured_image
        if ($request->hasFile('featured_image_upload')) {
            $project->addMediaFromRequest('featured_image_upload')->toMediaCollection('featured_image');
        }

        // Manejar galería
        if ($request->hasFile('gallery_upload')) {
            foreach ($request->file('gallery_upload') as $file) {
                $project->addMedia($file)->toMediaCollection('gallery');
            }
        }
        
        // Manejar imágenes dinámicas en 'content'
        // (La lógica es similar a 'update', adaptada para 'store')
        foreach (config('app.available_locales', ['en']) as $locale) {
            if ($request->hasFile("content_media.{$locale}")) {
                $currentContent = $project->getTranslation('content', $locale, false) ?? [];
                foreach ($request->file("content_media.{$locale}") as $key => $file) {
                    $media = $project->addMedia($file)
                                     ->usingName($key) // Nombre del archivo original o un slug del key
                                     ->toMediaCollection($key); // $key debe ser el nombre de la colección
                    $currentContent[$key] = $media->getUrl('optimized');
                }
                $project->setTranslation('content', $locale, $currentContent);
            }
        }
        $project->save(); // Guardar nuevamente para persistir cambios en 'content' con URLs de media

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully!');
    }


    public function edit($id): View
    {
        // $project = Project::with(['tags'])->findOrFail($id);
        // $project = session()->has('project') 
        // ? session('project')
        // : Project::with(['tags'])->findOrFail($id);
        // $tags = Tag::all(); // Todos los tags disponibles
        // return view('admin.projects.edit', compact('project', 'tags'));
        $project = Project::with(['tags', 'media'])->findOrFail($id);
        $tags = Tag::all();
        return view('admin.projects.edit', compact('project', 'tags'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);
        $rules = $this->getValidationRules($project->id);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach (config('app.available_locales', ['en']) as $locale) {
            $currentContent = $project->getTranslation('content', $locale, false) ?? [];

            if ($request->has("remove_content_media.{$locale}")) {
                foreach ($request->input("remove_content_media.{$locale}") as $key => $value) {
                    if ($value == '1') { // Checkbox was checked
                        $project->clearMediaCollection($key);
                        $currentContent[$key] = ""; // Update content JSON
                    }
                }
            }

            // Upload new/replacement media
            if ($request->hasFile("content_media.{$locale}")) {
                foreach ($request->file("content_media.{$locale}") as $key => $file) {
                    if ($project->getMedia($key)->isNotEmpty()) {
                        $project->clearMediaCollection($key);
                    }
                    $media = $project->addMedia($file)
                                     ->usingName($key)
                                     ->toMediaCollection($key);
                    $currentContent[$key] = $media->getUrl('optimized'); // Update content JSON
                }
            }
            $project->setTranslation('content', $locale, $currentContent);
        }
        // Save once after all content media processing for a locale is done (or do it after all locales)
        // $project->save(); // Better to save once after all updates

        // --- Non-image 'content' fields ---
        foreach (config('app.available_locales', ['en']) as $locale) {
            $submittedContent = $request->input("content.{$locale}", []);
            // Get content potentially modified by image uploads/deletions
            $existingOrMediaModifiedContent = $project->getTranslation('content', $locale, false) ?? [];

            // We only want to update text fields from $submittedContent.
            // Image fields (keys starting with 'image_') are already handled.
            $textContentToUpdate = [];
            foreach ($submittedContent as $key => $value) {
                if (!Str::startsWith($key, 'image_')) {
                    $textContentToUpdate[$key] = $value ?? ""; // Ensure empty strings for cleared fields
                }
            }
            
            $mergedContent = array_merge($existingOrMediaModifiedContent, $textContentToUpdate);
            $project->setTranslation('content', $locale, $mergedContent);
        }

        // --- Update other translatable and non-translatable fields ---
        $projectData = $request->only([
            'title', 'slug', 'excerpt', 'status', 'donation_iframe',
            'video_iframe', 'meta', 'published_at', 'text_editor_content'
        ]);

        // Handle 'social_links'
        // Assuming social_links[platform] => url structure from form
        $projectData['social_links'] = array_filter($request->input('social_links', []));


        $project->fill($projectData);
        $project->save(); // Save all accumulated changes
        // $project->tags()->sync($request->input('tags', []));
        if ($request->has('tags')) {
            $project->tags()->sync($request->input('tags'));
        } else {
            $project->tags()->detach();
        }

        // --- Featured Image ---
        if ($request->input('remove_featured_image') == '1') {
            $project->clearMediaCollection('featured_image');
        } elseif ($request->filled('featured_image_from_library')) {
            $project->clearMediaCollection('featured_image');
            $mediaItem = Media::find($request->input('featured_image_from_library'));
            if ($mediaItem) {
                $project->addMedia($mediaItem->getPath())->toMediaCollection('featured_image');
            }
        } elseif ($request->hasFile('featured_image_upload')) {
            $project->clearMediaCollection('featured_image');
            $project->addMediaFromRequest('featured_image_upload')->toMediaCollection('featured_image');
        }

        // Manejar imágenes de contenido desde biblioteca
        foreach (config('app.available_locales', ['en']) as $locale) {
            if ($request->has("content_media_from_library.{$locale}")) {
                $currentContent = $project->getTranslation('content', $locale, false) ?? [];
                
                foreach ($request->input("content_media_from_library.{$locale}") as $key => $mediaId) {
                    if (!empty($mediaId)) {
                        // Limpiar colección existente
                        $project->clearMediaCollection($key);
                        
                        // Obtener media de biblioteca
                        $mediaItem = Media::find($mediaId);
                        
                        if ($mediaItem) {
                            // Copiar archivo al proyecto
                            $copiedMedia = $project->addMedia($mediaItem->getPath())
                                                ->toMediaCollection($key);
                            
                            $currentContent[$key] = $copiedMedia->getUrl('optimized');
                        }
                    }
                }
                $project->setTranslation('content', $locale, $currentContent);
            }
        }

        // --- Gallery Images ---
        if ($request->filled('gallery_media_ids')) {
            $mediaIds = array_filter(explode(',', $request->input('gallery_media_ids')));
            
            $existingMediaIds = $project->getMedia('gallery')->pluck('id')->toArray();
            
            // Sincronizar sin eliminar toda la colección
            foreach ($mediaIds as $mediaId) {
                if (!in_array($mediaId, $existingMediaIds)) {
                    $media = Media::find($mediaId);
                    if ($media) {
                        $project->addMedia($media->getPath())
                                ->toMediaCollection('gallery');
                    }
                }
            }
            
            // Eliminar medios no seleccionados
            foreach ($existingMediaIds as $existingId) {
                if (!in_array($existingId, $mediaIds)) {
                    $project->deleteMedia($existingId);
                }
            }
        }
        // if ($request->filled('gallery_media_ids')) {
        //     $mediaIds = explode(',', $request->input('gallery_media_ids'));
            
        //     $project->clearMediaCollection('gallery');
            
        //     foreach ($mediaIds as $mediaId) {
        //         $media = Media::find($mediaId);
                
        //         if ($media && Storage::exists($media->getPath())) {
        //             $project->addMedia($media->getPath())
        //                 ->toMediaCollection('gallery');
        //         } else {
        //             Log::warning("Media file missing: {$mediaId}");
        //         }
        //     }
        // }

        return redirect()->route('admin.projects.edit', $project->id)->with('success', 'Project updated successfully!');
    }

     public function uploadImageNew2(Request $request): JsonResponse
     {

        $projects=Project::all();

        $photos=Uphoto::all();
     }

     public function uploadImageNew(Request $request){

        $projects=Project::all();

        $photos=Uphoto::all();


        foreach($photos as $photo){

            $id=$photo->modelid;
            $idn=$photo->id;
            $ext=$photo->ext;
            $project = Project::findOrFail($id);

    if($idn<=292){
        continue;

    }  
    try{
            
            $ruta=public_path("images/{$ext}");
             if (!File::exists($ruta)) {
        continue;}
        
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
        $media = $project
            ->addMedia($uploadedFile)
            ->preservingOriginal()
            ->toMediaCollection('gallery'); //subo a gallery

        File::delete($tempPath); //borrar archivo viejo  
    }
        }

        catch(\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }


        

         
        

    }
    return response()->json([
            'success' => true,
            'media_id' => $media->id,
            'url' => $media->getUrl(),
        ]);
   

     }

    public function uploadImage(Request $request, $id): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120', // Límite de 5MB
        ]);

        try {
            $project = Project::findOrFail($id);

            // Guardamos la imagen en una colección 'content_images' para este proyecto
            $media = $project->addMediaFromRequest('file')
                             ->toMediaCollection('content_images');

            // Devolvemos la URL que TinyMCE espera
            return response()->json(['location' => $media->getUrl()]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $project = Project::findOrFail($id);
        $project->delete(); // Spatie Media Library will auto-delete associated media if configured, or handle manually.
        // return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
        return redirect()->route('admin.projects.index', $project->id)
        ->with('success', 'Project updated successfully!')
        ->with('project', $project->load('tags'));  
    }

    /**
     * Get validation rules for store/update.
     */
    private function getValidationRules($projectId = null): array
    {
        $rules = [
            'status' => 'required|in:draft,published', // Statuses for Project
            'published_at' => 'nullable|date',
            'tags_input' => 'nullable|string', // For comma-separated tags
            'social_links.facebook' => 'nullable|url', // Example for social links
            'social_links.twitter' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.website' => 'nullable|url',
            'featured_image_upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_upload.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];

        foreach (config('app.available_locales', ['en']) as $locale) {
            $rules["title.{$locale}"] = 'required|string|max:255';
            // For slug uniqueness, you'd use Rule::unique if $projectId is available (for update)
            // $slugRule = Rule::unique('projects', "slug->{$locale}");
            // if ($projectId) {
            //     $slugRule->ignore($projectId);
            // }
            // $rules["slug.{$locale}"] = ['required', 'string', 'max:255', $slugRule];
            $rules["slug.{$locale}"] = "required|string|max:255"; // Simpler version for now

            $rules["excerpt.{$locale}"] = 'nullable|string';
            $rules["donation_iframe.{$locale}"] = 'nullable|string';
            $rules["video_iframe.{$locale}"] = 'nullable|string';

            // Validation for dynamic images within content
            $rules["content_media.{$locale}.*"] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
            // Validation for text content within content (general)
            $rules["content.{$locale}"] = 'nullable|array';
            $rules["content.{$locale}.*"] = 'nullable'; // Each item in the content array can be anything, or string for text

            $rules["meta.{$locale}"] = 'nullable|array';
            $rules["meta.{$locale}.seo_title"] = 'nullable|string|max:255';
            $rules["meta.{$locale}.seo_description"] = 'nullable|string|max:160';
            $rules["meta.{$locale}.keywords"] = 'nullable|string';
            $rules["meta.{$locale}.og_title"] = 'nullable|string|max:255';
            $rules["meta.{$locale}.og_description"] = 'nullable|string|max:255';
            $rules["meta.{$locale}.og_image"] = 'nullable|url';
        }
        return $rules;
    }
}