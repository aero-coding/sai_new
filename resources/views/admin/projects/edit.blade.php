@extends('layouts.admin_app')

@section('content')

    {{-- @php
        // $projectType = $project->project_type; // Si tuvieras un 'project_type'
    @endphp --}}

    <h1>{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'edit_title', app()->getLocale()) }}: {{ $project->getTranslation('title', config('app.fallback_locale', 'en')) }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.projects.update', $project->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <ul class="nav nav-tabs" id="languageTab" role="tablist">
            @foreach(config('app.available_locales', ['en']) as $locale)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                            id="{{ $locale }}-tab-project"
                            data-bs-toggle="tab"
                            data-bs-target="#content-project-{{ $locale }}"
                            type="button"
                            role="tab">
                        {{ strtoupper($locale) }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="languageTabContentProject">
            @foreach(config('app.available_locales', ['en']) as $locale)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-project-{{ $locale }}" role="tabpanel" aria-labelledby="{{ $locale }}-tab-project">
                    {{-- Título (Traducible) --}}
                    <div class="mb-3">
                        <label for="title_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'title', $locale) }} ({{ strtoupper($locale) }})</label>
                        <input type="text" class="form-control @error('title.'.$locale) is-invalid @enderror" id="title_{{ $locale }}" name="title[{{ $locale }}]" value="{{ old('title.'.$locale, $project->getTranslation('title', $locale, false)) }}">
                        @error('title.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Slug (Traducible) --}}
                    <div class="mb-3">
                        <label for="slug_{{ $locale }}" class="form-label">Slug ({{ strtoupper($locale) }})</label> {{-- No existe 'slug' en edit_texts_projects, mantenemos genérico --}}
                        <input type="text" class="form-control @error('slug.'.$locale) is-invalid @enderror" id="slug_{{ $locale }}" name="slug[{{ $locale }}]" value="{{ old('slug.'.$locale, $project->getTranslation('slug', $locale, false)) }}">
                        @error('slug.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Extracto (Traducible) --}}
                    <div class="mb-3">
                        <label for="excerpt_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'excerpt', $locale) }} ({{ strtoupper($locale) }})</label>
                        <textarea class="form-control @error('excerpt.'.$locale) is-invalid @enderror" id="excerpt_{{ $locale }}" name="excerpt[{{ $locale }}]">{{ old('excerpt.'.$locale, $project->getTranslation('excerpt', $locale, false)) }}</textarea>
                        @error('excerpt.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    {{-- Editor Content --}}
                    <hr class="my-4">
                    <h4 class="mb-3">Story (Contenido Principal del Proyecto) ({{ strtoupper($locale) }})</h4>
                    <div class="mb-3">
                        <textarea id="tinymce-editor-{{ $locale }}" 
                                name="text_editor_content[{{ $locale }}]" 
                                class="form-control" 
                                rows="15">{{ old("text_editor_content.{$locale}", $project->getTranslation('text_editor_content', $locale, false)) }}</textarea>
                    </div>
                    <hr class="my-4">

                    {{-- Iframes (Traducibles) --}}
                    <div class="mb-3">
                        <label for="donation_iframe_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'donations_iframe', $locale) }} ({{ strtoupper($locale) }})</label>
                        <textarea class="form-control" name="donation_iframe[{{ $locale }}]">{{ old('donation_iframe.'.$locale, $project->getTranslation('donation_iframe', $locale, false)) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="video_iframe_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'video_iframe', $locale) }} ({{ strtoupper($locale) }})</label>
                        <textarea class="form-control" name="video_iframe[{{ $locale }}]">{{ old('video_iframe.'.$locale, $project->getTranslation('video_iframe', $locale, false)) }}</textarea>
                    </div>

                    {{-- CONTENT (JSON Traducible) --}}
                    <h4>{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'content', $locale) }} ({{ strtoupper($locale) }}):</h4>
                    @php
                        $currentContent = $project->getTranslation('content', $locale, false) ?? [];
                        if (is_string($currentContent) && json_decode($currentContent) !== null) {
                           $currentContent = json_decode($currentContent, true);
                        } elseif (!is_array($currentContent)) {
                           $currentContent = [];
                        }
                    @endphp

                    @foreach($currentContent as $key => $value)
                        <div class="mb-3">
                            {{-- <label class="form-label">{{ Str::title(str_replace('_', ' ', $key)) }}</label> --}}
                            <label class="form-label">{{ App\Services\ContentKeyMapper::getLabel('project_content_details', $key, $locale) }}</label>
                            {{-- @if(Str::startsWith($key, 'image_'))
                                <div class="image-upload-container border p-2 rounded">
                                    @if($project->getMedia($key)->isNotEmpty())
                                        <div class="mb-2">
                                            <img src="{{ $project->getFirstMediaUrl($key, 'optimized') }}"
                                                 class="img-thumbnail"
                                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                            <div class="form-check mt-1">
                                                <input type="checkbox"
                                                       name="remove_content_media[{{ $locale }}][{{ $key }}]"
                                                       value="1"
                                                       class="form-check-input" id="remove_content_media_{{ $locale }}_{{ $key }}">
                                                <label class="form-check-label text-danger" for="remove_content_media_{{ $locale }}_{{ $key }}">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'delete_image', $locale) }}</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file"
                                           name="content_media[{{ $locale }}][{{ $key }}]"
                                           class="form-control form-control-sm">
                                    @error("content_media.{$locale}.{$key}") <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            @else
                                <textarea class="form-control @error("content.{$locale}.{$key}") is-invalid @enderror"
                                          name="content[{{ $locale }}][{{ $key }}]">{{ old("content.$locale.$key", $value) }}</textarea>
                                @error("content.{$locale}.{$key}") <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @endif --}}

                            @if(Str::startsWith($key, 'image_'))
                                <div class="image-upload-container border p-2 rounded">
                                    <div id="content_image_{{ $locale }}_{{ $key }}_preview_container" class="mb-2" 
                                        style="{{ $project->getMedia($key)->isNotEmpty() ? '' : 'display: none;' }}">
                                        @if($project->getMedia($key)->isNotEmpty())
                                            <img id="content_image_{{ $locale }}_{{ $key }}_preview" 
                                                src="{{ $project->getFirstMediaUrl($key, 'optimized') }}"
                                                class="img-thumbnail"
                                                style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                        @endif
                                        <div class="d-flex justify-content-between mt-2">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    name="remove_content_media[{{ $locale }}][{{ $key }}]"
                                                    value="1"
                                                    class="form-check-input" 
                                                    id="remove_content_media_{{ $locale }}_{{ $key }}">
                                                <label class="form-check-label text-danger" 
                                                    for="remove_content_media_{{ $locale }}_{{ $key }}">
                                                    {{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'delete_image', $locale) }}
                                                </label>
                                            </div>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="removeContentImage('{{ $locale }}', '{{ $key }}')">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="input-group">
                                        <input type="file"
                                            name="content_media[{{ $locale }}][{{ $key }}]"
                                            class="form-control form-control-sm">
                                        <button class="btn btn-outline-secondary" 
                                                type="button" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#mediaLibraryModal" 
                                                data-input-target="content_image_{{ $locale }}_{{ $key }}_from_library"
                                                data-preview-target="content_image_{{ $locale }}_{{ $key }}_preview_container">
                                            Select from Library
                                        </button>
                                    </div>
                                    
                                    <input type="hidden" 
                                        name="content_media_from_library[{{ $locale }}][{{ $key }}]" 
                                        id="content_image_{{ $locale }}_{{ $key }}_from_library">
                                </div>
                            @else
                            <textarea class="form-control @error("content.{$locale}.{$key}") is-invalid @enderror" name="content[{{ $locale }}][{{ $key }}]">{{ old("content.$locale.$key", $value) }}</textarea>
                            @error("content.{$locale}.{$key}") <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @endif
                        </div>
                    @endforeach

                    {{-- Meta & SEO (JSON Traducible) --}}
                    <hr class="my-4">
                    <h4 class="mb-3">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'meta_seo', $locale) }} ({{ strtoupper($locale) }}):</h4>
                    
                    @php
                        // Obtener la traducción actual de 'meta' para este idioma, o un array vacío si no existe
                        $currentMeta = $project->getTranslation('meta', $locale, false) ?? []; 
                    @endphp

                    {{-- SEO Title --}}
                    <div class="mb-3">
                        <label for="meta_seo_title_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'seo_title', $locale) }}</label>
                        <input type="text" class="form-control" id="meta_seo_title_{{ $locale }}" name="meta[{{ $locale }}][seo_title]" value="{{ old("meta.{$locale}.seo_title", $currentMeta['seo_title'] ?? '') }}" maxlength="70">
                        <small class="form-text text-muted">Máx 70 caracteres. Título optimizado para motores de búsqueda.</small>
                    </div>

                    {{-- SEO Description --}}
                    <div class="mb-3">
                        <label for="meta_seo_description_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'seo_desc', $locale) }}</label>
                        <textarea class="form-control" id="meta_seo_description_{{ $locale }}" name="meta[{{ $locale }}][seo_description]" rows="3" maxlength="160">{{ old("meta.{$locale}.seo_description", $currentMeta['seo_description'] ?? '') }}</textarea>
                        <small class="form-text text-muted">Máx 160 caracteres. Descripción atractiva para los resultados de búsqueda.</small>
                    </div>

                    {{-- SEO Keywords --}}
                    <div class="mb-3">
                        <label for="meta_keywords_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'seo_keywords', $locale) }}</label>
                        <input type="text" class="form-control" id="meta_keywords_{{ $locale }}" name="meta[{{ $locale }}][keywords]" value="{{ old("meta.{$locale}.keywords", $currentMeta['keywords'] ?? '') }}">
                        <small class="form-text text-muted">Palabras clave separadas por comas (opcional).</small>
                    </div>

                    {{-- Open Graph --}}
                    <h5 class="mt-4">Open Graph & Twitter Card (Redes Sociales)</h5>
                    <small class="form-text text-muted mb-2 d-block">Si se dejan en blanco, usarán el Título SEO, la Descripción SEO y la Imagen Destacada por defecto.</small>

                    <div class="mb-3">
                        <label for="og_title_{{ $locale }}" class="form-label">Título para Open Graph</label>
                        <input type="text" class="form-control" id="og_title_{{ $locale }}" name="meta[{{ $locale }}][og_title]" value="{{ old("meta.{$locale}.og_title", $currentMeta['og_title'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="og_description_{{ $locale }}" class="form-label">Descripción para Open Graph</label>
                        <textarea class="form-control" id="og_description_{{ $locale }}" name="meta[{{ $locale }}][og_description]" rows="2">{{ old("meta.{$locale}.og_description", $currentMeta['og_description'] ?? '') }}</textarea>
                    </div>
                    {{-- TODO URL --}}
                    {{-- <div class="mb-3">
                        <label for="og_image_{{ $locale }}" class="form-label">URL de la Imagen para Open Graph</label>
                        <input type="url" class="form-control" id="og_image_{{ $locale }}" name="meta[{{ $locale }}][og_image]" value="{{ old("meta.{$locale}.og_image", $currentMeta['og_image'] ?? '') }}" placeholder="https://tudominio.com/ruta/a/imagen-og.jpg">
                        <small class="form-text text-muted">Introduce una URL completa. Tamaño recomendado: 1200x630px.</small>
                    </div> --}}
                </div> {{-- Cierre de .tab-pane --}}
            @endforeach
        </div> {{-- Cierre de .tab-content --}}
        <hr>

        @php
            $projectTags = $project->tags;
        @endphp

        {{-- Bloque de tags asignados --}}
        <div class="mb-3">
            <label class="form-label">Tags Asignados al Proyecto:</label>
            <div class="d-flex flex-wrap gap-2 mb-3" id="assigned-tags-container">
                @foreach($projectTags as $tag)
                    <span class="badge p-2 d-flex align-items-center" 
                        style="background-color: {{ $tag->color_bg }}; color: {{ $tag->color_text }};">
                        {{ $tag->name }}
                        <button type="button" class="btn-close ms-2" 
                            style="filter: invert(1); font-size: 0.7rem;"
                            data-tag-id="{{ $tag->id }}"
                            onclick="removeTag(this)"></button>
                    </span>
                @endforeach
                @if($projectTags->isEmpty())
                    <span class="text-muted">No hay tags asignados</span>
                @endif
            </div>
        </div>

        {{-- Selector de tags --}}
        <div class="mb-3">
            <label class="form-label">Asignar Nuevos Tags:</label>
            <select name="tags[]" class="form-select" multiple size="5" id="tags-selector">
                @foreach($tags as $tag)
                    @php
                        $currentTagIds = $projectTags->pluck('id')->toArray();
                        $selected = in_array($tag->id, old('tags', $currentTagIds)) ? 'selected' : '';
                    @endphp
                    <option value="{{ $tag->id }}" {{ $selected }}
                        style="background-color: {{ $tag->color_bg }}; color: {{ $tag->color_text }};">
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <hr>
        {{-- Campos No Traducibles --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="status" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'status', app()->getLocale()) }}</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="published_at" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'publication', app()->getLocale()) }}</label>
                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at', $project->published_at ? $project->published_at->format('Y-m-d\TH:i') : '') }}">
                @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
        </div>

        {{-- Social Links --}}
        <h4>Social Links:</h4> {{-- No existe 'social_links_title' en edit_texts_projects, mantenemos genérico --}}
        <div class="row">
            @php
                // Definimos las plataformas y sus etiquetas aquí directamente o las podríamos obtener del ContentKeyMapper si tuvieran entradas individuales.
                // Por ahora, las etiquetas serán genéricas y el placeholder del input indicará la plataforma.
                $socialPlatforms = [
                    'facebook' => 'Facebook URL', 
                    'twitter' => 'Twitter URL', 
                    'linkedin' => 'LinkedIn URL', 
                    'instagram' => 'Instagram URL'
                ];
                $currentSocialLinks = old('social_links', $project->social_links ?? []);
            @endphp
            @foreach($socialPlatforms as $platform => $labelPlaceholder)
            <div class="col-md-6 mb-3">
                <label for="social_links_{{ $platform }}" class="form-label">{{ $labelPlaceholder }}</label>
                <input type="url" class="form-control @error('social_links.'.$platform) is-invalid @enderror" id="social_links_{{ $platform }}" name="social_links[{{ $platform }}]" value="{{ $currentSocialLinks[$platform] ?? '' }}" placeholder="{{ $labelPlaceholder }}">
                @error('social_links.'.$platform) <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            @endforeach
        </div>

        {{-- Imagen Destacada (Spatie Media Library) --}}
        {{-- <div class="mb-3">
            <label for="featured_image_upload" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'featured_image', app()->getLocale()) }}</label>
            <input type="file" class="form-control @error('featured_image_upload') is-invalid @enderror" id="featured_image_upload" name="featured_image_upload">
            @error('featured_image_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
            @if($project->hasMedia('featured_image'))
                <div class="mt-2">
                    <img src="{{ $project->getFirstMediaUrl('featured_image', 'optimized') }}" alt="Current featured image" class="img-thumbnail" style="max-height: 150px;">
                    <div class="form-check mt-1">
                        <input type="checkbox" class="form-check-input" name="remove_featured_image" value="1" id="remove_featured_image">
                        <label class="form-check-label text-danger" for="remove_featured_image">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'delete_image', app()->getLocale()) }}</label>
                    </div>
                </div>
            @endif
        </div> --}}

        <div class="mb-3">
            <label class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'featured_image', app()->getLocale()) }}</label>
            
            <div id="featured_image_preview_container" class="mb-2" style="{{ !$project->hasMedia('featured_image') ? 'display: none;' : '' }}">
                <img id="featured_image_preview" src="{{ $project->getFirstMediaUrl('featured_image', 'thumbnail') }}" class="img-thumbnail" style="max-height: 150px;">
                <button type="button" id="remove_featured_image_btn" class="btn btn-sm btn-outline-danger mt-1">Remove Image</button>
            </div>
        
            <div class="input-group">
                <input type="file" class="form-control" name="featured_image_upload">
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#mediaLibraryModal" data-input-target="featured_image_from_library" data-preview-target="featured_image_preview_container">
                    Select from Library
                </button>
            </div>
        
            <input type="hidden" name="featured_image_from_library" id="featured_image_from_library">
            <input type="hidden" name="remove_featured_image" id="remove_featured_image_input" value="0">
        </div>

        {{-- Galería de Imágenes --}}
        <div class="mb-3">
            <label class="form-label">Gallery Images</label>
            
            {{-- Input oculto para almacenar IDs de medios seleccionados --}}
            <input type="hidden" name="gallery_media_ids" id="gallery_media_ids" 
                value="{{ implode(',', $project->getMedia('gallery')->pluck('id')->toArray()) }}">
            
            {{-- Contenedor para previsualizar imágenes seleccionadas --}}
            <div id="gallery-preview-container" class="d-flex flex-wrap gap-2 mb-2">
                @foreach($project->getMedia('gallery') as $media)
                    <div class="position-relative" data-media-id="{{ $media->id }}">
                        <img src="{{ $media->getUrl('gallery-thumb') }}" class="img-thumbnail" 
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                onclick="removeGalleryImage({{ $media->id }})">×</button>
                    </div>
                @endforeach
            </div>
            
            <button type="button" class="btn btn-outline-secondary" 
                    data-bs-toggle="modal" 
                    data-bs-target="#mediaLibraryModal"
                    data-selection-mode="multiple"
                    data-input-target="gallery_media_ids"
                    data-preview-target="gallery-preview-container">
                Select from Library
            </button>
        </div>

        <hr>
        <button type="submit" class="btn btn-success">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'save_changes', app()->getLocale()) }}</button>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'discard_changes', app()->getLocale()) }}</a>
    </form>
    @include('admin.media.partials._modal')
