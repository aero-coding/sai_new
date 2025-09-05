@extends('layouts.admin_app')

@section('content')

    @php
        $pageType = $page->page_type;
    @endphp

    <h1>Edit Page: {{ $page->getTranslation('title', config('app.fallback_locale', 'en')) }}</h1>

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

    {{-- <form method="POST" action="{{ route('admin.pages.update', $page->id) }}" enctype="multipart/form-data"> --}}
    {{-- <form method="POST" action="{{ route('admin.pages.update', ['page' => $page->id]) }}" enctype="multipart/form-data"> --}}
    <form method="POST" action="{{ route('admin.pages.update', $page->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <ul class="nav nav-tabs" id="languageTab" role="tablist">
            @foreach(config('app.available_locales', ['en']) as $locale)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                            id="{{ $locale }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#content-{{ $locale }}" 
                            type="button" 
                            role="tab">
                        {{ strtoupper($locale) }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="languageTabContent">
            @foreach(config('app.available_locales', ['en']) as $locale)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $locale }}" role="tabpanel">
                    {{-- Título (Traducible) --}}
                    <div class="mb-3">
                        <label for="title_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'title', $locale) }} ({{ strtoupper($locale) }})</label>
                        <input type="text" class="form-control" id="title_{{ $locale }}" name="title[{{ $locale }}]" value="{{ old('title.'.$locale, $page->getTranslation('title', $locale, false)) }}">
                    </div>

                    {{-- Slug (Traducible) - Podrías querer generarlo automáticamente o hacerlo editable con cuidado --}}
                    <div class="mb-3">
                        <label for="slug_{{ $locale }}" class="form-label">Slug ({{ strtoupper($locale) }})</label>
                        <input type="text" class="form-control" id="slug_{{ $locale }}" name="slug[{{ $locale }}]" value="{{ old('slug.'.$locale, $page->getTranslation('slug', $locale, false)) }}">
                    </div>

                    {{-- Extracto (Traducible) --}}
                    <div class="mb-3">
                        <label for="excerpt_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'excerpt', $locale) }} ({{ strtoupper($locale) }})</label>
                        <textarea class="form-control" id="excerpt_{{ $locale }}" name="excerpt[{{ $locale }}]">{{ old('excerpt.'.$locale, $page->getTranslation('excerpt', $locale, false)) }}</textarea>
                    </div>

                    {{-- Iframes (Traducibles) - Campos de texto para el HTML del iframe --}}
                    <div class="mb-3">
                        <label for="donation_iframe_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'donations_iframe', $locale) }} ({{ strtoupper($locale) }})</label>
                        <textarea class="form-control" name="donation_iframe[{{ $locale }}]">{{ old('donation_iframe.'.$locale, $page->getTranslation('donation_iframe', $locale, false)) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="video_iframe_{{ $locale }}" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'video_iframe', $locale) }} ({{ strtoupper($locale) }})</label>
                        <textarea class="form-control" name="video_iframe[{{ $locale }}]">{{ old('video_iframe.'.$locale, $page->getTranslation('video_iframe', $locale, false)) }}</textarea>
                    </div>

                    {{-- CONTENT --}}

                    <h4>{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'content', $locale) }} ({{ strtoupper($locale) }}):</h4>

                    @foreach($page->getTranslation('content', $locale, false) ?? [] as $key => $value)
                        <div class="mb-3">
                            {{-- <label class="form-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label> --}}
                            <label class="form-label">{{ App\Services\ContentKeyMapper::getLabel($pageType, $key, $locale) }}</label>

                            @if(Str::startsWith($key, 'image_'))
    <div class="image-upload-container border p-2 rounded">
        <div id="content_image_{{ $locale }}_{{ $key }}_preview_container" class="mb-2" 
            style="{{ $page->getMedia($key)->isNotEmpty() ? '' : 'display: none;' }}">
            @if($page->getMedia($key)->isNotEmpty())
                <img id="content_image_{{ $locale }}_{{ $key }}_preview" 
                    src="{{ $page->getFirstMediaUrl($key, 'optimized') }}"
                    class="img-thumbnail"
                    style="max-width: 200px; max-height: 200px; object-fit: cover;">
            @endif
            <div class="d-flex justify-content-between mt-2">
                <div class="form-check">
                    <input type="checkbox"
                        name="remove_media[{{ $locale }}][{{ $key }}]"
                        value="1"
                        class="form-check-input" 
                        id="remove_content_media_{{ $locale }}_{{ $key }}">
                    <label class="form-check-label text-danger" 
                        for="remove_content_media_{{ $locale }}_{{ $key }}">
                        {{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'delete_image', $locale) }}
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
                class="form-control">
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
@endif
                        </div>
                    @endforeach


                    {{-- Aquí podrías tener un editor JSON más genérico si la estructura varía mucho y no es predefinida --}}


                    {{-- Meta Tags (meta - JSON Traducible) --}}
                    <h4>SEO Meta Tags ({{ strtoupper($locale) }}):</h4>
                    @php
                        // Obtener la traducción actual de 'meta' para este idioma, o un array vacío si no existe
                        $currentMeta = $page->getTranslation('meta', $locale, false) ?? []; 
                    @endphp

                    <div class="mb-3">
                        <label for="meta_title_{{ $locale }}" class="form-label">SEO Title</label>
                        <textarea class="form-control" id="meta_description_{{ $locale }}" name="meta[{{ $locale }}][seo_description]" rows="3" maxlength="160">{{ old("meta.{$locale}.seo_description", $currentMeta['seo_description'] ?? '') }}</textarea>
                        <small class="form-text text-muted">Max 70 characters. Optimal for search engines.</small>
                    </div>

                    <div class="mb-3">
                        <label for="meta_description_{{ $locale }}" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description_{{ $locale }}" name="meta[{{ $locale }}][seo_description]" rows="3" maxlength="160">{{ old("meta.{$locale}.seo_description", $currentMeta['seo_description'] ?? '') }}</textarea>
                        <small class="form-text text-muted">Max 160 characters. Appealing description for search results.</small>
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords_{{ $locale }}" class="form-label">Meta Keywords (Optional)</label>
                        <input type="text" class="form-control" id="meta_keywords_{{ $locale }}" name="meta[{{ $locale }}][keywords]" value="{{ old("meta.{$locale}.keywords", $currentMeta['keywords'] ?? '') }}">
                        <small class="form-text text-muted">Comma-separated keywords.</small>
                    </div>

                    <hr class="my-3">
                    <h5>Open Graph & Twitter Card Settings ({{ strtoupper($locale) }})</h5>
                    <small class="form-text text-muted mb-2 d-block">If left blank, these will often default to the SEO Title/Description and Featured Image.</small>

                    <div class="mb-3">
                        <label for="og_title_{{ $locale }}" class="form-label">Open Graph Title</label>
                        <input type="text" class="form-control" id="og_title_{{ $locale }}" name="meta[{{ $locale }}][og_title]" value="{{ old("meta.{$locale}.og_title", $currentMeta['og_title'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="og_description_{{ $locale }}" class="form-label">Open Graph Description</label>
                        <textarea class="form-control" id="og_description_{{ $locale }}" name="meta[{{ $locale }}][og_description]" rows="2">{{ old("meta.{$locale}.og_description", $currentMeta['og_description'] ?? '') }}</textarea>
                    </div>

                    {{-- TODO URL --}}
                    {{-- <div class="mb-3">
                        <label for="og_image_{{ $locale }}" class="form-label">Open Graph Image URL</label>
                        <input type="url" class="form-control" id="og_image_{{ $locale }}" name="meta[{{ $locale }}][og_image]" value="{{ old("meta.{$locale}.og_image", $currentMeta['og_image'] ?? '') }}" placeholder="https://yourdomain.com/path/to/og-image.jpg">
                        <small class="form-text text-muted">Provide a full URL. Recommended size: 1200x630px.</small>
                    </div> --}}
                </div> {{-- Cierre de .tab-pane --}}
            @endforeach
        </div> {{-- Cierre de .tab-content --}}

        <hr>
        {{-- Campos No Traducibles --}}
        <div class="mb-3">
            <label for="status" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'status', $locale) }}</label>
            <select class="form-select" id="status" name="status">
                <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Borrador (Draft)</option>
                <option value="active" {{ old('status', $page->status) === 'active' ? 'selected' : '' }}>Activa (Active)</option>
                <option value="inactive" {{ old('status', $page->status) === 'inactive' ? 'selected' : '' }}>Inactiva (Inactive)</option>
            </select>
        </div>

        {{-- Imagen Destacada (Spatie Media Library) --}}
        {{-- <div class="mb-3">
            <label for="featured_image_upload" class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'featured_image', $locale) }}</label>
            <input type="file" class="form-control" id="featured_image_upload" name="featured_image_upload">
            @if($page->hasMedia('featured_image'))
                <div class="mt-2">
                    <img src="{{ $page->getFirstMediaUrl('featured_image') }}" alt="Imagen destacada actual" style="max-height: 100px;">
                    <label><input type="checkbox" name="remove_featured_image" value="1"> {{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'delete_image', $locale) }}</label>
                </div>
            @endif
        </div> --}}
        <div class="mb-3">
            <label class="form-label">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'featured_image', $locale) }}</label>
            
            <div id="featured_image_preview_container" class="mb-2" style="{{ !$page->hasMedia('featured_image') ? 'display: none;' : '' }}">
                <img id="featured_image_preview" src="{{ $page->getFirstMediaUrl('featured_image', 'thumbnail') }}" class="img-thumbnail" style="max-height: 150px;">
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
        <button type="submit" class="btn btn-success">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'save_changes', $locale) }}</button>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">{{ App\Services\ContentKeyMapper::getLabel('edit_texts_pages', 'discard_changes', $locale) }}</a>
    </form>

    @include('admin.media.partials._modal')
@endsection

@push('scripts')
<script>
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