{{-- @php
    $content = $project->getTranslation('content', $locale, false) ?? [];
    $featuredImage = $project->getFirstMediaUrl('featured_image');
    $galleryImages = $project->getMedia('gallery');
@endphp --}}

@extends('layouts.app')

@section('title', $project->getTranslation('title', $locale))

@section('content')

<style>


@media (min-width: 768px) {
.fixed-size {
  width: 200px;   /* Ancho deseado */
  height: 150px;  /* Alto deseado */
  object-fit: cover; /* Opcional: recorta la imagen para que encaje */
}
}

@media (max-width: 768px) {
.fixed-size {
  width: 150px;   /* Ancho deseado */
  height: 150px;  /* Alto deseado */
  object-fit: cover; /* Opcional: recorta la imagen para que encaje */
}
}

</style>
<section class="section hero-section-limited-height row justify-content-center">
    <div class="hero-image-container p-0"> 
        {{-- IMPLEMENTACIÓN: Mostrar la imagen destacada del proyecto --}}
        <img src="{{ $featuredImage ?: asset('images/placeholder.jpg') }}" alt="{{ $project->getTranslation('title', $locale) }}">
        
        <a href="javascript:history.back()" class="back-link"> 
            &lt; Back to&nbsp;<span>Explore Campaigns</span>
        </a>
    </div>
</section>
<div>