@endsection

@push('styles')
<style>
    /* ESTILOS DE SELECCIÓN CORREGIDOS */
    #mediaLibraryModal .card.selected {
        border-top: 4px solid #28a745 !important;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.3);
        position: relative;
        z-index: 1;
    }
    
    #mediaLibraryModal .card.selected::after {
        content: "✓";
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        background: #28a745;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        z-index: 2;
    }

    /* Mantén los otros estilos */
    .media-library-item.selected {
        /* border: 3px solid #0d6efd; */
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.5);
    }

    #current-selection-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 15px;
        max-height: 150px;
        overflow-y: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    
    let currentSelectionMode = 'single';
    let selectedMedia = new Map();
    let currentInputTargetId, currentPreviewTargetId;

    function removeContentImage(locale, key) {
        const container = document.getElementById(`content_image_${locale}_${key}_preview_container`);
        const preview = document.getElementById(`content_image_${locale}_${key}_preview`);
        const libraryInput = document.getElementById(`content_image_${locale}_${key}_from_library`);
        
        container.style.display = 'none';
        if (preview) preview.src = '';
        if (libraryInput) libraryInput.value = '';
        
        // Marcar el checkbox de eliminación
        document.getElementById(`remove_content_media_${locale}_${key}`).checked = true;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('mediaLibraryModal');
        const modalContainer = document.getElementById('modal_media_items_container');
        const modalSearchInput = document.getElementById('modal_media_search_input');
        let currentInputTargetId, currentPreviewTargetId;
        let modalCurrentFolder = '/'; // Variable para rastrear la carpeta actual en el modal

        // Función mejorada para cargar medios en el modal
        const fetchModalMedia = (url = '{{ route("admin.media-library.index") }}') => {
            fetch(url, { 
                headers: { 'X-Requested-With': 'XMLHttpRequest' } 
            })
            .then(response => response.json())
            .then(data => {
                modalContainer.innerHTML = data.html;

                // Marcar elementos seleccionados en la nueva carga
                selectedMedia.forEach((media, id) => {
                    const mediaElement = modalContainer.querySelector(`.media-library-item[data-id="${id}"]`);
                    if (mediaElement) {
                        const card = mediaElement.closest('.card');
                        if (card) {
                            card.classList.add('selected');
                        }
                    }
                });

                // Actualizar la carpeta actual del modal
                if (data.currentFolder) {
                    modalCurrentFolder = data.currentFolder;
                }
                // Actualizar placeholder de búsqueda
                modalSearchInput.placeholder = `Search in ${modalCurrentFolder === '/' ? 'Home' : modalCurrentFolder}...`;
            })
            .catch(error => console.error('Error fetching media for modal:', error));
        };

        // modalEl.addEventListener('show.bs.modal', function (event) {
        //     const button = event.relatedTarget;
        //     currentInputTargetId = button.dataset.inputTarget;
        //     currentPreviewTargetId = button.dataset.previewTarget;
        //     modalCurrentFolder = '/'; // Resetear a raíz al abrir el modal
        //     fetchModalMedia();
        // });

        modalEl.addEventListener('hidden.bs.modal', function() {

            if (lastOpenedButton) {
                lastOpenedButton.focus();
            }

            // Limpiar selecciones y restaurar estado
            selectedMedia.clear();
            if (modalContainer) modalContainer.innerHTML = '';
            document.getElementById('current-selection-container').style.display = 'none';
        });

        modalEl.addEventListener('show.bs.modal', function (event) {
            lastOpenedButton = event.relatedTarget;
            const button = event.relatedTarget;
            currentSelectionMode = button.dataset.selectionMode || 'single';
            currentInputTargetId = button.dataset.inputTarget;
            currentPreviewTargetId = button.dataset.previewTarget;
            
            // Resetear selección
            selectedMedia.clear();
            document.getElementById('current-selection-container').style.display = 'none';
            document.getElementById('current-selection-container').innerHTML = '';
            
            // Mostrar/ocultar elementos según el modo
            const confirmBtn = document.getElementById('modal-confirm-selection');
            confirmBtn.style.display = currentSelectionMode === 'multiple' ? 'block' : 'none';
            
            modalCurrentFolder = '/';
            fetchModalMedia();
        });

        modalSearchInput.addEventListener('input', function () {
            const url = new URL('{{ route("admin.media-library.index") }}');
            if (this.value) {
                url.searchParams.append('search', this.value);
            }
            // Mantener la carpeta actual en búsquedas
            url.searchParams.append('folder', modalCurrentFolder);
            fetchModalMedia(url);
        });

        modalContainer.addEventListener('click', function(e) {
            // Manejar paginación
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                fetchModalMedia(e.target.closest('.pagination a').href);
            }
            
            // Manejar carpetas
            const folderLink = e.target.closest('.folder-link');
            if (folderLink) {
                e.preventDefault();
                const folderPath = folderLink.dataset.path;
                const url = new URL('{{ route("admin.media-library.index") }}');
                url.searchParams.append('folder', folderPath);
                fetchModalMedia(url);
            }
            
            // Manejar selección de medios
            const mediaItem = e.target.closest('.media-library-item');
            if (mediaItem) {
                const mediaId = mediaItem.dataset.id;
                
                if (currentSelectionMode === 'multiple') {
                    const card = mediaItem.closest('.card');
                    if (selectedMedia.has(mediaId)) {
                        // Deseleccionar
                        selectedMedia.delete(mediaId);
                        card.classList.remove('selected');
                    } else {
                        // Seleccionar
                        selectedMedia.set(mediaId, {
                            id: mediaId,
                            thumbnailUrl: mediaItem.dataset.thumbnailUrl
                        });
                        card.classList.add('selected');
                    }
                    
                    // Actualizar vista previa
                    updateSelectionPreview();
                } else {
                    // Selección INDIVIDUAL (featured image)
                    const inputTarget = document.getElementById(currentInputTargetId);
                    const previewContainer = document.getElementById(currentPreviewTargetId);
                    
                    if (inputTarget) inputTarget.value = mediaId;
                    
                    if (previewContainer) {
                        let previewImg = previewContainer.querySelector('img');
                        if (!previewImg) {
                            previewImg = document.createElement('img');
                            previewImg.classList.add('img-thumbnail');
                            previewImg.style.maxWidth = '200px';
                            previewImg.style.maxHeight = '200px';
                            previewImg.style.objectFit = 'cover';
                            previewContainer.prepend(previewImg);
                        }
                        previewImg.src = mediaItem.dataset.thumbnailUrl;
                        previewImg.alt = mediaItem.alt || '';
                        previewContainer.style.display = 'block';
                    }
                    
                    // Resetear el campo de eliminación si es una imagen de contenido
                    if (currentInputTargetId && currentInputTargetId.includes('content_image')) {
                        const parts = currentInputTargetId.split('_');
                        const locale = parts[2];
                        const key = parts[3];
                        const removeCheckbox = document.getElementById(`remove_content_media_${locale}_${key}`);
                        if (removeCheckbox) removeCheckbox.checked = false;
                    }
                    
                    // Cerrar el modal
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }
            }
        });

        document.getElementById('modal-confirm-selection').addEventListener('click', function() {
            if (currentSelectionMode === 'multiple') {
                const inputTarget = document.getElementById(currentInputTargetId);
                if (inputTarget) {
                    // Convertir Map a array de IDs
                    inputTarget.value = Array.from(selectedMedia.keys()).join(',');
                    updateGalleryPreview(Array.from(selectedMedia.keys()), currentPreviewTargetId);
                }
                
                // Cerrar modal
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                modalInstance.hide();
            }
        });

        document.getElementById('remove_featured_image_btn')?.addEventListener('click', function() {
            document.getElementById('featured_image_preview_container').style.display = 'none';
            document.getElementById('featured_image_preview').src = '';
            document.getElementById('featured_image_from_library').value = '';
            document.getElementById('remove_featured_image_input').value = '1';
        });

        // Botón "Home" en el modal
        document.getElementById('modal_go_home')?.addEventListener('click', function() {
            const url = new URL('{{ route("admin.media-library.index") }}');
            url.searchParams.append('folder', '/');
            fetchModalMedia(url);
        });

        function updateSelectionPreview() {
            const selectionContainer = document.getElementById('current-selection-container');
            if (!selectionContainer) return;
            
            selectionContainer.innerHTML = '';
            selectionContainer.style.display = selectedMedia.size ? 'block' : 'none';
            
            selectedMedia.forEach(media => {
                selectionContainer.innerHTML += `
                    <img src="${media.thumbnailUrl}" 
                        class="img-thumbnail" 
                        style="width:50px;height:50px;object-fit:cover;"
                        data-id="${media.id}">`;
            });
        }

    });

    function removeGalleryImage(mediaId) {
        const mediaIdsInput = document.getElementById('gallery_media_ids');
        const currentIds = mediaIdsInput.value.split(',').filter(id => id !== mediaId.toString());
        mediaIdsInput.value = currentIds.join(',');
        
        document.querySelector(`#gallery-preview-container div[data-media-id="${mediaId}"]`).remove();
    }

    // Función para actualizar la previsualización de la galería
    // function updateGalleryPreview(mediaIds, previewContainerId) {
    //     const container = document.getElementById(previewContainerId);
    //     container.innerHTML = '';
        
    //     mediaIds.forEach(id => {
    //         // Buscar el elemento en el modal para obtener los datos
    //         const mediaCard = document.querySelector(`.media-library-item[data-id="${id}"]`);
    //         if (mediaCard) {
    //             const thumbnailUrl = mediaCard.dataset.thumbnailUrl;
    //             container.innerHTML += `
    //                 <div class="position-relative" data-media-id="${id}">
    //                     <img src="${thumbnailUrl}" class="img-thumbnail" 
    //                         style="width: 100px; height: 100px; object-fit: cover;">
    //                     <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
    //                             onclick="removeGalleryImage(${id})"></button>
    //                 </div>
    //             `;
    //         }
    //     });
    // }    

    // function updateGalleryPreview(mediaIds, containerId) {           // ENSEÑA IMÁGENES DE LA CARPETA ACTUAL
    //     const container = document.getElementById(containerId);
    //     container.innerHTML = '';
        
    //     mediaIds.forEach(id => {
    //         const mediaCard = document.querySelector(`.media-library-item[data-id="${id}"]`);
    //         if (mediaCard) {
    //             container.innerHTML += `
    //                 <div class="position-relative" data-media-id="${id}">
    //                     <img src="${mediaCard.dataset.thumbnailUrl}" 
    //                         class="img-thumbnail" 
    //                         style="width:100px;height:100px;object-fit:cover;"
    //                         alt="${mediaCard.alt || ''}"> <!-- Añade alt text aquí -->
    //                     <button type="button" 
    //                             class="btn btn-sm btn-danger position-absolute top-0 end-0"
    //                             onclick="removeGalleryImage(${id})">×</button>
    //                 </div>
    //             `;
    //         }
    //     });
    // }

    function updateGalleryPreview(mediaIds, containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = '';
        
        mediaIds.forEach(id => {
            // Buscar en el Map de selecciones en lugar del DOM
            const mediaInfo = selectedMedia.get(id);
            if (mediaInfo) {
                container.innerHTML += `
                    <div class="position-relative" data-media-id="${id}">
                        <img src="${mediaInfo.thumbnailUrl}" 
                            class="img-thumbnail" 
                            style="width:100px;height:100px;object-fit:cover;"
                            alt="">
                        <button type="button" 
                                class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                onclick="removeGalleryImage(${id})">×</button>
                    </div>
                `;
            }
        });
    }

