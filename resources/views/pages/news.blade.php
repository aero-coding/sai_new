@php
    $currentLocale = app()->getLocale();
    $content = $page->getTranslation('content', $currentLocale, useFallbackLocale: true) ?? [];
@endphp
@extends('layouts.app')

@section('title', 'News')

@section('content')
<section id="stories" class="section news-stories row justify-content-center">
    <div class="news-stories-container col-12 col-md-9 d-flex flex-column ">
        <h1 class="clipped-container-stripes">{{ $content['h1_title'] ?? 'Our Stories' }}</h1>
        <div class="search-bar-container d-flex align-items-center justify-content-center flex-column">
            {{-- BUSCADOR --}}
            <div class="input-group custom-search-group">
                <input type="search" id="report-search-input" class="form-control search-input" placeholder="{{ $content['search_text'] ?? 'Search reports...' }}" aria-label="Search reports">
                <span class="input-group-text search-icon-container">
                    <i class="fas fa-search search-icon"></i>
                </span>
            </div>
            {{-- FILTROS POR TAG --}}
            <div class="search-tags d-flex align-items-center justify-content-center flex-wrap">
                <a href="#" class="btn btn-topic tag-filter-btn" data-tag-id="">All</a> {{-- Botón para mostrar todos --}}
                @foreach($tags as $tag)
                    <a href="#" class="btn btn-topic tag-filter-btn" data-tag-id="{{ $tag->id }}" style="background-color: {{ $tag->color_bg }}; color: {{ $tag->color_text }};">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</section>
<section class="section most-read-reports row justify-content-center">
    <div class="col-12 most-read-container row justify-content-center">
    <h2 id="results-title" class="col-12 col-md-11">{{ $content['most_read_title'] ?? 'Most Read Reports' }}</h2>
        {{-- CONTENEDOR DE RESULTADOS --}}
        <div id="reports-container" class="news-cards-col col-12 col-md-11">
            <div class="news-cards-container">
                {{-- Carga inicial de reportes (SSR) --}}
                @forelse($initialReports as $report)
                    <div class="news-card help-cards">
                        <div class="card-top">
                             <a href="{{ route('report.show.localized', ['locale' => $locale, 'report_slug' => $report->getTranslation('slug', $locale, true)]) }}">
                                @if($report->hasMedia('featured_image'))
                                    <img src="{{ $report->getFirstMediaUrl('featured_image', 'thumbnail') }}" alt="{{ $report->getTranslation('title', $locale, true) }}">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" alt="Default report image">
                                @endif
                             </a>
                            <div class="card-title-position">
                                {{-- <h4 style="{{ $report->project->tags->isNotEmpty() ? 'background-color:' . $report->project->tags->first()->color_bg . ';' : '' }}">
                                    {{ $report->project->getTranslation('title', $locale, true) }}
                                </h4> --}}
                                <h4 class="text-truncate" style="{{ $report->project->tags->isNotEmpty() ? 'background-color: ' . $report->project->tags->first()->color_bg . '; color: ' . $report->project->tags->first()->color_text . ';' : '' }}">
                                    {{ $report->project->getTranslation('title', $locale, true) }}
                                </h4>
                            </div>
                        </div>
                        <div class="card-bottom">
                            <div class="card-bottom-container">
                                {{-- <h5 class="report-card-title">{{ $report->getTranslation('title', $locale, true) }}</h5> --}}
                                <p class="news-card-text">{{ Str::limit($report->getTranslation('excerpt', $locale, true), 100) }}</p>
                                <div class="tags-container mb-2">
                                    @foreach($report->tags as $tag)
                                        <span class="badge" style="background-color: {{ $tag->color_bg }}; color: {{ $tag->color_text }};">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                                <div class="new-info d-flex align-items-center align-items-md-start justify-content-between flex-column flex-md-row">
                                    <div class="new-info-text">
                                        <span>{{ $report->published_at?->format('d M Y') }}</span>
                                        <span>Posted by {{ $report->creator->name ?? 'N/A' }}</span>
                                    </div>
                                    <a href="{{ route('report.show.localized', ['locale' => $locale, 'report_slug' => $report->getTranslation('slug', $locale, true)]) }}" class="new-info-btn">
                                        <span>READ MORE ></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center w-100">No reports found.</p>
                @endforelse
            </div>
    </div>
