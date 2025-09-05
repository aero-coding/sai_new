{{-- <!-- En _modal.blade.php -->
<div class="modal fade" id="mediaLibraryModal" tabindex="-1" aria-labelledby="mediaLibraryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaLibraryModalLabel">Select from Media Library</h5>
                <div class="d-flex flex-grow-1 ms-4">
                    <div class="input-group">
                        <input type="search" id="modal_media_search_input" class="form-control" placeholder="Search...">
                        <button class="btn btn-outline-secondary" type="button" id="modal_go_home">
                            <i class="fas fa-home"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal_media_items_container">
                <!-- El contenido se cargará aquí dinámicamente -->
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade" id="mediaLibraryModal" tabindex="-1" aria-labelledby="mediaLibraryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaLibraryModalLabel">Select from Media Library</h5>
                <div class="d-flex flex-grow-1 ms-4">
                    <div class="input-group">
                        <input type="search" id="modal_media_search_input" class="form-control" placeholder="Search...">
                        <button class="btn btn-outline-secondary" type="button" id="modal_go_home">
                            <i class="fas fa-home"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal_media_items_container">
                <!-- El contenido se cargará aquí dinámicamente -->
            </div>
            <!-- Nuevo footer para selección múltiple -->
            <div class="modal-footer">
                <div id="current-selection-container" class="d-flex flex-wrap gap-2 mb-3" style="display: none !important;">
                    <!-- Aquí se mostrarán las miniaturas seleccionadas -->
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="modal-confirm-selection">Confirm Selection</button>
            </div>
        </div>
    </div>
</div>
{{-- 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... código existente ...
        
        const modalEl = document.getElementById('mediaLibraryModal');
        
        modalEl.addEventListener('show.bs.modal', function(event) {
            // ... código existente ...
        });
        
        modalContainer.addEventListener('click', function(e) {
            // ... código existente ...
            
            const mediaItem = e.target.closest('.media-library-item');
            if (mediaItem) {
                const mediaId = mediaItem.dataset.id;
                const altText = mediaItem.alt;  // Obtener el texto alternativo
                
                // ... código existente ...
                
                if (currentSelectionMode === 'multiple') {
                    // ... código existente ...
                } else {
                    // ... código existente ...
                    
                    // Actualizar el alt text en la imagen de vista previa
                    if (previewImg) {
                        previewImg.alt = altText;
                    }
                }
            }
        });
    });
</script> --}}