</div>
<section class="section right-aside-section row justify-content-center">
    <div class="right-left-container col-12 col-md-10 row">
        <div class="info-container col-12 col-md-8 d-flex flex-column justify-content-center">
            <h1 class="text-uppercase text-truncate clipped-container-stripes">{{ $project->getTranslation('title', $locale) ?? '' }}</h1>
            <div class="info-data d-flex flex-column">
                <div class="info-tags">
                    <img src="{{ asset('assets/img/global/badges/verified_ngo.png') }}" alt="Verified NGO Badge">
                    <span>Verified</span>
                    <img src="{{ asset('assets/img/global/badges/best_ngo.png') }}" alt="Best NGO Badge">
                    <span>Best NGO</span>
                    <img src="{{ asset('assets/img/global/badges/favorite_ngo.png') }}" alt="Favorite NGO Badge">
                    <span>Favorite</span>
                    <img src="{{ asset('assets/img/global/badges/certified_ngo.png') }}" alt="Certified NGO Badge">
                    <span>Certified</span>
                </div>
                <div class="info-mission">
                    <span>{{ $content['description_heading'] ?? '' }}</span>
                </div>
                <p>{{ $content['desciption_text'] ?? '' }}</p>
                <a href="">View Website ></a>
                {{-- @if(isset($project->social_links['website']))
                    <a href="{{ $project->social_links['website'] }}" target="_blank">View Website ></a>
                @endif --}}
            </div>
            <div class="tabs-container d-flex flex-column w-100">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="story-tab" data-bs-toggle="tab" data-bs-target="#story" type="button" role="tab" aria-controls="story" aria-selected="true">STORY</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="false">GALLERY</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">REPORTS</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="story" role="tabpanel" aria-labelledby="story-tab">
                        <h3>{{ $content['summary_title'] ?? '' }}</h3>
                        <p>{{ $content['summary_text'] ?? '' }}</p>
                        <div class="image-gallery-container">
                            <div class="gallery-column-left">
                                <div class="main-image-wrapper">
                                    {{-- <img src="{{ asset('example.jpg') }}" alt="Imagen Principal de la Galería" class="main-image zoomable-image"> --}}
                                    {{-- @if($galleryImages->has(0))
                                        <img src="{{ $galleryImages[0]->getUrl('optimized') }}" alt="Main gallery image" class="main-image">
                                    @else
                                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Main gallery image" class="main-image">
                                    @endif --}}
                                    @if(!empty($videoIframe))
                                        {{-- Mostrar el iframe de video si existe --}}
                                        <div class="video-container">
                                            {!! $videoIframe !!}
                                        </div>
                                    @else
                                        {{-- Mostrar la imagen si no hay video --}}
                                        @if($galleryImages->has(0))
                                            <img src="{{ $galleryImages[0]->getUrl('optimized') }}" alt="Main gallery image" class="main-image">
                                        @else
                                            <img src="{{ asset('images/placeholder.jpg') }}" alt="Main gallery image" class="main-image">
                                        @endif
                                    @endif
                                </div>
                                {{-- <div class="new-info-text">
                                    <span>8 Feb 2025</span>
                                    <span class="posted-by">Posted by <img src="" alt="Avatar del autor" class="author-avatar"> John Doe</span>
                                </div> --}}
                                <div class="new-info-text">
                                    <span>{{ $project->published_at?->format('d M Y') }}</span>
                                    <span class="posted-by">Posted by <img src="{{-- {{ $project->user->getAvatar() ?? asset('images/avatar_placeholder.png') }} --}}" alt="Author avatar" class="author-avatar"> {{ $project->user->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            {{-- <div class="gallery-column-right">
                                <div class="thumbnail-image-wrapper">
                                    <img src="{{ asset('example.jpg') }}" alt="Miniatura 1" class="thumbnail-image zoomable-image">
                                </div>
                                <div class="thumbnail-image-wrapper">
                                    <img src="{{ asset('example.jpg') }}" alt="Miniatura 2" class="thumbnail-image zoomable-image">
                                </div>
                                <div class="thumbnail-image-wrapper">
                                    <img src="{{ asset('example.jpg') }}" alt="Miniatura 3" class="thumbnail-image zoomable-image">
                                </div>
                                <a href="#" class="see-all-photos-link">See all Photos ></a>
                            </div> --}}
                            <div class="gallery-column-right">
                                {{-- Las siguientes 3 imágenes como miniaturas --}}
                                @for ($i = 1; $i <= 3; $i++)
                                    @if($galleryImages->has($i))
                                    <div class="thumbnail-image-wrapper">
                                        <img src="{{ $galleryImages[$i]->getUrl('optimized') }}" alt="Thumbnail {{ $i }}" class="thumbnail-image">
                                    </div>
                                    @endif
                                @endfor
                                <a href="#" onclick="event.preventDefault(); document.getElementById('gallery-tab').click();" class="see-all-photos-link">See all Photos ></a>
                            </div>
                        </div>
                        @if($textEditorContent)
                                    {!! $textEditorContent !!}
                                @else
                                    {{-- Contenido de respaldo si el editor está vacío --}}
                                    <h3>{{ $content['summary_title'] ?? 'Our Story' }}</h3>
                                    <p>{{ $content['summary_text'] ?? 'Content will be available soon.' }}</p>
                                    {{-- Puedes mantener o quitar el resto del contenido estático --}}
                        @endif
                    </div>
                    <div class="tab-pane fade d-flex flex-wrap row justify-content-start" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                        {{-- <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt="">
                        <img class="col-3 p-1" src="{{asset('example.jpg')}}" alt=""> --}}
                        @forelse($galleryImages as $image)
                            <div class="col-6 col-md-4 col-lg-3 p-1">
                                <a href="{{ $image->getUrl() }}" data-lightbox="project-gallery">
                                    <!--<img class="img-fluid rounded" src="{{ $image->getUrl('optimized') }}" alt="Gallery image {{ $loop->iteration }}">-->
                                    <img class="fixed-size rounded" src="{{ $image->getUrl('optimized') }}" alt="Gallery image {{ $loop->iteration }}">
                                </a>
                            </div>
                        @empty
                            <p class="text-muted">This project does not have a gallery yet.</p>
                        @endforelse
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <h3>{{ $content['reports_title'] ?? '' }}</h3>
                        <div class="report-open-card ">
                            <div class="news-cards-container">
                                {{-- <div class="news-main-card news-card">
                                    <div class="news-card-top"></div>
                                    <div class="news-card-bot"></div>
                                </div> --}}
                                {{-- <div class="news-card help-cards">
                                    <div class="card-top">
                                        <img src="{{asset('example.jpg')}}" alt="">
                                        <div class="card-title-position">
                                            <h4 class="red-cl">SAI Medical Clinic for Children</h4>
                                        </div>
                                    </div>
                                    <div class="card-bottom">
                                        <div class="card-bottom-container">
                                            <p class="news-card-text">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Et dolore error labore maiores nulla quos quisquam neque! Est similique.
                                            </p>
                                            <div class="new-info d-flex flex-column align-items-start">
                                                <div class="new-info-text">
                                                    <span>8 Feb 2025</span>
                                                    <span>Posted by <img src="" alt=""> John Doe</span>
                                                </div>
                                                <a href="{{ route('projectabout') }}" class="new-info-btn">
                                                    <span>READ MORE ></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                @forelse($project->reports as $report)
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
                                                @php $firstTag = $report->tags->first(); @endphp
                                                <h4 class="text-truncate" style="{{ $firstTag ? 'background-color: ' . e($firstTag->color_bg) . '; color: ' . e($firstTag->color_text) . ';' : '' }}">
                                                    {{ $report->getTranslation('title', $locale, true) }}
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="card-bottom">
                                            <div class="card-bottom-container">
                                                <p class="news-card-text">{{ Str::limit($report->getTranslation('excerpt', $locale, true), 100) }}</p>
                                                <div class="tags-container mb-2">
                                                    @foreach($report->tags as $tag)
                                                        <span class="badge" style="background-color: {{ $tag->color_bg }}; color: {{ $tag->color_text }};">{{ $tag->name }}</span>
                                                    @endforeach
                                                </div>
                                                <div class="new-info d-flex flex-column align-items-start">
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
                                    <p class="text-muted">There are no reports for this project yet.</p>
                                @endforelse
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="left-right-image w-100 row p-0 d-none d-md-flex">
                <div class="left-text col-12 col-md-7 d-flex flex-column">
                    <h3>{{ $content['help_mini_title'] ?? '' }}</h3>
                    <span class="text-uppercase">{{ $content['help_title'] ?? '' }}</span>
                    <a href="" class="white-btn">{{ $content['help_btn_text'] ?? '' }}</a>

                </div>
                <div class="right-image col-12 col-md-5 d-flex flex-column">
                    <img src="{{ $featuredImage ?: asset('images/placeholder.jpg') }}" alt="">
                </div>
            </div>
            <div class="left-right-image-mobile w-100 d-flex d-md-none flex-column">
                <div class="left-text col-12 d-flex flex-column">
                    <div class="p-3 d-flex flex-column">
                        <h3>{{ $content['help_mini_title'] ?? '' }}</h3>
                        <span>{{ $content['help_title'] ?? '' }}</span>
                    </div>
                    <img class="w-100" src="{{ $featuredImage ?: asset('images/placeholder.jpg') }}" alt="">
                    <a href="" class="white-btn align-self-center">{{ $content['help_btn_text'] ?? '' }}</a>
                </div>
                
            </div>
        </div>
        <div class="donation-container col-12 col-md-4">
            {{-- <div class="donation-bg"></div> --}}
            {{-- IMPLEMENTACIÓN: Mostrar el iframe de donación del proyecto --}}
            @if($donationIframe)
                {!! $donationIframe !!}
            @else
                <div class="p-4 text-white">
                    <h4>Support this Project</h4>
                    <p>Donation information will be available soon.</p>
                </div>
            @endif
    </div>
    </div>
</section>
@endsection

@push('styles')
    <style>
.hero-section-limited-height {
        max-height: 430px;  /* Mantiene tu límite de altura */
        height: 430px;      /* Es buena idea definir también height */
        overflow: hidden;   /* Muy importante: recorta lo que exceda */
        position: relative; /* Necesario para elementos hijos posicionados absolutamente */
        width: 100%;        /* Asegura que ocupe todo el ancho disponible */
    }

    /* Contenedor interno que contiene la imagen y el enlace */
    .hero-image-container {
        position: relative; /* Necesario para posicionar el back-link */
        width: 100%;        /* Ocupa todo el ancho del padre */
        height: 100%;       /* Ocupa toda la altura del padre (430px) */
        color: #ffffff;     /* Color de texto por defecto para el contenido sobre la imagen */
         /* Eliminamos padding (p-0 en HTML) para que la imagen toque los bordes */
         /* display: flex y related properties no son necesarios para el posicionamiento de la imagen */
    }

    /* Estilo específico para la IMAGEN dentro del contenedor */
    .hero-image-container img {
        display: block;     /* Elimina espacio extra debajo de la imagen si es inline */
        width: 100%;        /* Fuerza a la imagen a ocupar el 100% del ANCHO del contenedor */
        height: 100%;       /* Fuerza a la imagen a ocupar el 100% de la ALTURA del contenedor */
        object-fit: cover;  /* CLAVE: Redimensiona la imagen manteniendo el aspect ratio */
                            /* para llenar el contenedor. Recortará la imagen (sin deformar) */
                            /* si su aspect ratio no coincide con el del contenedor. */
        object-position: center; /* Opcional: Centra la imagen dentro del contenedor */
                                 /* antes de recortar (puedes usar top, bottom, left, right) */
    }


    /* --- Estilos del Enlace "Volver Atrás" (sin cambios) --- */
    .back-link {
        position: absolute;
        top: 90px;
        left: 10%;
        z-index: 10;
        color: #ffffff;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
    }

    .back-link span{
        color: #FFF0A1;
    }

    .back-link:hover {
        color: #fff;
    }


    /* --- Ajustes Responsivos (Revisados) --- */
    @media (max-width: 767.98px) {
         /* Ya no necesitas ajustar la altura aquí si quieres que siempre sea 430px */
         /* Si SÍ quieres diferente altura en móvil, descomenta y ajusta .hero-section-limited-height */
        /*
        .hero-section-limited-height {
             height: 350px;
             max-height: 350px;
        }
        */
       .back-link {
            top: 15px;
            left: 15px;
            font-size: 0.75rem;
            padding: 5px 8px;
        }
    }

    .hero-image-container::before {
        z-index: 1;
        content: ""; /* Necesario para que el pseudo-elemento se muestre */
        position: absolute; /* Posicionamiento absoluto dentro del contenedor */
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* La propiedad background contendrá el degradado radial */
        background: radial-gradient(
            circle at bottom left,
            rgba(254, 87, 87, 0.882) 0%,
            rgba(254, 87, 87, 0.675) 10%,
            rgba(254, 87, 87, 0.353) 30%,
            transparent 50%
        );
        pointer-events: none;
    }

    /* MAIN CONTENT */

    body{
        background-color: #F4F4F4;
    }

    .right-aside-section{
        position: relative;
    }

    .right-left-container{
        z-index: 50;
        padding: 0;
        position: relative;
        top: -4.8rem;
    }

    /* left */
    
    .right-aside-section .info-container{
        margin-bottom: 1.5rem;
        padding: 0;
    }

    .right-aside-section .info-container h1{
        padding: 1rem 1rem 2rem 1rem;
        background-color: #D94647;
        color: #fff;
        font-weight: 600;
        position: relative;
    }


    .info-container .clipped-container-stripes::before {
        z-index: 2 !important;
        background-color: #2161ac;
        width: 27px;
        right: 30px;
        z-index: 2;
    }

    .info-container .clipped-container-stripes::after {
        z-index: 1 !important;
        background-color: #fff0a1;
        width: 57px;
        right: 0;
        z-index: 2;
        transform: none;
    }


    .right-aside-section .info-data{
        padding: 1rem 2rem;
        background-color: #fff;
        gap: 1rem;
        color: #484341;
        margin-bottom: 1.5rem;
    }

    .right-aside-section .info-data .info-mission{
        font-size: 1.75rem;
        font-weight: 600;
    }

    .right-aside-section .info-data p{
        font-weight: 500;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;  
        text-overflow: ellipsis;  
        display: -webkit-box;
    }

    .right-aside-section .info-data a{
    }
    
    .info-data img{
        max-width: 35px;
    }

    .info-data span{
        margin-right: 1rem;
    }
    
    /* right */

    .right-aside-section .donation-container{
        height: 1000px;
    }

    .donation-bg{
        height: 100%;
        width: 100%;
        background-color: #D94647;

    }

    /* AAAAAAAA */

    .right-aside-section .nav-tabs {
    border-bottom: none;
    }

    .right-aside-section .nav-tabs .nav-item{
        margin: 0;
        margin-right: 0.3rem;
    }

.right-aside-section .nav-tabs .nav-link {
    border: 1px solid transparent; /* Borde transparente por defecto */
    border-top-left-radius: .35rem; /* Bordes superiores redondeados */
    border-top-right-radius: .35rem;
    padding: 0.5rem 3.5rem 1rem 3.5rem;
    color: #fff; /* Color del texto de las pestañas inactivas */
    background-color: #D9D9D9; /* Color de fondo de las pestañas inactivas */
    margin-right: 2px; /* Pequeño espacio entre pestañas */
    transition: all 0.3s ease; /* Transición suave para hover/active */
}

/* Estilo para la pestaña cuando el cursor está encima (hover) */
.right-aside-section .nav-tabs .nav-link:hover {
    border-color: #e9ecef #e9ecef #dee2e6; /* Color del borde al pasar el ratón */
    background-color: #e9ecef; /* Color de fondo al pasar el ratón */
    color: #D94647; /* Color del texto al pasar el ratón */
}

/* Estilo específico para la pestaña ACTIVA (clase .active) */
.right-aside-section .nav-tabs .nav-link.active {
    color: #fff; /* Color del texto de la pestaña activa */
    background-color: #D94647; /* Color de fondo de la pestaña activa (tu color rojo) */
    border-color: #D94647 #D94647 #fff; /* Color del borde de la pestaña activa */
                                      /* El último valor (#fff) hace que "se una" con el contenido */
    border-bottom-color: transparent; /* Para que parezca que se conecta con el contenido */
    font-weight: 600; /* Texto en negrita para la pestaña activa */
}

/* Opcional: Si quieres que el texto de la pestaña activa no sea blanco */
/*
.nav-tabs .nav-link.active {
    color: #495057;
    background-color: #ffffff;
    border-color: #dee2e6 #dee2e6 #ffffff;
}
*/


/* Contenedor del contenido de las pestañas (clase .tab-content) */
.right-aside-section .tab-content {
    padding: 1.5rem;
    box-shadow: 0 0.125rem 1rem rgba(0, 0, 0, 0.075);
    background-color: #ffffff;
    border-radius: 5px;
    border-top-left-radius: 0;
}

.tab-content > .tab-pane:not(.show) {
    display: none !important;
}

.tab-pane#story h1, 
.tab-pane#story h2, 
.tab-pane#story h3, 
.tab-pane#story h4, 
.tab-pane#story h5, 
.tab-pane#story h6 {
    margin-bottom: 0.3rem;
}

.tab-pane#story p{
    margin-top: 0;
    margin-bottom: 1.5rem;
}

/* Para personalizar los IDs específicos de las pestañas si necesitas algo muy particular */
#home-tab { /* Pestaña STORY */
    /* Estilos específicos para la pestaña STORY */
}
#home-tab.active {
    /* Estilos específicos para la pestaña STORY cuando está activa */
}

#profile-tab { /* Pestaña GALLERY */
    /* Estilos específicos para la pestaña GALLERY */
}
#profile-tab.active {
    /* Estilos específicos para la pestaña GALLERY cuando está activa */
}

#contact-tab { /* Pestaña REPORTS */
    /* Estilos específicos para la pestaña REPORTS */
}
#contact-tab.active {
    /* Estilos específicos para la pestaña REPORTS cuando está activa */
}

/* Personalizar el color del texto y fondo del contenido de cada pestaña si es necesario */
#myTabContent #home {
    /* background-color: #f0f0f0; */
    /* color: #333; */
}
#myTabContent #profile {
    /* background-color: #e9f7fd; */
    /* color: #1c5a7d; */
}
#myTabContent #contact {
    /* background-color: #fde9e9; */
    /* color: #7d1c1c; */
}

/* CARDS */

.news-card{
    width: 49%
}

.news-card .card-title-position h4{
    width: 100%;
}

@media (max-width: 1000px){
    .right-aside-section .nav-tabs .nav-link {
        padding: 0.5rem 1rem 1rem 1rem;
    }
}

@media (max-width: 767.98px) {
    .right-aside-section .info-container h1{
        /* font-size: 1.25rem; */
        line-height: 1.1;
        padding: 1rem 1rem;
    }
}

