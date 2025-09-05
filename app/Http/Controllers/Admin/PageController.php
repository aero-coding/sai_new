<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View; // Asegúrate de importar View
use Illuminate\Http\RedirectResponse; // Para las redirecciones
use Illuminate\Support\Facades\Validator; // Para la validación
use Illuminate\Support\Str; // Para Str::slug si lo necesitas
use App\Models\Tag;
// use for media model
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::orderBy('title->'.app()->getLocale())->paginate(15); // O como prefieras ordenarlas
        return view('admin.pages.index', compact('pages'));
    }

    // public function edit(Page $page): View
    // {
    //     // $page ya viene inyectado por Route Model Binding
    //     return view('admin.pages.edit', compact('page'));
    // }

    public function edit($id): View
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // dd($request->content);
        $page = Page::findOrFail($id);
        // 1. Definir Reglas de Validación
        $rules = [
            'status' => 'required|in:draft,active,inactive',
            'featured_image_upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        foreach (config('app.available_locales', ['en']) as $locale) {
            $rules["title.{$locale}"] = 'required|string|max:255';
            $rules["slug.{$locale}"] = "required|string|max:255";
            // Rule::unique('pages', "slug->{$locale}")->ignore($page->id)

            $rules["excerpt.{$locale}"] = 'nullable|string';
            $rules["donation_iframe.{$locale}"] = 'nullable|string'; // Podrías validar que sea HTML válido si es necesario
            $rules["video_iframe.{$locale}"] = 'nullable|string';
            // if ($page->getTranslation('slug', config('app.fallback_locale', 'en')) === 'home') {
            //     $rules["content.{$locale}.main_banner_text"] = 'nullable|string|max:255';
            //     $rules["content.{$locale}.welcome_paragraph"] = 'nullable|string';
            // }
            $rules["content_media.{$locale}.*"] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
            $rules["content.{$locale}"] = 'nullable|array';
            $rules["content.{$locale}.*"] = 'nullable';
            $rules["meta.{$locale}"] = 'nullable|array';
            $rules["meta.{$locale}.seo_title"] = 'nullable|string|max:255';
            $rules["meta.{$locale}.seo_description"] = 'nullable|string|max:160';
            $rules["meta.{$locale}.keywords"] = 'nullable|string';

            $rules["meta.{$locale}.og_title"] = 'nullable|string|max:255';
            $rules["meta.{$locale}.og_description"] = 'nullable|string|max:255';
            $rules["meta.{$locale}.og_image"] = 'nullable|url';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Media Dinámica

        foreach (config('app.available_locales', ['en']) as $locale) {
            // Eliminar imágenes marcadas para remover
            if ($request->has("remove_media.{$locale}")) {
                foreach ($request->input("remove_media.{$locale}") as $key => $value) {
                    $page->clearMediaCollection($key); // Elimina la media asociada a esta clave
                    // Obtener el contenido actualizado
                    $currentContent = $page->getTranslation('content', $locale, false) ?? [];
                    $currentContent[$key] = "";
                    
                    // Actualizar la traducción
                    $page->setTranslation('content', $locale, $currentContent);
                }
            }
    
            // Subir nuevas imágenes
            if ($request->hasFile("content_media.{$locale}")) {
                foreach ($request->file("content_media.{$locale}") as $key => $file) {
                    // Eliminar imagen anterior si existe
                    if ($page->getMedia($key)->isNotEmpty()) {
                        $page->clearMediaCollection($key);
                    }
    
                    // Guardar nueva imagen usando Spatie
                    $media = $page->addMedia($file)
                        ->usingName($key)
                        ->toMediaCollection($key); // Usamos el nombre de la clave como colección
    
                    // Actualizar el content con la URL optimizada
                    $currentContent = $page->getTranslation('content', $locale, false) ?? [];
                    $currentContent[$key] = $media->getUrl('optimized');
                    $page->setTranslation('content', $locale, $currentContent);
                }
            }
        }


        foreach (config('app.available_locales', ['en']) as $locale) {
            $content = $request->input("content.$locale", []);
            $sanitizedContent = array_map(fn($item) => $item ?? "", $content);
            $existingContent = $page->getTranslation('content', $locale, false) ?? [];
            // $mergedContent = array_merge($existingContent, $sanitizedContent);
            $mergedContent = array_merge(
                $existingContent,
                array_filter($sanitizedContent, fn($v) => $v !== "")
            );
            $page->setTranslation('content', $locale, $mergedContent);
        }

        // 2. Actualizar los Campos del Modelo
        $pageData = $request->only(['title', 'slug', 'excerpt', 'status', 'donation_iframe', 'video_iframe', 'meta']); // , 'content'
        $page->fill($pageData); // fill() usa $translatable y $fillable para asignar correctamente
        // $page->content = $request->content;
        $page->save();

        // 3. Manejar la Subida de Imagen Destacada
        // if ($request->has('remove_featured_image') && $request->input('remove_featured_image') == '1') {
        //     $page->clearMediaCollection('featured_image');
        // }
        // if ($request->hasFile('featured_image_upload')) {
        //     $page->addMediaFromRequest('featured_image_upload')->toMediaCollection('featured_image');
        // }

        if ($request->input('remove_featured_image') == '1') {
            $page->clearMediaCollection('featured_image');
        } elseif ($request->filled('featured_image_from_library')) {
            $page->clearMediaCollection('featured_image');
            $mediaItem = Media::find($request->input('featured_image_from_library'));
            if ($mediaItem) {
                $page->addMedia($mediaItem->getPath())->toMediaCollection('featured_image');
            }
        } elseif ($request->hasFile('featured_image_upload')) {
            $page->clearMediaCollection('featured_image');
            $page->addMediaFromRequest('featured_image_upload')->toMediaCollection('featured_image');
        }

        foreach (config('app.available_locales', ['en']) as $locale) {
            if ($request->has("content_media_from_library.{$locale}")) {
                $currentContent = $page->getTranslation('content', $locale, false) ?? [];
                
                foreach ($request->input("content_media_from_library.{$locale}") as $key => $mediaId) {
                    if (!empty($mediaId)) {
                        // Limpiar colección existente
                        $page->clearMediaCollection($key);
                        
                        // Obtener media de biblioteca
                        $mediaItem = Media::find($mediaId);
                        
                        if ($mediaItem) {
                            // Copiar archivo al page
                            $copiedMedia = $page->addMedia($mediaItem->getPath())
                                                ->toMediaCollection($key);
                            
                            $currentContent[$key] = $copiedMedia->getUrl('optimized');
                        }
                    }
                }
                $page->setTranslation('content', $locale, $currentContent);
            }
        }

    // return redirect()->route('admin.pages.edit', $page->id)->with('success', 'Página actualizada con éxito!');
        return redirect()->route('admin.pages.edit', $page->id)->with('success', 'Page updated successfully!');
    }
}