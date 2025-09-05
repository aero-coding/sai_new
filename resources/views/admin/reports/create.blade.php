@extends('layouts.admin_app')

@section('content')
    <h1>Create New Report</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.reports.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Selección de Proyecto Padre --}}
        <div class="mb-3">
            <label for="project_id" class="form-label">Parent Project*</label>
            @if(isset($fixedProject))
                <input type="hidden" name="project_id" value="{{ $fixedProject->id }}">
                <input type="text" class="form-control" value="{{ $fixedProject->getTranslation('title', app()->getLocale(), true) }}" readonly>
                 <small class="form-text text-muted">Report for project: {{ $fixedProject->getTranslation('title', app()->getLocale(), true) }}</small>
            @else
                <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id" required>
                    <option value="">Select a project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $selectedProjectId ?? '') == $project->id ? 'selected' : '' }}>
                            {{ $project->getTranslation('title', app()->getLocale(), true) }}
                        </option>
                    @endforeach
                </select>
                @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            @endif
        </div>


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
                        <input type="text" class="form-control @error('title.'.$locale) is-invalid @enderror" id="title_{{ $locale }}" name="title[{{ $locale }}]" value="{{ old('title.'.$locale) }}">
                        @error('title.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Slug (Traducible) --}}
                    <div class="mb-3">
                        <label for="slug_{{ $locale }}" class="form-label">Slug ({{ strtoupper($locale) }})*</label>
                        <input type="text" class="form-control @error('slug.'.$locale) is-invalid @enderror" id="slug_{{ $locale }}" name="slug[{{ $locale }}]" value="{{ old('slug.'.$locale) }}">
                        @error('slug.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Extracto (Traducible) --}}
                    <div class="mb-3">
                        <label for="excerpt_{{ $locale }}" class="form-label">Excerpt ({{ strtoupper($locale) }})</label>
                        <textarea class="form-control @error('excerpt.'.$locale) is-invalid @enderror" id="excerpt_{{ $locale }}" name="excerpt[{{ $locale }}]">{{ old('excerpt.'.$locale) }}</textarea>
                        @error('excerpt.'.$locale) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- CONTENT (JSON Traducible) --}}
                    {{-- Para 'create', el JSON content estará vacío inicialmente.
                         Necesitas una forma de definir qué claves tendrá.
                         Opción 1: Campos fijos predefinidos (ejemplo abajo).
                         Opción 2: JavaScript para añadir campos dinámicamente.
                         Por ahora, vamos con campos fijos como ejemplo, asumiendo una estructura.
                    --}}
                    <h4>Content ({{ strtoupper($locale) }}):</h4>
                    @php
                        // Estructura de ejemplo para el contenido de un nuevo reporte
                        // Ajusta estas claves según la estructura que necesites para Reportes
                        $reportContentStructure = [
                            'main_text_report' => '',
                            'image_report_detail_1' => null, // Para el slot de imagen
                            'secondary_text_report' => '',
                            'image_report_detail_2' => null,
                        ];
                    @endphp

                    @foreach($reportContentStructure as $key => $defaultValue)
                        <div class="mb-3">
                            <label class="form-label">{{ Str::title(str_replace('_', ' ', $key)) }}</label>

                            @if(Str::startsWith($key, 'image_'))
                                <div class="image-upload-container border p-2 rounded">
                                    <input type="file"
                                           name="content_media[{{ $locale }}][{{ $key }}]"
                                           class="form-control form-control-sm @error("content_media.{$locale}.{$key}") is-invalid @enderror">
                                    @error("content_media.{$locale}.{$key}") <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            @else
                                <textarea class="form-control @error("content.{$locale}.{$key}") is-invalid @enderror"
                                          name="content[{{ $locale }}][{{ $key }}]">{{ old("content.$locale.$key", $defaultValue) }}</textarea>
                                @error("content.{$locale}.{$key}") <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @endif
                        </div>
                    @endforeach
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
                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="published_at" class="form-label">Publication Date</label>
                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Imagen Destacada --}}
        <div class="mb-3">
            <label for="featured_image_upload" class="form-label">Featured Image</label>
            <input type="file" class="form-control @error('featured_image_upload') is-invalid @enderror" id="featured_image_upload" name="featured_image_upload">
            @error('featured_image_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <hr>
        <button type="submit" class="btn btn-success">Create Report</button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection