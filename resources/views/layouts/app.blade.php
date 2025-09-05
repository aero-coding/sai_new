<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        // Esta lógica inteligente detecta el modelo actual y extrae los datos SEO
        $currentModelInstance = $page ?? $project ?? $report ?? null;
        $currentLocale = $locale ?? app()->getLocale();

        // Define los valores por defecto para tu sitio
        $defaultSiteName = config('app.name', 'Your Site Name');
        $defaultDescription = 'A great description for your website.';
        $defaultOgImage = asset('images/default_social_image.jpg'); // ¡IMPORTANTE! Crea esta imagen por defecto en public/images/

        // Inicializa las variables con los valores por defecto
        $seoTitle = $defaultSiteName;
        $metaDescription = $defaultDescription;
        $ogTitle = $defaultSiteName;
        $ogDescription = $defaultDescription;
        $ogImage = $defaultOgImage;
        $canonicalUrl = url()->current();

        // Si estamos en una página de un modelo (Page, Project, Report)
        if ($currentModelInstance) {
            $modelMeta = $currentModelInstance->getTranslation('meta', $currentLocale, true) ?? [];
            $modelTitle = $currentModelInstance->getTranslation('title', $currentLocale, true);
            $modelExcerpt = $currentModelInstance->getTranslation('excerpt', $currentLocale, true);

            $featuredImageUrl = null;
            if (method_exists($currentModelInstance, 'hasMedia') && $currentModelInstance->hasMedia('featured_image')) {
                $featuredImageUrl = $currentModelInstance->getFirstMediaUrl('featured_image', 'optimized');
            }

            // Asigna los valores SEO, usando los del modelo si existen
            $seoTitle = $modelMeta['seo_title'] ?? ($modelTitle . ' | ' . $defaultSiteName);
            $metaDescription = $modelMeta['seo_description'] ?? $modelExcerpt ?? $defaultDescription;

            $ogTitle = $modelMeta['og_title'] ?? $seoTitle;
            $ogDescription = $modelMeta['og_description'] ?? $metaDescription;
            $ogImage = $modelMeta['og_image'] ?? $featuredImageUrl ?? $defaultOgImage;
        }
    @endphp

    <meta name="description" content="{{ Str::limit(strip_tags($metaDescription), 160) }}">
    <link rel="canonical" href="{{ $canonicalUrl }}" />

    <meta property="og:type" content="{{ $currentModelInstance ? 'article' : 'website' }}" />
    <meta property="og:site_name" content="{{ $defaultSiteName }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($ogDescription), 200) }}">
    <meta property="og:image" content="{{ $ogImage }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($ogDescription), 200) }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="stylesheet preload prefetch" as="style"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> --}}
    
    <title>@yield('title', 'Mi App Laravel')</title>
    <link rel="icon" href="{{ asset('assets/img/favicons/favicon_transparent.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicons/favicon_transparent.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="">
        {{-- HEADER MOBILE --}}
        <div class="mobile-header container-fluid px-0 d-flex d-lg-none justify-content-between align-items-center">
            <div class="header-logo-container clipped-container-stripes d-flex ">
                <a href=""><img src="{{ asset('logo.png') }}" alt=""></a>
            </div>
            <button class="navbar-toggler d-lg-none" type="button" id="mobileMenuToggle" aria-controls="mobileNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i> </button>
        </div>
        {{-- HEADER DESKTOP --}}
        <div class="desktop-header w-100 row justify-content-center d-lg-flex d-none">
            <div class="desktop-header-container col-10 row px-0">
                <div class="desktop-header-left col-2">
                    <div class="header-logo-container clipped-container-stripes">
                        {{-- El logo ahora apunta a la ruta de inicio --}}
                        <a href="{{ route('pages.home') }}">
                            <img src="{{ asset('logo.png') }}" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="desktop-header-right col-10 px-0">
                    <div class="desktop-top d-flex align-items-center justify-content-end px-4">
        
                        <div class="desktop-top-info">
                            Email: 
                            <span>
                                <a href="mailto:Donate@Sai.ngo">Donate@Sai.ngo</a>
                            </span>
                        </div>
                    
                        <div class="desktop-top-info">
                            Call Us: <a href="tel:+18005636099">(800)-563-6099</a>
                        </div>
                    
                        <div class="desktop-top-info">
                            <a href="https://wa.me/18005636099?text=Hello" target="_blank">Whatsapp ></a>
                        </div>
                    
                    </div>
                    
                    <nav class="desktop-bottom d-flex justify-content-end align-items-center px-4">
                        <ul class="navbar-nav d-flex flex-row align-items-center">
                            <li class="nav-item">
                                {{-- Ruta para la página de inicio localizada --}}
                                <a class="nav-link" href="{{ route('home.localized', ['locale' => app()->getLocale()]) }}">HOME</a>
                            </li>
                            <li class="nav-item">
                                {{-- Asumiendo que 'about' es un slug de una página dinámica --}}
                                <a class="nav-link" href="{{ route('page.show.localized', ['locale' => app()->getLocale(), 'page_slug' => 'about-us']) }}">ABOUT US</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="campaignsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    CAMPAIGNS
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="campaignsDropdown">
                                    
                                    @foreach($recentProjects as $project)
                                        <li><a class="dropdown-item" href="{{ route('projects.show.localized', ['locale' => app()->getLocale(), 'project_slug' => $project->slug]) }}">{{ $project->title }}</a></li>
                                    @endforeach
                                   
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    {{-- El enlace "Ver Todas" ahora es "Explore" y apunta a la ruta correcta --}}
                                    <li><a class="dropdown-item" href="{{ route('explore.localized', ['locale' => app()->getLocale()]) }}">Explore</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                {{-- Ruta para las noticias localizadas --}}
                                <a class="nav-link" href="{{ route('news.localized', ['locale' => app()->getLocale()]) }}">NEWS</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="helpMoreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    HELP MORE
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="helpMoreDropdown">
                                    {{-- Asumiendo que 'help' es un slug de una página dinámica --}}
                                    <li><a class="dropdown-item" href="{{ route('page.show.localized', ['locale' => app()->getLocale(), 'page_slug' => 'help']) }}">Get Involved</a></li>
                                    <li><a class="dropdown-item" href="#">Volunteer</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                {{-- Asumiendo que 'contact' es un slug de una página dinámica --}}
                                <a class="nav-link" href="{{ route('page.show.localized', ['locale' => app()->getLocale(), 'page_slug' => 'contact']) }}">CONTACT US</a>
                            </li>
                        </ul>
                    
                        {{-- El botón de donar ahora apunta a la ruta de donación --}}
                        <a href="{{ route('donate') }}" class="d-none d-md-block btn white-btn ms-4">DONATE ></a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="colophon" class="red-top-shadow container-fluid text-white site-footer bt-footer d-flex ">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0 footer-left d-flex">
                    <a href="/" class="footer-logo">
                        <img style="height:50px;width:100px" src="{{ asset('logo.png') }}"
                            alt="">
                    </a>

                    <div class="certf-container">
                        <h4>OUR CERTIFICATIONS</h4>
                        <div class="globalgiv-logo-footer">

                        
                                        <p><a
                                                href="https://www.globalgiving.org/donate/42484/south-american-initiative/"><img
                                                    src="{{asset('cUYvmGj2EHD23zQcZrtZ.png')}}" class="alignnone lazyload"
                                                    style="max-width: 100%; width: 145px; margin-top: 0px;"
                                                    data-original=""
                                                    alt="#"></a></p>
                                        <p><a href="https://greatnonprofits.org/organizations/view/south-american-initiative-inc/page:2"><img class="alignnone lazyload"
                                                    style="max-width: 100%; width: 185px; margin-top: 0px;"
                                                    src="{{asset('hsBYVJfwPf1zZWsOzyO3.png')}}"
                                                    data-original=""
                                                    alt="#"></a></p>
                                        <p><a href="https://www.guidestar.org/profile/81-1747993"><img
                                                    class="alignnone lazyload"
                                                    style="max-width: 100%; width: 145px; margin-top: 0px;"
                                                    src="{{asset('f6vpB1W3kAdQSqddpqTH.png')}}"
                                                    data-original=""
                                                    alt="#"></a></p>
                                        <p><a href="https://www.globalgiving.org/learn/introducing-gg-rewards/"><img
                                                    class="alignnone lazyload"
                                                    style="max-width: 100%; width: 145px; margin-top: 0px;"
                                                    src="{{asset('46qJ2JdlEPCA3sbEUihr.png')}}"
                                                    data-original=""
                                                    alt="#"></a></p>
                        </div>
                    </div>

                    <p class="about-footer">South American Initiative is a 501(c)(3) charitable
                                            organization, EIN 81-1747993. All the contributions are tax deductible to
                                            the extent permitted by law. No goods or services will be provided in
                                            exchange for the contribution.</p>

                </div>
                <div class="col-md-6 footer-right d-flex">
                    <div class="footer-right-col">
                        <h5>WEBSITE</h5>
                        <a href="">Home</a>
                        <a href="">About Us</a>
                        <a href="">Explore Campaigns ></a>
                    </div>
                    <div class="footer-right-col">
                        <a class="footer-email">
                            <span>Email Address</span>
                            <p>Donate</p>
                        </a>
                        <a class="footer-telephone">
                            <span>Telephone</span>
                            <p>800-563-6099</p>
                        </a>
                    </div>
                    <div class="footer-right-col">
                        <a class="footer-address">
                            <span>Adress</span>
                            <p>8211 W Broward Blvd Ste 410 Plantation, FL 33324 United States of America</p>
                        </a>
                        <a class="footer-social">
                            <span>Social Media Channels</span>
                            <p>Example Text</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    {{-- MODAL IMAGE --}}
    <div id="imageModal" class="image-modal">
        <span class="close-modal-btn">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption" class="modal-caption"></div>
    </div>

    {{-- MENU OFFCANVAS --}}

    <nav id="mobileNav" class="offcanvas-menu">
        <button class="close-menu-btn" aria-label="Close Menu">&times;</button>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Campaigns</a></li>
            <li><a href="#">News</a></li>
            <li><a href="#">Help More</a></li>
            <li><a href="#" class="donate-link">Donate ></a></li>
        </ul>
    </nav>
    <div class="offcanvas-overlay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Obtener el modal
    var modal = document.getElementById("imageModal");

    // Obtener el elemento <img> que se usará para mostrar la imagen en el modal
    var modalImg = document.getElementById("modalImage");

    // Obtener el elemento para la leyenda (caption)
    var captionText = document.getElementById("caption");

    // Obtener todas las imágenes con la clase 'zoomable-image'
    var images = document.querySelectorAll(".zoomable-image");

    // Recorrer todas las imágenes y añadir el evento de click
    images.forEach(function(img) {
        img.onclick = function() {
            modal.style.display = "flex"; // Cambiado a flex para centrar
            modal.classList.add('show'); // Para la transición de opacidad
            modalImg.src = this.src; // Usar la URL de la imagen clickeada
            if (this.alt) {
                captionText.innerHTML = this.alt; // Usar el 'alt' como leyenda
                captionText.style.display = "block";
            } else {
                captionText.style.display = "none";
            }
        }
    });

    // Obtener el elemento <span> que cierra el modal
    var span = document.getElementsByClassName("close-modal-btn")[0];

    // Cuando el usuario hace click en <span> (x), cerrar el modal
    if (span) {
        span.onclick = function() {
            closeModal();
        }
    }

    // Cuando el usuario hace click fuera de la imagen en el modal, cerrarlo
    modal.onclick = function(event) {
        // Verificar que el click fue en el fondo del modal y no en la imagen misma
        if (event.target === modal) {
            closeModal();
        }
    }

    // Función para cerrar el modal
    function closeModal() {
        modal.classList.remove('show');
        // Esperar a que termine la transición de opacidad antes de ocultar con display: none
        setTimeout(function() {
            modal.style.display = "none";
        }, 300); // Debe coincidir con la duración de la transición en CSS
    }

    // Opcional: Cerrar el modal con la tecla Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape" && modal.style.display === "flex") {
            closeModal();
        }
    });
});
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