@media (max-width: 572px) {
     .right-aside-section .nav-tabs .nav-link{
        padding: 0.2rem 0.4rem;
    }
}

/* BOTTOM FOOT */


.left-right-image{
}

.left-text{
    background-color: #FC6768;
    padding: 2rem;
}

@media (max-width: 822px) {
    .left-text{
        padding: 1.5rem;
    }
}
.left-text h3{
    color: #FFF0A1;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.left-text span{
    color: #fff;
    font-size: 1.8rem;
    margin-bottom: 1rem;
}

.left-right-image .white-btn{
    padding: 0.5rem 0.7rem;
    font-size: 0.8rem;
}

.left-right-image .right-image{
    padding: 0;
}

.left-right-image .right-image img{
    width: 100%;
    height: 100%;
}

/* MOBILE */

.left-right-image-mobile .left-text{
    padding: 2rem 0;
    gap: 1rem;
    background-color: #D94647;
}

.left-right-image-mobile .left-text .white-btn{
    padding: 0.5rem 2rem;

}

/* Contenedor Principal */
.image-gallery-container {
    display: flex;
    width: 100%; /* Ocupa el 100% del ancho de su contenedor padre */
    gap: 15px; /* Espacio entre la columna izquierda y derecha */
    box-sizing: border-box;
    background-color: #fff; /* Fondo blanco */
}