</script>
<script>
    // Función para quitar tags visualmente
    function removeTag(button) {
        const tagId = button.getAttribute('data-tag-id');
        const tagOption = document.querySelector(`#tags-selector option[value="${tagId}"]`);
        
        if (tagOption) {
            tagOption.selected = false;
        }
        
        button.closest('.badge').remove();
        
        // Si no quedan tags, mostrar mensaje
        if(document.querySelectorAll('#assigned-tags-container .badge').length === 0) {
            document.querySelector('#assigned-tags-container').innerHTML = 
                '<span class="text-muted">No hay tags asignados</span>';
        }
    }

    // Actualizar visualización al seleccionar tags
    document.getElementById('tags-selector').addEventListener('change', function() {
        const container = document.getElementById('assigned-tags-container');
        container.innerHTML = '';
        let hasTags = false;
        
        Array.from(this.selectedOptions).forEach(option => {
            container.innerHTML += `
                <span class="badge p-2 d-flex align-items-center" 
                    style="background-color: ${option.style.backgroundColor}; 
                           color: ${option.style.color};">
                    ${option.text}
                    <button type="button" class="btn-close ms-2" 
                        style="filter: invert(1); font-size: 0.7rem;"
                        data-tag-id="${option.value}"
                        onclick="removeTag(this)"></button>
                </span>
            `;
            hasTags = true;
        });
        
        if(!hasTags) {
            container.innerHTML = '<span class="text-muted">No hay tags asignados</span>';
        }
    });
