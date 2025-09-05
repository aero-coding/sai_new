@php
    $currentLocale = app()->getLocale();
    $content = $page->getTranslation('content', $currentLocale, useFallbackLocale: true) ?? [];
@endphp

@extends('layouts.app')

@section('title', 'Explore')

@section('content')
<section class="explore-fundarisings section row justify-content-center py-4"> 
    <div class="col-12 col-md-9">
        <div class="search-banner-container p-4 p-md-5"> 
            <div class="row align-items-center gy-3"> 
                <div class="col-md-6 text-content text-center text-md-start"> 
                    <h1 class="text-uppercase sub-heading mb-1">{{ $content['h1_title'] ?? '' }}</h1>
                    <h2 class="text-uppercase main-heading mb-0">{{ $content['search_title'] ?? '' }}</h2>
                </div>
                <div class="col-md-6 search-content">
                    <form class="search-form" onsubmit="return false;">
                        <div class="input-group search-input-group">
                            <input type="search" id="project-search-input" class="form-control search-input d-none d-md-block" placeholder="{{ $content['search_placeholder'] ?? '' }}" aria-label="Search Campaign or keywords">
                            <input type="search" id="project-search-input-mobile" class="form-control search-input d-md-none" placeholder="{{ $content['search_placeholder'] ?? '' }}" aria-label="Search Campaign">

                            <button class="btn search-button" type="submit" aria-label="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <p class="search-helper-text d-md-none mt-2 mb-0">
                            Search campaigns, keywords Or category
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="results section row justify-content-center">
            <div id="projects-container" class="col-12 col-md-9 d-flex justify-content-start gap-4 cards-container">
                    {{-- <div class="help-cards">
                    <div class="card-top">
                        <img src="{{asset('example.jpg')}}" alt=""> 
                        <div class="card-title-position">
                            <h4>SAI Medical Clinic for Children</h4>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-bottom-container">
                            <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Et dolore error labore maiores nulla quos quisquam neque! Est similique.
                        </p>
                        <a href="" class="white-btn">
                            <span>DONATE ></span>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="help-cards">
                    <div class="card-top">
                        <img src="{{asset('example.jpg')}}" alt="">
                        <div class="card-title-position">
                            <h4>SAI Medical Clinic for Children</h4>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-bottom-container">
                            <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Et dolore error labore maiores nulla quos quisquam neque! Est similique.
                        </p>
                        <a href="" class="white-btn">
                            <span>DONATE ></span>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="help-cards">
                    <div class="card-top">
                        <img src="{{asset('example.jpg')}}" alt="">
                        <div class="card-title-position">
                            <h4>SAI Medical Clinic for Children</h4>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-bottom-container">
                            <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Et dolore error labore maiores nulla quos quisquam neque! Est similique.
                        </p>
                        <a href="" class="white-btn">DONATE ></a>
                        </div>
                    </div>
                </div>
                <div class="help-cards">
                    <div class="card-top">
                        <img src="{{asset('example.jpg')}}" alt="">
                        <div class="card-title-position">
                            <h4>SAI Medical Clinic for Children</h4>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-bottom-container">
                            <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Et dolore error labore maiores nulla quos quisquam neque! Est similique.
                        </p>
                        <a href="" class="white-btn">
                            <span>DONATE ></span>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="help-cards">
                    <div class="card-top">
                        <img src="{{asset('example.jpg')}}" alt="">
                        <div class="card-title-position">
                            <h4>SAI Medical Clinic for Children</h4>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-bottom-container">
                            <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Et dolore error labore maiores nulla quos quisquam neque! Est similique.
                        </p>
                        <a href="" class="white-btn">
                            <span>DONATE ></span>
                        </a>
                        </div>
                    </div>
                </div> --}}
                {{-- CARGA INICIAL (SSR) DE 3 PROYECTOS --}}
                    @forelse($initialProjects as $project)
                    <div class="help-cards project-card">
                        <div class="card-top">
                            <a href="{{ route('projects.show.localized', ['locale' => $locale, 'project_slug' => $project->getTranslation('slug', $locale, true)]) }}">
                                @if($project->hasMedia('featured_image'))
                                    <img src="{{ $project->getFirstMediaUrl('featured_image', 'optimized') }}" 
                                        alt="{{ $project->getTranslation('title', $locale, true) }}">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" alt="Default project image">
                                @endif
                            </a>
                            <div class="card-title-position">
                                <h4>{{ $project->getTranslation('title', $locale, true) }}</h4>
                            </div>
                        </div>
                        <div class="card-bottom">
                            <div class="card-bottom-container">
                                <p>{{ Str::limit($project->getTranslation('excerpt', $locale, true), 120) }}</p>
                                {{-- <div class="tags-container mb-2">
                                    @foreach($project->tags as $tag)
                                        <span class="badge" style="background-color: {{ $tag->color_bg }}; color: {{ $tag->color_text }};">{{ $tag->name }}</span>
                                    @endforeach
                                </div> --}}
                                <a href="{{ route('projects.show.localized', ['locale' => $locale, 'project_slug' => $project->getTranslation('slug', $locale, true)]) }}" class="white-btn">
                                    <span>DONATE ></span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center w-100">No projects found for the initial load.</p>
                @endforelse
            </div>
            <div id="loading-indicator" class="text-center my-4" style="display: none;">
                <div class="spinner-border text-danger" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
