@extends('layouts.admin_app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Create New Tag</h1>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Tags
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name_en" class="form-label">Name (English)</label>
                        <input type="text" class="form-control" id="name_en" name="name[en]" 
                               value="{{ old('name.en') }}" required>
                        @error('name.en')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="name_es" class="form-label">Name (Spanish)</label>
                        <input type="text" class="form-control" id="name_es" name="name[es]" 
                               value="{{ old('name.es') }}" required>
                        @error('name.es')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="color_bg" class="form-label">Background Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color p-1" id="color_bg" 
                                   name="color_bg" value="{{ old('color_bg', '#D94647') }}" required>
                            <input type="text" class="form-control" value="{{ old('color_bg', '#D94647') }}" 
                                   id="color_bg_text" readonly style="max-width: 120px;">
                        </div>
                        @error('color_bg')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="color_text" class="form-label">Text Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color p-1" id="color_text" 
                                   name="color_text" value="{{ old('color_text', '#FFFFFF') }}" required>
                            <input type="text" class="form-control" value="{{ old('color_text', '#FFFFFF') }}" 
                                   id="color_text_text" readonly style="max-width: 120px;">
                        </div>
                        @error('color_text')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" 
                           value="{{ old('slug') }}" required>
                    <div class="form-text">Unique identifier for URLs (lowercase, hyphens, no spaces)</div>
                    @error('slug')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary me-md-2">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Tag
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Actualizar campos de texto con el valor del color
    document.getElementById('color_bg').addEventListener('input', function() {
        document.getElementById('color_bg_text').value = this.value;
    });
    
    document.getElementById('color_text').addEventListener('input', function() {
        document.getElementById('color_text_text').value = this.value;
    });
    
    // Generar slug automático desde el nombre en inglés
    document.getElementById('name_en').addEventListener('blur', function() {
        if (!document.getElementById('slug').value) {
            const slug = this.value
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^a-z0-9-]/g, '');
            document.getElementById('slug').value = slug;
        }
    });
</script>
@endpush
@endsection