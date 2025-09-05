@extends('layouts.admin_app')

@section('title', 'Media Library')

@section('content')
<div class="container-fluid">
    {{-- <h1 class="mb-4">Media Library</h1> --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Media Library</h1>
        <div>
            {{-- Botón para crear nueva carpeta --}}
            <button id="create-folder-btn" class="btn btn-secondary">Create Folder</button>
        </div>
    </div>

    {{-- <div class="card mb-4">
        <div class="card-header">Upload New Images</div>
        <div class="card-body">
            <form id="media-upload-form" action="{{ route('admin.media-library.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" name="files[]" class="form-control" multiple required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div> --}}
    <div class="card mb-4">
        <div class="card-header">Upload New Images</div>
        <div class="card-body">
            <form id="media-upload-form" action="{{ route('admin.media-library.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" name="files[]" class="form-control" multiple required>
                </div>
                
                {{-- Contenedor para campos de texto alternativo --}}
                <div id="alt-text-container" class="mb-3"></div>
                
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Search Media</div>
        <div class="card-body">
             <input type="search" id="media-search-input" class="form-control" placeholder="Search by name...">
        </div>
    </div>

    <div id="media-items-container">
        @include('admin.media.partials._items', ['mediaItems' => $mediaItems])
    </div>
</div>
@endsection

@push('styles')
<style>
    .media-item-card .card-body {
        max-height: 200px;
        overflow: hidden;
    }
    
    .alt-text-input {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
    
    .save-alt-text {
        padding: 0.15rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endpush

{{-- 
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('media-items-container');
    const searchInput = document.getElementById('media-search-input');
    const uploadForm = document.getElementById('media-upload-form');

    // Función para buscar y paginar
    const fetchMedia = (url = '{{ route("admin.media-library.index") }}') => {
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.json())
            .then(data => container.innerHTML = data.html)
            .catch(error => console.error('Error fetching media:', error));
    };

    // Buscador
    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const url = `{{ route('admin.media-library.index') }}?search=${this.value}`;
            fetchMedia(url);
        }, 300);
    });

    // Paginación
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            fetchMedia(e.target.closest('.pagination a').href);
        }
    });

    // Subida de archivos
    uploadForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.reset();
                fetchMedia(); // Recargar la galería
            }
        })
        .catch(error => console.error('Error uploading:', error));
    });

    // Borrado de archivos
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.delete-media-btn')) {
            e.preventDefault();
            if (!confirm('Are you sure you want to delete this image?')) return;
            
            const button = e.target.closest('.delete-media-btn');
            const url = `{{ url('admin/media-library') }}/${button.dataset.id}`;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    button.closest('.media-item-card').remove();
                }
            })
            .catch(error => console.error('Error deleting media:', error));
        }
    });
});
</script>
@endpush --}}

@push('scripts')
<script>
    