</section>

{{-- TEMPLATE PARA LAS TARJETAS DINÁMICAS (CSR) --}}
<template id="project-card-template">
    <div class="help-cards project-card">
        <div class="card-top">
            <a class="project-link" href="#">
                <img class="project-image" src="#" alt="">
            </a>
            <div class="card-title-position">
                <h4 class="project-title"></h4>
            </div>
        </div>
        <div class="card-bottom">
            <div class="card-bottom-container">
                <p class="project-excerpt"></p>
                {{-- <div class="project-tags-container tags-container mb-2"></div> --}}
                <a class="white-btn project-link" href="#">
                    <span>DONATE ></span>
                </a>
            </div>
        </div>
    </div>
</template>

@endsection

@push('styles')
    <style>
        /* Estilos para el contenedor principal del banner */

.explore-fundarisings {
    background-color: #f56161;
    margin-top: 8rem;
}

.search-banner-container {
    color: #ffffff;
    /* Añadimos posición relativa si alguna vez necesitamos elementos absolutos dentro */
    position: relative;
    /* Opcional: si quieres las líneas diagonales como en la imagen */
    /* overflow: hidden;  */ /* Necesario para que ::after no se salga */
}

/* Estilos opcionales para las líneas decorativas (si las quieres) */
/* .search-banner-container::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 80px;
    height: 100%;
    background: linear-gradient(135deg, transparent 55%, #FFD700 55%, #FFD700 65%, transparent 65%),
                linear-gradient(135deg, transparent 65%, #4169E1 65%, #4169E1 75%, transparent 75%);
    background-repeat: no-repeat;
    background-position: top right;
    pointer-events: none;
} */

/* Contenido de texto a la izquierda */
.text-content .sub-heading {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.8;
}

.text-content .main-heading {
    font-size: clamp(1.5rem, 4vw, 2.2rem); /* Tamaño responsivo */
    font-weight: bold;
    line-height: 1.2;
    text-transform: uppercase;
}

/* Contenido de búsqueda a la derecha */
.search-input-group {
    border-radius: 25px; /* Bordes redondeados para el grupo */
    overflow: hidden; /* Para que los hijos respeten el borde redondeado */
    background-color: #ffffff; /* Fondo blanco para el grupo */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra sutil */
}

.search-input.form-control {
    border: none; /* Sin borde */
    background-color: transparent; /* Fondo transparente (el blanco viene del input-group) */
    padding: 0.75rem 1.2rem; /* Padding interno */
    color: #555; /* Color del texto que se escribe */
    height: auto; /* Permitir altura automática */
    font-size: 0.9rem;
}

/* Estilo del placeholder */
.search-input.form-control::placeholder {
    color: #999; /* Color gris claro para el placeholder */
    opacity: 1; /* Asegurar opacidad */
}

/* Quitar sombra de foco de Bootstrap */
.search-input.form-control:focus {
    box-shadow: none;
    border: none;
    background-color: transparent;
}