</section>
<section class="section recent-articles">
    <div class="most-read-container row justify-content-center">
        <h2 class="col-12 col-md-11">{{ $content['recent_articles_title'] ?? 'Recent Articles' }}</h2>
        <div class="news-cards-col col-12 col-md-11">
            <div class="news-cards-container">
                @forelse($recentArticles as $article)
                    <div class="news-card help-cards">
                        <div class="card-top">
                            <a href="{{ route('report.show.localized', ['locale' => $locale, 'report_slug' => $article->getTranslation('slug', $locale, true)]) }}">
                                @if($article->hasMedia('featured_image'))
                                    <img src="{{ $article->getFirstMediaUrl('featured_image', 'thumbnail') }}" alt="{{ $article->getTranslation('title', $locale, true) }}">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" alt="Default report image">
                                @endif
                            </a>
                            <div class="card-title-position">
                                {{-- LÓGICA DE COLOR DINÁMICO --}}
                                <h4 class="text-truncate" style="{{ $article->project->tags->isNotEmpty() ? 'background-color: ' . $article->project->tags->first()->color_bg . '; color: ' . $article->project->tags->first()->color_text . ';' : '' }}">
                                    {{ $article->project->getTranslation('title', $locale, true) }}
                                </h4>
                            </div>
                        </div>
                        <div class="card-bottom">
                            <div class="card-bottom-container">
                                {{-- <h5 class="report-card-title">{{ $article->getTranslation('title', $locale, true) }}</h5> --}}
                                <p class="news-card-text">{{ Str::limit($article->getTranslation('excerpt', $locale, true), 100) }}</p>
                                <div class="tags-container mb-2">
                                    @foreach($article->tags as $tag)
                                        <span class="badge" style="background-color: {{ $tag->color_bg }}; color: {{ $tag->color_text }};">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                                <div class="new-info d-flex align-items-center align-items-md-start justify-content-between flex-column flex-md-row">
                                    <div class="new-info-text">
                                        <span>{{ $article->published_at?->format('d M Y') }}</span>
                                        <span>Posted by {{ $article->creator->name ?? 'N/A' }}</span>
                                    </div>
                                    <a href="{{ route('report.show.localized', ['locale' => $locale, 'report_slug' => $article->getTranslation('slug', $locale, true)]) }}" class="new-info-btn">
                                        <span>READ MORE ></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center w-100">No recent articles to show.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
<div class="scroll-top d-flex justify-content-center align-items-center">
    <a href="#stories" class="scroll-top-btn">Scroll to the top</a>
</div>

{{-- TEMPLATE PARA LAS TARJETAS DINÁMICAS (CSR) --}}
<template id="report-card-template">
    <div class="news-card help-cards">
        <div class="card-top">
            <a class="report-link" href="#">
                <img class="report-image" src="#" alt="">
            </a>
            <div class="card-title-position">
                <h4 class="report-project-title text-truncate"></h4>
            </div>
        </div>
        <div class="card-bottom">
            <div class="card-bottom-container">
                {{-- <h5 class="report-title"></h5> --}}
                <p class="news-card-text report-excerpt"></p>
                <div class="report-tags-container tags-container mb-2"></div>
                <div class="new-info d-flex align-items-center align-items-md-start justify-content-between flex-column flex-md-row">
                    <div class="new-info-text">
                        <span class="report-date"></span>
                        <span class="report-author"></span>
                    </div>
                    <a href="#" class="new-info-btn report-link">
                        <span>READ MORE ></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
@endsection