const menuToggle = document.getElementById('mobileMenuToggle');
const mobileMenu = document.getElementById('mobileNav');
const overlay = document.querySelector('.offcanvas-overlay');
const closeButton = mobileMenu.querySelector('.close-menu-btn');
const body = document.body;

// Función para abrir el menú
function openMenu() {
    mobileMenu.classList.add('is-open');
    overlay.classList.add('is-open');
    body.classList.add('offcanvas-open'); // Bloquear scroll del body
    menuToggle.setAttribute('aria-expanded', 'true');
    
}

// Función para cerrar el menú
function closeMenu() {
    mobileMenu.classList.remove('is-open');
    overlay.classList.remove('is-open');
    body.classList.remove('offcanvas-open'); // Desbloquear scroll
    menuToggle.setAttribute('aria-expanded', 'false');
}

// Event Listener para el botón Toggler (Hamburguesa)
if (menuToggle) {
    menuToggle.addEventListener('click', function() {
        if (mobileMenu.classList.contains('is-open')) {
            closeMenu();
        } else {
        
            openMenu();
        }
    });
}

// Event Listener para el botón de cierre dentro del menú
if (closeButton) {
    closeButton.addEventListener('click', closeMenu);
}

// Event Listener para el overlay (cerrar al hacer clic fuera)
if (overlay) {
    overlay.addEventListener('click', closeMenu);
}

// Opcional: Cerrar el menú con la tecla Escape
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape" && mobileMenu.classList.contains('is-open')) {
        closeMenu();
    }
});

// Opcional: Cerrar el menú si se hace clic en un enlace (para SPAs o anclas)
// mobileMenu.querySelectorAll('a').forEach(link => {
//     link.addEventListener('click', closeMenu);
// });

});
    </script>
    @stack('scripts')
</div>
</body>
</html>