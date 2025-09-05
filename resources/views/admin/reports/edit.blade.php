@extends('layouts.admin_app')

@section('content')
    <h1>Edit Report: {{ $report->getTranslation('title', config('app.fallback_locale', 'en')) }}</h1>

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

    <form method="POST" action="{{ route('admin.reports.update', $report->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Proyecto Padre (informativo) --}}
        <div class="mb-3">
            <label class="form-label">Parent Project:</label>
            <input type="text" class="form-control" value="{{ $report->project->getTranslation('title', app()->getLocale(), true) }}" readonly>
            <input type="hidden" name="project_id" value="{{ $report->project_id }}"> {{-- Re-enviar project_id por si acaso, aunque no debería cambiar --}}
        </div>
        
        {{-- Iframe de Donación del Proyecto Padre (informativo) --}}
        @if($report->project->getTranslation('donation_iframe', app()->getLocale(), false))
        <div class="mb-4">
            <label class="form-label">Donation Iframe (from Project {{ $report->project->getTranslation('title', app()->getLocale(), true) }}):</label>
            <div class="p-3 border bg-light">
                {!! $report->project->getTranslation('donation_iframe', app()->getLocale(), false) !!}
            </div>
            <small class="form-text text-muted">This iframe is inherited from the parent project and is not editable here.</small>
        </div>
        @endif


        <ul class="nav nav-tabs" id="languageTab" role="tablist">
            @foreach(config('app.available_locales', ['en']) as $locale)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                            id="{{ $locale }}-tab-report"
                            data-bs-toggle="tab"
                            data-bs-target="#content-report-{{ $locale }}"
                            type="button"
                            role="tab">
                        {{ strtoupper($locale) }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="languageTabContentReport">
            @foreach(config('app.available_locales', ['en']) as $locale)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-report-{{ $locale }}" role="tabpanel" aria-labelledby="{{ $locale }}-tab-report">
                    {{-- Título (Traducible) --}}
                    <div class="mb-3">
                        <label for="title_{{ $locale }}" class="form-label">Title ({{ strtoupper($locale) }})*</label>
                        <input type="text" class="form-control @error('title.'.$locale) is-invalid @enderror" id="title_{{ $locale }}" name="title[{{ $locale }}]" value="{{ old('title.'.$locale, $report->getTranslation('title', $locale, false)) }}">
                        @error('title.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Slug (Traducible) --}}
                    <div class="mb-3">
                        <label for="slug_{{ $locale }}" class="form-label">Slug ({{ strtoupper($locale) }})*</label>
                        <input type="text" class="form-control @error('slug.'.$locale) is-invalid @enderror" id="slug_{{ $locale }}" name="slug[{{ $locale }}]" value="{{ old('slug.'.$locale, $report->getTranslation('slug', $locale, false)) }}">
                        @error('slug.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Extracto (Traducible) --}}
                    <div class="mb-3">
                        <label for="excerpt_{{ $locale }}" class="form-label">Excerpt ({{ strtoupper($locale) }})</label>
                        <textarea class="form-control @error('excerpt.'.$locale) is-invalid @enderror" id="excerpt_{{ $locale }}" name="excerpt[{{ $locale }}]">{{ old('excerpt.'.$locale, $report->getTranslation('excerpt', $locale, false)) }}</textarea>
                        @error('excerpt.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- CONTENT (JSON Traducible) --}}
                    <h4>Content ({{ strtoupper($locale) }}):</h4>
                    @php
                        $currentReportContent = $report->getTranslation('content', $locale, false) ?? [];
                        if (is_string($currentReportContent) && json_decode($currentReportContent) !== null) {
                           $currentReportContent = json_decode($currentReportContent, true);
                        } elseif (!is_array($currentReportContent)) {
                           $currentReportContent = []; // Asegurar que sea un array para el bucle
                        }

                        $baseContentStructure = [
                            'main_text_report' => '', 'image_report_detail_1' => null,
                            'secondary_text_report' => '', 'image_report_detail_2' => null,
                        ];

                        // $displayContent = array_merge($baseContentStructure, $currentReportContent);
                        $displayContent = $currentReportContent;
                    @endphp

                    @foreach($displayContent as $key => $value)
                        <div class="mb-3">
                            <label class="form-label">{{ App\Services\ContentKeyMapper::getLabel('report_content', $key, $locale) }}</label>

                            {{-- @if(Str::startsWith($key, 'image_'))
                                <div class="image-upload-container border p-2 rounded">
                                    @if($report->getMedia($key)->isNotEmpty())
                                        <div class="mb-2">
                                            <img src="{{ $report->getFirstMediaUrl($key, 'optimized') }}"
                                                 class="img-thumbnail"
                                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                            <div class="form-check mt-1">
                                                <input type="checkbox"
                                                       name="remove_content_media[{{ $locale }}][{{ $key }}]"
                                                       value="1"
                                                       class="form-check-input" id="remove_content_media_{{ $locale }}_{{ $key }}">
                                                <label class="form-check-label text-danger" for="remove_content_media_{{ $locale }}_{{ $key }}">Delete this image</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file"
                                           name="content_media[{{ $locale }}][{{ $key }}]"
                                           class="form-control form-control-sm @error("content_media.{$locale}.{$key}") is-invalid @enderror">
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
                                        style="{{ $report->getMedia($key)->isNotEmpty() ? '' : 'display: none;' }}">
                                        @if($report->getMedia($key)->isNotEmpty())
                                            <img id="content_image_{{ $locale }}_{{ $key }}_preview" 
                                                src="{{ $report->getFirstMediaUrl($key, 'optimized') }}"
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
                                                    Delete this image
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
                                            class="form-control form-control-sm @error("content_media.{$locale}.{$key}") is-invalid @enderror">
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
                                    
                                    @error("content_media.{$locale}.{$key}") 
                                        <div class="invalid-feedback d-block">{{ $message }}</div> 
                                    @enderror
                                </div>
                            @else
                                <textarea class="form-control @error("content.{$locale}.{$key}") is-invalid @enderror" name="content[{{ $locale }}][{{ $key }}]">{{ old("content.$locale.$key", $value) }}</textarea>
                                @error("content.{$locale}.{$key}") <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @endif
                        </div>
                    @endforeach
                        {{-- TEXT EDITOR --}}

                        <hr class="my-4">
                        <h4 class="mb-3">Contenido Principal del Reporte ({{ strtoupper($locale) }})</h4>
                        <div class="mb-3">
                            <textarea id="tinymce-editor-{{ $locale }}" 
                                      name="text_editor_content[{{ $locale }}]" 
                                      class="form-control" 
                                      rows="15">{{ old("text_editor_content.{$locale}", $report->getTranslation('text_editor_content', $locale, false)) }}</textarea>
                        </div>

                    {{-- Meta & SEO (JSON Traducible) --}}
                    <hr class="my-4">
                    <h4 class="mb-3">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_projects', 'meta_seo', $locale) }} ({{ strtoupper($locale) }}):</h4>
                    
                    @php
                        // Obtener la traducción actual de 'meta' para este idioma, o un array vacío si no existe
                        $currentMeta = $report->getTranslation('meta', $locale, false) ?? []; 
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

                    {{-- <div class="mb-3">
                        <label for="og_image_{{ $locale }}" class="form-label">URL de la Imagen para Open Graph</label>
                        <input type="url" class="form-control" id="og_image_{{ $locale }}" name="meta[{{ $locale }}][og_image]" value="{{ old("meta.{$locale}.og_image", $currentMeta['og_image'] ?? '') }}" placeholder="https://tudominio.com/ruta/a/imagen-og.jpg">
                        <small class="form-text text-muted">Introduce una URL completa. Tamaño recomendado: 1200x630px.</small>
                    </div> --}}
                </div> {{-- Cierre de .tab-pane --}}
            @endforeach
        </div> {{-- Cierre de .tab-content --}}
        <hr>

        <div class="mb-3">
            <label class="form-label">Tags</label>
            <select name="tags[]" class="form-select" multiple size="5">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}"
                        {{ in_array($tag->id, old('tags', $report->tags->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}
                        style="background-color: {{ $tag->color_bg }}; color: {{ $tag->color_text }};">
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <hr>
        {{-- Campos No Traducibles --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Status*</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="draft" {{ old('status', $report->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $report->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ old('status', $report->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="published_at" class="form-label">Publication Date</label>
                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at', $report->published_at ? $report->published_at->format('Y-m-d\TH:i') : '') }}">
                @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Imagen Destacada --}}
        {{-- <div class="mb-3">
            <label for="featured_image_upload" class="form-label">Featured Image</label>
            <input type="file" class="form-control @error('featured_image_upload') is-invalid @enderror" id="featured_image_upload" name="featured_image_upload">
            @error('featured_image_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
            @if($report->hasMedia('featured_image'))
                <div class="mt-2">
                    <img src="{{ $report->getFirstMediaUrl('featured_image', 'thumbnail') }}" alt="Current featured image" class="img-thumbnail" style="max-height: 150px;">
                    <div class="form-check mt-1">
                        <input type="checkbox" class="form-check-input" name="remove_featured_image" value="1" id="remove_featured_image">
                        <label class="form-check-label text-danger" for="remove_featured_image">Delete current featured image</label>
                    </div>
                </div>
            @endif
        </div> --}}
        
        <div class="mb-3">
            <label class="form-label">Featured Image</label>
            
            <div id="featured_image_preview_container" class="mb-2" style="{{ !$report->hasMedia('featured_image') ? 'display: none;' : '' }}">
                <img id="featured_image_preview" src="{{ $report->getFirstMediaUrl('featured_image', 'thumbnail') }}" class="img-thumbnail" style="max-height: 150px;">
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

        {{-- Información de Creador y Editor --}}
        <div class="row mt-3 mb-3">
            <div class="col-md-6">
                <p class="text-muted small">Created by: {{ $report->creator->name ?? 'N/A' }} on {{ $report->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted small">Last edited by: {{ $report->editor->name ?? 'N/A' }} on {{ $report->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <hr>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    @include('admin.media.partials._modal')
@endsection

@push('scripts')
{{-- ======================= INICIO SCRIPT DE TINYMCE (SOLUCIÓN DEFINITIVA) ======================= --}}
<script src="{{ asset('tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const initializeTinyMCE = (selector) => {
        // Obtenemos el ID del reporte desde la URL de la acción del formulario.
        const formAction = document.querySelector('form').getAttribute('action');
        const reportId = formAction.split('/').pop();

        if (!document.querySelector(selector)) {
            console.warn(`TinyMCE selector "${selector}" not found.`);
            return;
        }

        tinymce.init({
            selector: selector,
            plugins: 'code table lists image link media',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | link image media',
            height: 600,
            relative_urls: false,
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',

            // ================== INICIO DE LA CORRECCIÓN ==================
            // Handler reestructurado para devolver una Promise, como espera TinyMCE moderno.
            images_upload_handler: (blobInfo) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', `/admin/reports/${reportId}/upload-image`);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                xhr.onload = () => {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }

                    try {
                        const json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location !== 'string') {
                            reject('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        // La Promise se resuelve con la URL de la imagen
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
            // =================== FIN DE LA CORRECCIÓN ====================
        });
    };

    // ========= INVOCACIÓN DEL EDITOR (Esto ya estaba bien) =========
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
{{-- ======================= FIN SCRIPT DE TINYMCE (SOLUCIÓN DEFINITIVA) ======================= --}}

<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const modalEl = document.getElementById('mediaLibraryModal');
    //     const modalContainer = document.getElementById('modal_media_items_container');
    //     const modalSearchInput = document.getElementById('modal_media_search_input');
    //     let currentInputTargetId, currentPreviewTargetId;
    
    //     const fetchModalMedia = (url = '{{ route("admin.media-library.index") }}') => {
    //         fetch(url, { 
    //             headers: { 'X-Requested-With': 'XMLHttpRequest' } 
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             modalContainer.innerHTML = data.html;
                
    //             // Actualizar breadcrumbs en el modal
    //             updateModalBreadcrumbs(url);
    //         })
    //         .catch(error => console.error('Error fetching media for modal:', error));
    //     };

    //     const updateModalBreadcrumbs = (url) => {
    //         const urlObj = new URL(url);
    //         const currentFolder = urlObj.searchParams.get('folder') || '/';
            
    //         // Actualizar el input de búsqueda para reflejar la carpeta actual
    //         modalSearchInput.placeholder = `Search in ${currentFolder === '/' ? 'Home' : currentFolder}...`;
    //     };

    //     modalEl.addEventListener('show.bs.modal', function (event) {
    //         const button = event.relatedTarget;
    //         currentInputTargetId = button.dataset.inputTarget;
    //         currentPreviewTargetId = button.dataset.previewTarget;
    //         fetchModalMedia();
    //     });
    
    //     modalSearchInput.addEventListener('input', function () {
    //         const url = `{{ route('admin.media-library.index') }}?search=${this.value}`;
    //         fetchModalMedia(url);
    //     });
    
    //     modalContainer.addEventListener('click', function(e) {
    //         // Manejar paginación
    //         if (e.target.closest('.pagination a')) {
    //             e.preventDefault();
    //             fetchModalMedia(e.target.closest('.pagination a').href);
    //         }
            
    //         // Manejar carpetas
    //         const folderLink = e.target.closest('.folder-link');
    //         if (folderLink) {
    //             e.preventDefault();
    //             const folderPath = folderLink.dataset.path;
                
    //             // Actualizar la URL con la nueva carpeta
    //             const url = new URL('{{ route("admin.media-library.index") }}');
    //             url.searchParams.append('folder', folderPath);
                
    //             fetchModalMedia(url);
    //         }
            
    //         // Manejar selección de medios
    //         if (e.target.closest('.media-library-item')) {
    //             // ... código existente para selección de medios ...
    //         }
    //     });
    
    //     document.getElementById('remove_featured_image_btn')?.addEventListener('click', function() {
    //             document.getElementById('featured_image_preview_container').style.display = 'none';
    //             document.getElementById('featured_image_preview').src = '';
    //             document.getElementById('featured_image_from_library').value = '';
    //             document.getElementById('remove_featured_image_input').value = '1';
    //         });

    //         modalSearchInput.addEventListener('input', function () {
    //         const url = new URL('{{ route("admin.media-library.index") }}');
    //         const currentFolder = getCurrentModalFolder();
            
    //         if (this.value) {
    //             url.searchParams.append('search', this.value);
    //         }
            
    //         if (currentFolder && currentFolder !== '/') {
    //             url.searchParams.append('folder', currentFolder);
    //         }
            
    //         fetchModalMedia(url);
    //     });

    //     // Función auxiliar para obtener la carpeta actual del modal
    //     const getCurrentModalFolder = () => {
    //         const currentUrl = new URL(modalContainer.querySelector('.breadcrumb .breadcrumb-item:last-child a')?.href || '');
    //         return currentUrl.searchParams.get('folder') || '/';
    //     };

    //     document.getElementById('modal_go_home')?.addEventListener('click', function() {
    //         const url = new URL('{{ route("admin.media-library.index") }}');
    //         url.searchParams.append('folder', '/');
    //         fetchModalMedia(url);
    //     });
    // });

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
                // Actualizar la carpeta actual del modal
                if (data.currentFolder) {
                    modalCurrentFolder = data.currentFolder;
                }
                // Actualizar placeholder de búsqueda
                modalSearchInput.placeholder = `Search in ${modalCurrentFolder === '/' ? 'Home' : modalCurrentFolder}...`;
            })
            .catch(error => console.error('Error fetching media for modal:', error));
        };

        modalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            currentInputTargetId = button.dataset.inputTarget;
            currentPreviewTargetId = button.dataset.previewTarget;
            modalCurrentFolder = '/'; // Resetear a raíz al abrir el modal
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
            if (e.target.closest('.media-library-item')) {
                const item = e.target.closest('.media-library-item');
                const mediaId = item.dataset.id;
                const thumbnailUrl = item.dataset.thumbnailUrl;
                
                // Obtener el contexto actual (featured image o content image)
                const inputTarget = document.getElementById(currentInputTargetId);
                const previewContainer = document.getElementById(currentPreviewTargetId);
                
                inputTarget.value = mediaId;
                
                // Actualizar la previsualización
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
                    previewImg.src = thumbnailUrl;
                    previewContainer.style.display = 'block';
                }
                
                // Resetear el campo de eliminación si es una imagen de contenido
                if (currentInputTargetId.includes('content_image')) {
                    const parts = currentInputTargetId.split('_');
                    const locale = parts[2];
                    const key = parts[3];
                    document.getElementById(`remove_content_media_${locale}_${key}`).checked = false;
                }
                
                // Cerrar el modal
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
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
    });
</script>
@endpush