document.addEventListener('DOMContentLoaded', function () {


    // SECCIÓN NUEVA -----------------------------------------------------------------------------

    const fileInput = document.querySelector('input[name="files[]"]');
    const altTextContainer = document.getElementById('alt-text-container');

    // Generar campos de texto alternativo cuando se seleccionen archivos
    // fileInput.addEventListener('change', function() {
    //     altTextContainer.innerHTML = ''; // Limpiar contenedor
        
    //     // Crear un campo por cada archivo seleccionado
    //     for (let i = 0; i < this.files.length; i++) {
    //         const fileName = this.files[i].name;
    //         const baseName = fileName.split('.')[0]; // Obtener nombre sin extensión
            
    //         altTextContainer.innerHTML += `
    //             <div class="mb-2">
    //                 <label class="form-label">Alt text for ${fileName}</label>
    //                 <input type="text" 
    //                     name="alt_text[]" 
    //                     class="form-control" 
    //                     value="${baseName.replace(/[-_]/g, ' ')}"
    //                     placeholder="Describe this image for accessibility">
    //             </div>
    //         `;
    //     }
    // });

    fileInput.addEventListener('change', function() {
        altTextContainer.innerHTML = '';
        
        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            const fileName = file.name;
            const baseName = fileName.split('.')[0];
            
            altTextContainer.innerHTML += `
                <div class="mb-2 border p-2 rounded">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-file-image me-2"></i>
                        <span class="small text-truncate">${fileName}</span>
                    </div>
                    <input type="text" 
                           name="alt_text[]" 
                           class="form-control form-control-sm" 
                           value="${baseName.replace(/[-_]/g, ' ')}"
                           placeholder="Describe this image">
                </div>
            `;
        }
    });

    // SECCIÓN NUEVA -----------------------------------------------------------------------------

    const container = document.getElementById('media-items-container');
    const searchInput = document.getElementById('media-search-input');
    const uploadForm = document.getElementById('media-upload-form');
    const createFolderBtn = document.getElementById('create-folder-btn');
    
    // Variable para mantener el estado de la carpeta actual
    let currentFolderPath = '/';

    // Función principal para cargar contenido
    const fetchMedia = (path = '/', searchQuery = '') => {
        currentFolderPath = path;
        const url = new URL('{{ route("admin.media-library.index") }}');
        url.searchParams.append('folder', path);
        if (searchQuery) {
            url.searchParams.append('search', searchQuery);
        }
        
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.json())
            .then(data => container.innerHTML = data.html)
            .catch(error => console.error('Error fetching media:', error));
    };

    // Búsqueda
    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchMedia(currentFolderPath, this.value);
        }, 300);
    });

    // Subida de archivos
    // uploadForm.addEventListener('submit', function (e) {
    //     e.preventDefault();
    //     const formData = new FormData(this);
    //     // Añadir la carpeta actual al formulario de subida
    //     formData.append('folder_path', currentFolderPath);

    //     fetch(this.action, {
    //         method: 'POST',
    //         body: formData,
    //         headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             this.reset();
    //             fetchMedia(currentFolderPath); // Recargar la carpeta actual
    //         }
    //     });
    // });

    uploadForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('folder_path', currentFolderPath);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.reset();
                altTextContainer.innerHTML = ''; // Limpiar campos de alt text
                fetchMedia(currentFolderPath);
            }
        });
    });

    // Crear Carpeta
    createFolderBtn.addEventListener('click', function() {
        const folderName = prompt('Enter a name for the new folder:');
        if (folderName && folderName.trim() !== '') {
            // La "creación" es virtual. Simplemente navegamos a una ruta que aún no existe.
            // Al subir el primer archivo a esta ruta, la carpeta "aparecerá".
            const newPath = `${currentFolderPath}${folderName}/`.replace('//', '/');
            fetchMedia(newPath);
        }
    });

    // Navegación (Paginación y Clic en Carpetas/Breadcrumbs)
    document.body.addEventListener('click', function (e) {
        const folderLink = e.target.closest('.folder-link');
        const paginationLink = e.target.closest('.pagination a');

        if (folderLink) {
            e.preventDefault();
            fetchMedia(folderLink.dataset.path);
        } else if (paginationLink) {
            e.preventDefault();
            // La URL de paginación ya contiene los parámetros correctos
            const url = new URL(paginationLink.href);
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.json())
                .then(data => container.innerHTML = data.html);
        }
    });

    // Borrado de archivos (no necesita cambios)
    // document.body.addEventListener('click', function(e) {
    //     // Buscamos si el clic fue en un botón de borrar o en un icono dentro del botón
    //     const deleteButton = e.target.closest('.delete-media-btn');
    //     if (deleteButton) {
    //         e.preventDefault();
            
    //         if (!confirm('Are you sure you want to delete this image permanently?')) {
    //             return;
    //         }
            
    //         const mediaId = deleteButton.dataset.id;
    //         const url = `/admin/media-library/${mediaId}`; // URL directa, no necesita la función route() de Blade

    //         fetch(url, {
    //             method: 'DELETE',
    //             headers: {
    //                 'X-Requested-With': 'XMLHttpRequest',
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    //             }
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if(data.success) {
    //                 // Si se borra con éxito, elimina la tarjeta de la vista
    //                 deleteButton.closest('.media-item-card').remove();
    //             } else {
    //                 // ¡CAMBIO IMPORTANTE! Muestra el mensaje específico que viene del servidor.
    //                 alert(data.message || 'An unspecified error occurred.'); 
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error deleting media:', error);
    //             alert(error.message);
    //         });
    //     }
    // });

    document.body.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('.delete-media-btn');
        
        if (deleteButton) {
            e.preventDefault();
            
            if (!confirm('¿Seguro que quieres eliminar esta imagen?')) return;
            
            const mediaId = deleteButton.dataset.id;
            const url = `/admin/media-library/${mediaId}`;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    // Recargar todo el componente de medios
                    fetchMedia(currentFolderPath);
                } else {
                    alert('Error: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting media: ' + error.message);
            });
        }
    });

    document.body.addEventListener('click', function(e) {
        const saveButton = e.target.closest('.save-alt-text');
        
        if (saveButton) {
            e.preventDefault();
            const container = saveButton.closest('.alt-text-editor');
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
                    const originalHTML = saveButton.innerHTML;
                    saveButton.innerHTML = '<i class="fas fa-check"></i> Saved!';
                    
                    setTimeout(() => {
                        saveButton.innerHTML = originalHTML;
                    }, 2000);
                }
            })
            .catch(error => console.error('Error updating alt text:', error));
        }
    });
});

</script>
@endpush