@push('styles')
<style>
    .post-img-wrap {
        min-height: 177px;
    }
    .pills {
        background: none repeat scroll 0 0 #f2f2f2;
        border: 1px solid #cfcfcf;
    }

    .post-img-wrap .post-img,
    .page-single-img-wrap .post-img {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: initial !important;
        background-repeat: no-repeat;
        transition: all ease-in-out 0.5s;
        -webkit-transition: all ease-in-out 0.5s;
        -moz-transition: all ease-in-out 0.5s;
        transform: scale(1.006);
        -webkit-transform: scale(1.006);
        -moz-transform: scale(1.006);
    }

    /* NEW */


    .news-stories{
        padding-top: 8rem;
        padding-bottom: 14rem;

    }

    h1{
        background-color: #D94647;
        color: #fff;
        width: 100%;
        text-align: left;
        padding: 1rem 4rem 2rem 1.5rem;
        font-weight: 600;
        position: relative;
    }


    /* SEARCH BAR */
    main{
        background-color: #F4F4F4;
    }

    .news-stories{
        background-color: #fff;
    }

    .news-stories-container{
        padding-left: 0;
        padding-right: 0;
    }

    .search-bar-container{
        margin-top: 3rem;
    }

    .search-tags{
        gap: 1rem;
    }

    .btn-topic{
        color: #000;
        font-size: 0.9rem;
        padding: 0.1rem 1rem;
        border-radius: 0;
        border-bottom-left-radius: 3px;
    }

    /* NEWS STORIES */

    .most-read-reports{
        position: relative
    }

    .most-read-container{
        width: 100%;
        position: relative;
        top: -10.5rem
    }

    .most-read-container h2{
        text-align: left;
        padding: 1rem 4rem 2rem 0rem;
        border-bottom:  2px solid #c1c1c1;
    }

    .news-cards-col{
        padding-left: 0;
        padding-right: 0;
    }

    /* RECENT ARTICLES */

    .recent-articles .news-card{
        width: 49%;
    }

    @media (max-width: 839px){
        .recent-articles .news-cards-container {
            flex-wrap: wrap;
            overflow: auto;
        }

        .recent-articles .news-card{
            width: 100%;
            margin-bottom: 1rem;
            margin: 0.4rem;
        }
        .recent-articles .news-card .new-info{
            
        }
    }

    /* Estilo principal para el grupo de la barra de búsqueda */
.custom-search-group {
display: flex;           /* Alinea el input y el icono horizontalmente */
width: 50%;
max-width: 500px;
margin-bottom: 1rem;

border: 1px solid #ccc; /* Borde gris claro */
border-radius: 6px;     /* Esquinas ligeramente redondeadas */
background-color: #fff; /* Fondo blanco */
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); /* Sombra sutil */
overflow: hidden;       /* Asegura que el contenido respete el border-radius */
transition: border-color 0.2s ease, box-shadow 0.2s ease; /* Transición suave para focus */
}

/* Estilo para el campo de texto (input) */
.search-input {
flex-grow: 1;             /* Permite que el input ocupe el espacio disponible */
border: none;             /* Quita el borde por defecto del input */
box-shadow: none;         /* Quita sombras por defecto (ej. focus de Bootstrap) */
background-color: transparent; /* Fondo transparente para ver el del grupo */
padding: 10px 15px;       /* Espaciado interno cómodo */
font-size: 1rem;          /* Tamaño de fuente estándar */
color: #333;             /* Color del texto ingresado */
outline: none;            /* Quita el borde azul de focus por defecto del navegador */
}

/* Estilo para el placeholder del input */
.search-input::placeholder {
color: #aaa;             /* Color gris claro para el placeholder */
opacity: 1;               /* Asegura que sea visible */
}

/* Estilo para el contenedor del icono */
.search-icon-container {
display: flex;            /* Permite centrar el icono verticalmente */
align-items: center;      /* Centra el icono verticalmente */
padding: 0 15px;          /* Espaciado horizontal alrededor del icono */
border: none;             /* Quita borde por defecto */
background-color: transparent; /* Fondo transparente */
}

/* Estilo para el icono de búsqueda */
.search-icon {
color: #777;             /* Color gris oscuro para el icono */
font-size: 1rem;          /* Tamaño del icono */
}

/* Opcional: Estilo cuando la barra de búsqueda tiene focus */
.custom-search-group:focus-within {
border-color: #80bdff; /* Cambia el color del borde (ejemplo azul claro) */
box-shadow: 0 1px 4px rgba(0, 123, 255, 0.15); /* Sombra de focus más pronunciada */
}

/* Asegúrate de que el input no muestre su propio outline al hacer focus */
.search-input:focus {
box-shadow: none;
border-color: transparent; /* Evita conflicto con el borde del grupo */
}

/* SCROLL TOP */

main{
    position: relative;
}

.scroll-top{
    width: 100%;
    position: absolute;
    bottom: 3rem;

}

.scroll-top-btn{
    color: #FC6768;
}

@media (max-width: 839px){

        .custom-search-group{
            width: 90%;
        }
    }

    .news-stories .clipped-container-stripes::before {
        z-index: 2 !important;
        background-color: #2161ac;
        width: 27px;
        right: 30px;
        z-index: 2;
    }

    .news-stories .clipped-container-stripes::after {
        z-index: 1 !important;
        background-color: #fff0a1;
        width: 57px;
        right: 0;
        z-index: 2;
        transform: none;
    }