.search-button.btn {
    background-color: transparent; /* Fondo transparente */
    border: none;
    color: #888; /* Color del icono de lupa */
    padding: 0.75rem 1.2rem; /* Padding similar al input */
    font-size: 1rem; /* Tamaño del icono */
}

.search-button.btn:hover {
    color: #f56161; /* Cambiar color del icono al pasar el ratón */
}

/* Texto de ayuda en móvil */
.search-helper-text {
    color: rgba(255, 255, 255, 0.38); /* Blanco con 38% de opacidad */
    font-size: 0.75rem;
    text-align: center; /* Centrado en móvil */
}

/* Ajustes Responsivos Adicionales (si son necesarios) */
@media (max-width: 767.98px) {
    /* Debajo de md (móviles) */
    .search-banner-container {
        padding: 1.5rem; /* Menos padding en móvil */
    }
    /* Ajustes de texto si se ven muy grandes en móvil */
    .text-content .main-heading {
        /* font-size: 1.3rem; */ /* Ejemplo de reducción */
    }
}

/* RESULTS */

.results{
    min-height: 467.03px;
}

.results .cards-container {
    flex-wrap: wrap;
}

.results .card-title-position h4 {
    background-color: #fff;
}

    </style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('project-search-input');
    const container = document.getElementById('projects-container');
    const template = document.getElementById('project-card-template');
    const loadingIndicator = document.getElementById('loading-indicator');
    let searchTimeout;

    // Escuchar tanto el input para búsqueda en tiempo real como el submit del formulario
    searchInput.addEventListener('input', handleDebouncedSearch);
    searchInput.form.addEventListener('submit', function(e) {
        e.preventDefault(); // Evitar recarga de página
        clearTimeout(searchTimeout); // Cancelar cualquier búsqueda pendiente
        performSearch(searchInput.value); // Realizar búsqueda inmediatamente
    });

    function handleDebouncedSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(searchInput.value);
        }, 400); // Esperar 400ms después de que el usuario deja de teclear
    }

    async function performSearch(searchTerm) {
        loadingIndicator.style.display = 'block';
        container.innerHTML = ''; // Limpiar resultados actuales

        const apiUrl = `/api/projects?search=${encodeURIComponent(searchTerm)}&lang={{ $locale }}`;
        
        try {
            const response = await fetch(apiUrl);
            if (!response.ok) { throw new Error('Network response was not ok.'); }
            
            const results = await response.json();

            loadingIndicator.style.display = 'none';

            if (results.data && results.data.length > 0) {
                results.data.forEach(project => {
                    const card = template.content.cloneNode(true);
                    
                    const projectLink = card.querySelectorAll('.project-link');
                    const projectImage = card.querySelector('.project-image');
                    const projectTitle = card.querySelector('.project-title');
                    const projectExcerpt = card.querySelector('.project-excerpt');
                    const tagsContainer = card.querySelector('.project-tags-container');

                    projectLink.forEach(link => link.href = project.links.self_web);
                    projectImage.src = project.featured_image.optimized || '{{ asset("images/placeholder.jpg") }}';
                    projectImage.alt = project.title;
                    projectTitle.textContent = project.title;
                    projectExcerpt.textContent = project.excerpt ? project.excerpt.substring(0, 120) + '...' : '';
                    
                    // Renderizar los tags
                    // if (project.tags && project.tags.length > 0) {
                    //     project.tags.forEach(tag => {
                    //         const tagElement = document.createElement('span');
                    //         tagElement.className = 'badge';
                    //         tagElement.style.backgroundColor = tag.colors.background;
                    //         tagElement.style.color = tag.colors.text;
                    //         tagElement.textContent = tag.name;
                    //         tagsContainer.appendChild(tagElement);
                    //     });
                    // }
                    
                    container.appendChild(card);
                });
            } else {
                container.innerHTML = '<p class="text-center w-100">No projects found matching your search.</p>';
            }
        } catch (error) {
            loadingIndicator.style.display = 'none';
            container.innerHTML = '<p class="text-center text-danger w-100">An error occurred while searching. Please try again later.</p>';
            console.error('Fetch error:', error);
        }
    }
});
</script>
@endpush