.image-gallery-container img{
    border-radius: 5px;
}

/* Columna Izquierda (Imagen Principal e Información) */
.gallery-column-left {
    display: flex;
    flex-direction: column;
}

.main-image-wrapper {
    width: 100%;
    margin-bottom: 10px; /* Espacio entre la imagen principal y la info */
}

.main-image {
    width: 100%;
    height: auto; /* Mantiene la proporción, o puedes fijar una altura y usar object-fit */
    max-height: 450px; /* Límite para que no sea demasiado alta, ajustar según necesidad */
    object-fit: cover; /* Asegura que la imagen cubra el espacio sin distorsionarse */
    display: block; /* Elimina espacio extra debajo de la imagen */
    border: 1px solid #eee; /* Borde sutil para la imagen */
}

.new-info-text {
    display: flex;
    align-items: center;
    gap: 15px; /* Espacio entre la fecha y el "Posted by" */
    font-size: 0.85rem;
    color: #555;
    padding-top: 5px;
}

.new-info-text .posted-by {
    display: flex;
    align-items: center;
}

.author-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%; /* Hace el avatar circular */
    margin-right: 8px;
    margin-left: 5px; /* Espacio después de "Posted by" */
    border: 1px solid #ddd;
}

/* Columna Derecha (Miniaturas y Enlace) */
.gallery-column-right {
    flex: 0 0 35%; /* La columna derecha ocupa el 35% del espacio disponible */
    display: flex;
    flex-direction: column;
    gap: 10px; /* Espacio entre las miniaturas y el enlace */
}