</style>
@endpush

@push('styles')
    {{-- (Aquí van tus estilos existentes de news.blade.php) --}}
    <style> /* Estilos de ejemplo */
        .search-tags .btn-topic { cursor: pointer; transition: transform 0.2s; }
        .search-tags .btn-topic.active { transform: scale(1.1); font-weight: bold; }
        .news-cards-container { display: flex; flex-wrap: wrap; gap: 1rem; }
        .news-card { width: calc(33.333% - 1rem); /* Ejemplo para 3 columnas */ }
        .report-card-title { font-size: 1.1rem; font-weight: bold; }
        .tags-container .badge { font-size: 0.75rem; padding: 0.3em 0.6em; margin-right: 0.3em; margin-bottom: 0.3em; }
    </style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('report-search-input');
    const tagButtons = document.querySelectorAll('.tag-filter-btn');
    const container = document.querySelector('.news-cards-container');
    const template = document.getElementById('report-card-template');
    const resultsTitle = document.getElementById('results-title');
    const defaultTitle = "{{ $content['most_read_title'] ?? 'Most Read Reports' }}";
    let searchTimeout;
    let currentTagId = '';

    // Event Listeners
    searchInput.addEventListener('input', () => debounceSearch(performSearch));
    tagButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentTagId = this.dataset.tagId;
            // Estilo del botón activo
            tagButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            // Actualizar título y buscar
            resultsTitle.textContent = this.dataset.tagId ? `Reports tagged with "${this.textContent}"` : defaultTitle;
            performSearch();
        });
    });

    const debounceSearch = (callback, delay = 400) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(callback, delay);
    };

    // dentro de la etiqueta <script> en news.blade.php

        async function performSearch() {
    const searchTerm = searchInput.value;
    container.innerHTML = '<div class="d-flex justify-content-center w-100"><div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div></div>';

    const params = new URLSearchParams({
        lang: '{{ $locale }}'
    });

    if (searchTerm) params.append('search', searchTerm);
    if (currentTagId) params.append('tag_id', currentTagId);

    try {
        const response = await fetch(`/api/reports?${params.toString()}`);
        if (!response.ok) throw new Error(`API error: ${response.status}`);
        
        const { data: reports } = await response.json();
        container.innerHTML = '';

        if (reports && reports.length > 0) {
            reports.forEach(report => {
                const card = template.content.cloneNode(true);
                
                // Configurar enlaces e imágenes
                card.querySelectorAll('.report-link').forEach(link => {
                    link.href = report.links?.self_web || '#';
                });
                
                const img = card.querySelector('.report-image');
                img.src = report.featured_image?.thumbnail || '{{ asset("images/placeholder.jpg") }}';
                img.alt = report.title;
                
                // Configurar texto
                const projectTitle = card.querySelector('.report-project-title');
                projectTitle.textContent = report.project?.title || '';
                
                card.querySelector('.report-excerpt').textContent = report.excerpt?.substring(0, 100) + '...' || '';
                card.querySelector('.report-date').textContent = report.published_date || '';
                card.querySelector('.report-author').textContent = `Posted by ${report.creator?.name || 'N/A'}`;
                
                // Configurar tags y colores
                const tagsContainer = card.querySelector('.report-tags-container');
                tagsContainer.innerHTML = '';
                
                if (report.tags && report.tags.length > 0) {
                    report.tags.forEach(tag => {
                        const tagEl = document.createElement('span');
                        tagEl.className = 'badge me-1';
                        tagEl.style.backgroundColor = tag.color_bg;
                        tagEl.style.color = tag.color_text;
                        tagEl.textContent = tag.name;
                        tagsContainer.appendChild(tagEl);
                    });
                    
                    // Aplicar colores al título del proyecto (primer tag)
                    const firstTag = report.tags[0];
                    projectTitle.style.backgroundColor = firstTag.color_bg;
                    projectTitle.style.color = firstTag.color_text;
                }
                
                container.appendChild(card);
            });
        } else {
            container.innerHTML = '<p class="text-center w-100 py-4">No reports found</p>';
        }
    } catch (error) {
        console.error('Search error:', error);
        container.innerHTML = '<p class="text-center text-danger w-100 py-4">Error loading reports</p>';
    }
}
});
</script>
@endpush
