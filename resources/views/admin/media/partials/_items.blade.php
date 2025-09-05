{{-- <div class="row">
    @forelse($mediaItems as $media)
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 media-item-card">
        <div class="card h-100">
            <img src="{{ $media->getUrl('thumbnail') }}" class="card-img-top media-library-item" 
                 style="object-fit: cover; height: 150px; cursor: pointer;"
                 data-id="{{ $media->id }}" 
                 data-url="{{ $media->getUrl() }}"
                 data-thumbnail-url="{{ $media->getUrl('thumbnail') }}"
                 alt="{{ $media->name }}">
            <div class="card-body p-2">
                <p class="card-text small text-truncate" title="{{ $media->name }}">{{ $media->name }}</p>
            </div>
            <div class="card-footer p-1 text-center">
                <button class="btn btn-sm btn-danger delete-media-btn" data-id="{{ $media->id }}">Delete</button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <p class="text-center">No media found.</p>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center">
    {{ $mediaItems->links() }}
</div> --}}

{{-- Breadcrumbs de Navegación --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        @php $pathParts = explode('/', trim($currentFolder, '/')); $cumulativePath = ''; @endphp
        <li class="breadcrumb-item"><a href="#" class="folder-link" data-path="/">Home</a></li>
        @foreach($pathParts as $part)
            @if(!empty($part))
                @php $cumulativePath .= '/' . $part; @endphp
                <li class="breadcrumb-item"><a href="#" class="folder-link" data-path="{{ $cumulativePath . '/' }}">{{ $part }}</a></li>
            @endif
        @endforeach
        {{-- <li class="breadcrumb-item active" aria-current="page">Current</li> --}}
    </ol>
</nav>

<div class="row">
    {{-- Renderizar Carpetas --}}
    @foreach($subfolders as $folderName)
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="card h-100 text-center folder-link" style="cursor: pointer;" data-path="{{ rtrim($currentFolder, '/') }}/{{ $folderName }}/">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <i class="fas fa-folder fa-3x mb-2 text-warning"></i>
                <p class="card-text text-truncate" title="{{ $folderName }}">{{ $folderName }}</p>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Renderizar Archivos --}}
    @forelse($mediaItems as $media)
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 media-item-card">
        <div class="card h-100">
            <img src="{{ $media->getUrl('thumbnail') }}" 
                class="card-img-top media-library-item" 
                style="object-fit: cover; height: 150px; cursor: pointer;"
                data-id="{{ $media->id }}" 
                data-url="{{ $media->getUrl() }}"
                data-thumbnail-url="{{ $media->getUrl('thumbnail') }}"
                alt="{{ $media->alt_text }}">
            
            <div class="card-body p-2">
                @php
                    // Obtener nombre y extensión por separado

                    // $fileInfo = pathinfo($media->name);
                    // $fileName = $fileInfo['filename'];
                    // $fileExtension = $fileInfo['extension'] ?? '';

                    $fileName = pathinfo($media->name, PATHINFO_FILENAME);
                    $fileExtension = $media->extension; // Usar el atributo extension de Spatie
                @endphp
                
                {{-- <p class="card-text small text-truncate mb-0" title="{{ $media->name }}">
                    {{ $fileName }}
                </p>
                <p class="card-text small text-muted mb-1">
                    .{{ strtoupper($fileExtension) }}
                </p> --}}

                <p class="card-text small text-truncate mb-0 d-inline" title="{{ $media->name }}">
                    {{ $fileName }}
                </p>
                <p class="card-text small text-muted mb-1 d-inline">
                    {{-- .{{ strtoupper($fileExtension) }} --}}
                    .{{ strtolower(strtoupper($fileExtension)) }}
                </p>
                
                {{-- Campo de texto alternativo (ahora input) --}}
                <div class="alt-text-editor" data-id="{{ $media->id }}">
                    <input type="text" 
                        class="form-control form-control-sm alt-text-input mb-1" 
                        value="{{ $media->alt_text }}" 
                        placeholder="Alt text" 
                        maxlength="255">
                    <button class="btn btn-sm btn-outline-success save-alt-text w-100">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </div>
            
            <div class="card-footer p-1 d-flex justify-content-around">
                <a href="{{ route('admin.media-library.download', $media) }}" 
                class="btn btn-sm btn-outline-secondary" title="Download">
                    <i class="fas fa-download"></i>
                </a>
                
                {{-- Botón de eliminar --}}
                <button class="btn btn-sm btn-outline-danger delete-media-btn" 
                        data-id="{{ $media->id }}" 
                        title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
        @if($subfolders->isEmpty())
            <div class="col-12"><p class="text-center">This folder is empty.</p></div>
        @endif
    @endforelse
</div>

<div class="d-flex justify-content-center">
    {{ $mediaItems->appends(request()->query())->links() }}
</div>

@push('scripts')
<script>
// Guardar texto alternativo
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.save-alt-text').forEach(button => {
        button.addEventListener('click', function() {
            const container = this.closest('.alt-text-editor');
            const mediaId = container.dataset.id;
            const altText = container.querySelector('.alt-text-input').value;
            
            // Enviar petición AJAX
            fetch(`/admin/media-library/${mediaId}/update-alt-text`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ alt_text: altText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar feedback visual
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i> Saved!';
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 2000);
                }
            });
        });
    });
});
</script>
@endpush