.thumbnail-image-wrapper {
    width: 100%;
}

.thumbnail-image {
    width: 100%;
    height: auto; /* Mantiene la proporción, o puedes fijar una altura y usar object-fit */
    max-height: 120px; /* Altura máxima para las miniaturas, ajustar */
    object-fit: cover;
    display: block;
    border: 1px solid #eee; /* Borde sutil para las miniaturas */
}

.see-all-photos-link {
    display: inline-block; /* Para que el padding y text-align funcionen */
    text-align: right;
    color: #d9534f; /* Color rojizo/anaranjado similar a la imagen */
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    padding-top: 5px; /* Espacio sobre el enlace */
}

.see-all-photos-link:hover {
    text-decoration: underline;
}

/* Ajustes Responsivos (Opcional, pero recomendado) */
@media (max-width: 768px) {
    .image-gallery-container {
        flex-direction: column; /* Apila las columnas en pantallas pequeñas */
        gap: 20px; /* Ajusta el espacio cuando se apilan */
    }

    .gallery-column-left,
    .gallery-column-right {
        flex-basis: auto; /* Permite que las columnas tomen el ancho completo */
        width: 100%;
    }

    .gallery-column-right {
        flex-direction: row; /* Coloca las miniaturas en fila en móvil */
        flex-wrap: wrap; /* Permite que se ajusten si no caben */
        justify-content: space-between; /* Distribuye las miniaturas */
    }

    .thumbnail-image-wrapper {
        width: calc(33.333% - 7px); /* Para 3 miniaturas en fila con gap de 10px */
        margin-bottom: 10px; /* Espacio si se envuelven a la siguiente línea */
    }
    .thumbnail-image{
        max-height: 100px;
    }

    .see-all-photos-link {
        width: 100%; /* Ocupa todo el ancho disponible bajo las miniaturas */
        text-align: center; /* Centra el enlace en móvil */
        margin-top: 10px;
    }
    .new-info-text {
        font-size: 0.8rem; /* Ligeramente más pequeño en móvil */
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .thumbnail-image-wrapper {
         width: calc(50% - 5px); /* Para 2 miniaturas en fila en pantallas muy pequeñas */
    }
     .new-info-text span {
        display: block; /* Apila fecha y autor en pantallas muy pequeñas */
        width: 100%;
        margin-bottom: 5px;
    }
    .new-info-text .posted-by {
        justify-content: flex-start;
    }
     .new-info-text {
        gap: 5px;
    }
}

.info-container h1{
    padding-right: 70px !important;
}
    </style>
@endpush