</script>
<script src="{{ asset('tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const initializeTinyMCE = (selector) => {
        // Obtenemos el ID del proyecto desde la URL de la acción del formulario.
        const formAction = document.querySelector('form').getAttribute('action');
        // El formato es http://.../admin/projects/{id}, el ID es el último segmento
        const projectId = formAction.split('/').pop();

        if (!document.querySelector(selector)) return;

        tinymce.init({
            selector: selector,
            plugins: 'code table lists image link media',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | link image media',
            height: 600,
            relative_urls: false,
            automatic_uploads: true,
            file_picker_types: 'image',
            
            // ¡IMPORTANTE! Apuntamos a la nueva ruta de subida de imágenes para proyectos
            images_upload_handler: (blobInfo) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                // CAMBIAMOS LA RUTA AQUI
                xhr.open('POST', `/admin/projects/${projectId}/upload-image`);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                xhr.onload = () => {
                    if (xhr.status >= 400) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    try {
                        const json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location !== 'string') {
                            reject('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        resolve(json.location);
                    } catch (e) {
                        reject('Invalid JSON: ' + xhr.responseText);
                    }
                };
                xhr.onerror = () => {
                  reject('Image upload failed due to a network error.');
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }),
        });
    };

    // Lógica para inicializar el editor en el tab activo y al cambiar de tab
    // (Este código es idéntico al de reports y debería funcionar igual)
    const activeTabPane = document.querySelector('.tab-pane.active');
    if (activeTabPane) {
        const initialEditor = activeTabPane.querySelector('textarea[id^="tinymce-editor-"]');
        if (initialEditor) {
            initializeTinyMCE('#' + initialEditor.id);
        }
    }

    const languageTabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
    languageTabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (event) {
            const targetPaneId = event.target.getAttribute('data-bs-target');
            const editorTextarea = document.querySelector(targetPaneId + ' textarea[id^="tinymce-editor-"]');
            
            if (editorTextarea) {
                if (tinymce.get(editorTextarea.id)) {
                    tinymce.get(editorTextarea.id).remove();
                }
                initializeTinyMCE('#' + editorTextarea.id);
            }
        });
    });
});
</script>
@endpush