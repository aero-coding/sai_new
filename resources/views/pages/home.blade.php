@php
    $currentLocale = app()->getLocale();
    $content = $page->getTranslation('content', $currentLocale, useFallbackLocale: true) ?? [];
@endphp

@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-THKN4PW"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <section id="carouselExampleControls" class="carousel slide flare-container" data-ride="carousel">
            <div class="hero-main-text d-flex align-items-center">
                <div class="hero-text-container row justify-content-center">
                    <div class="hero-text-main col-12 col-md-8 d-flex flex-column justify-content-center align-items-start">
                        <section class="title-section d-flex flex-column" style="background-image: url('{{ asset('south-america.png') }}');">
                            <h1>{{ $content['h1_title'] ?? '' }}</h1>
                            <p class="d-none d-sm-inline">{{ $content['hero_text'] ?? '' }}</p>
                            <a href="" class="d-none d-sm-inline white-btn">
                                <span>DONATE VENEZUELAN ORPHANS ></span>
                            </a>
                            <span class="aux-text">> Certified Donation Partner for US Tax Deductions</span>
                        </section>
                    </div>
                </div>
            </div>
            <div class="hero-main-text d-flex align-items-center">
                <!-- ... contenido existente ... -->
            </div>
            <div class="carousel-inner">
                @foreach($carouselProjects as $key => $project)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <a href="{{ route('projects.show.localized', [
                        'locale' => app()->getLocale(),
                        'project_slug' => $project->getTranslation('slug', app()->getLocale())
                    ]) }}">
                        @if($project->hasMedia('featured_image'))
                            <img class="d-block w-100" 
                                 src="{{ $project->getFirstMediaUrl('featured_image', 'optimized') }}" 
                                 alt="{{ $project->getTranslation('title', app()->getLocale()) }}">
                        @else
                            <img class="d-block" src="{{ asset('placeholder.jpg') }}" alt="Default project image">
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
            <div class="hero-carousel-btns d-none d-md-flex">
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only"></span>
                </a>
                <span>EXPLORE CAMPAIGNS</span>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only"></span>
                </a>
            </div>
        </section>
        <section class="help-others container-fluid row d-flex">
            <div class="col-md-10 col-xs-12 mx-auto cards-position .p-0">
                <div class="help-cards-container d-flex">
                    <h2 class="text-uppercase">{{ $content['help_subtitle'] ?? '' }}</h2>
                    <h3>{{ $content['help_text'] ?? '' }}</h3>
                    @foreach($projectCards as $project)
                        <div class="help-cards">
                            <div class="card-top">
                                @if($project->hasMedia('featured_image'))
                                    <img src="{{ $project->getFirstMediaUrl('featured_image', 'optimized') }}" 
                                        alt="{{ $project->getTranslation('title', app()->getLocale()) }}">
                                @else
                                    <img src="{{ asset('placeholder.jpg') }}" alt="Default project image">
                                @endif
                                <div class="card-title-position">
                                    <h4>{{ $project->getTranslation('title', app()->getLocale()) }}</h4>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <div class="card-bottom-container">
                                    @php
                                    $excerpt = strip_tags($project->getTranslation('excerpt', app()->getLocale()));
                                    @endphp

                                
                                    <p>{{ \Illuminate\Support\Str::words($excerpt, 30, '…') }}</p>
                                    <a href="{{ route('projects.show.localized', [
                                        'locale' => app()->getLocale(),
                                        'project_slug' => $project->getTranslation('slug', app()->getLocale())
                                    ]) }}" class="white-btn">
                                        <span>DONATE ></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <a href="" class="d-inline d-md-none" style="color: #FFF0A1; margin-bottom: 20px;">Explore all</a>
                </div>
            </div>
        </section>
    
        <section class="section-sponsors">
            <div class="section-sponsors-container">
                <h2 class="text-uppercase">{{ $content['sponsors_title'] ?? '' }}</h2>
                <div class="sponsors" >
                    <div class="sponsor-item"><img class="globalgiving"  src="{{ asset('assets/img/global/logos/globalgivinglogo.png') }}"alt=""></div>
                    <div class="sponsor-item"><img class="google"  src="{{ asset('assets/img/global/logos/googlelogo.png') }}"alt=""></div>
                    <div class="sponsor-item"><img class="benevity"  src="{{ asset('assets/img/global/logos/benevitylogo.png') }}"alt=""></div>
                    <div class="sponsor-item"><img class="animalfund" src="{{ asset('assets/img/global/logos/animalfundlogo.png') }}"alt=""></div>
                    <div class="sponsor-item"><img class="microsoft"  src="{{ asset('assets/img/global/logos/microsoftlogo.png') }}"alt=""></div>
                </div>
            </div>
        </section>
        <section class="section section-about">
            <div class="container-fluid px-0">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-9"> 
                        <div class="row align-items-center">
                            <div class="col-md-7 about-text-content">
                                <h3 class="text-uppercase">{{ $content['about_mini_title'] ?? '' }}</h3>
                                <h2 class="text-uppercase">{{ $content['about_subtitle'] ?? '' }}</h2>
                                <p>{{ $content['about_text_1'] ?? '' }}</p>
                                <p>{{ $content['about_text_2'] ?? '' }}</p>
                                <a href="#" class="btn-discover mt-3">
                                    DISCOVER MORE &gt; </a>
                            </div>
    
                            <div class="col-md-5 about-image-col">
                                 <img src="{{asset('pets28.jpg')}}"
                                     alt="Imagen descriptiva sobre nosotros"
                                     class="about-image">
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </section>
        <section class="section section-values">
                <div class="values-center container-fluid row justify-content-center">
                    <div class="values-container col-12 col-md-9 d-flex">
                        <h2 class="text-uppercase">{{ $content['values_title'] ?? '' }}</h2>
                    <div class="values-card">
                        <div class="card-top">
                            <img src="{{asset('0l5FxnvZgFaGL2nFN8Jr.jpg')}}" alt="">
                        </div>
                        <div class="card-bottom">
                            <div class="card-bottom-container">
                                <h3 class="text-uppercase">{{ $content['values_card_1_title'] ?? '' }}</h3>
                                <p>{{ $content['values_card_1_text'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="values-card">
                        <div class="card-top">
                            <img src="{{asset('BJlZi85SjQDJl7oNjrAQ.jpg')}}" alt="">
                        </div>
                        <div class="card-bottom">
                            <div class="card-bottom-container">
                                <h3 class="text-uppercase">{{ $content['values_card_2_title'] ?? '' }}</h3>
                                <p>{{ $content['values_card_2_text'] ?? '' }}</p>

                            </div>
                        </div>
                    </div>
                    <div class="values-card">
                        <div class="card-top">
                            <img src="{{asset('f6vpB1W3kAdQSqddpqTH.png')}}" alt="">
                        </div>
                        <div class="card-bottom">
                            <div class="card-bottom-container">
                                <h3 class="text-uppercase">{{ $content['values_card_3_title'] ?? '' }}</h3>
                                <p>{{ $content['values_card_3_text'] ?? '' }}</p>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
        </section>
        <section class="section section-certifications d-flex">
            <div class="section-certifications-container">
                <h2 class="text-uppercase">{{ $content['certifications_title'] ?? '' }}</h2> 
                <div class="certifications">
                    <a href="https://www.globalgiving.org/donate/42484/south-american-initiative/" class="certification-item"><img class="vargas" src="{{asset('cUYvmGj2EHD23zQcZrtZ.png')}}" alt=""></a>
                    <a href="https://greatnonprofits.org/organizations/view/south-american-initiative-inc/page:2" class="certification-item"><img class="globalgiving" src="{{asset('hsBYVJfwPf1zZWsOzyO3.png')}}" alt=""></a>
                    <a href="https://www.guidestar.org/profile/81-1747993" class="certification-item"><img class="google" src="{{asset('f6vpB1W3kAdQSqddpqTH.png')}}" alt=""></a>
                    <a href="https://www.globalgiving.org/learn/introducing-gg-rewards" class="certification-item"><img class="benevity" src="{{asset('46qJ2JdlEPCA3sbEUihr.png')}}" alt=""></a>
                </div>
            </div>
        </section>
        <section class="section section-news row" style="background-image: url('{{ asset('south-america.png') }}');">
            <div class="news-text col-12 col-md-9">
                <h2>{{ $content['news_title'] ?? '' }}</h2>
                <div class="news-text-right">
                    <p>{{ $content['news_side_text'] ?? '' }}</p>
                    <a href="">{{ $content['news_link'] ?? '' }}</a>
                </div>
            </div>
            <div class="news-cards-col col-12 col-md-9">
                <div class="news-cards-container">
                    @foreach($reportCards as $report)
                        <div class="news-card help-cards">
                            <div class="card-top">
                                @if($report->hasMedia('featured_image'))
                                    <img src="{{ $report->getFirstMediaUrl('featured_image', 'optimized') }}" 
                                        alt="{{ $report->getTranslation('title', app()->getLocale()) }}">
                                @else
                                    <img src="{{ asset('placeholder.jpg') }}" alt="Default report image">
                                @endif
                                <div class="card-title-position">
                                    <h4 class="{{ $loop->index % 4 == 0 ? 'blue-cl' : ($loop->index % 4 == 1 || $loop->index % 4 == 2 ? 'yellow-cl' : 'red-cl') }}">
                                        {{ $report->getTranslation('title', app()->getLocale()) }}
                                    </h4>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <div class="card-bottom-container">
                                    <p class="news-card-text">
                                        {{ $report->getTranslation('excerpt', app()->getLocale()) }}
                                    </p>
                                    <div class="new-info d-flex flex-column align-items-start">
                                        <div class="new-info-text">
                                            <span>{{ $report->published_at->format('d M Y') }}</span>
                                            <span>Posted by {{ $report->creator->name ?? 'Admin' }}</span>
                                        </div>
                                        <a href="{{ route('report.show.localized', [
                                            'locale' => app()->getLocale(),
                                            'report_slug' => $report->getTranslation('slug', app()->getLocale())
                                        ]) }}" class="new-info-btn">
                                            <span>READ MORE ></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section section-testimonials">
            <div class="testimonials-top">
                <div class="testimonials-right">
                    <h2>{{ $content['testimonials_mini_title'] ?? '' }}</h2>
                    <h3>{{ $content['testimonials_title'] ?? '' }}</h3>
                </div>
                <div class="testimonials-left">
                    <p>{{ $content['testimonials_side_text'] ?? '' }}</p>
                </div>
            </div>
            <div class="carousel">
                <div class="carousel-track">
                    <div class="carousel-item active carousel-card">
                        <div class="carousel-card-left">
                            <div class="carousel-profile">
                                <img src="{{asset('IMG_20240812_103453_109.jpg')}}" alt="Profile picture">
                                <span>Botas</span>
                            </div>
                            <p class="carousel-comment">{{ $content['testimonials_card_1_text'] ?? '' }}</p>
                            <a href="#" class="about-discover-btn">DONATE TO THIS CAMPAIGN &gt;</a>
                        </div>
                        <div class="carousel-card-right">
                            <img src="{{asset('IMG_20240812_103453_109.jpg')}}" alt="Testimonial Image 1">
                        </div>
                    </div>
                    <div class="carousel-item carousel-card">
                        <div class="carousel-card-left">
                            <div class="carousel-profile">
                                <img src="{{asset('proteccionistas.jpg')}}" alt="Profile picture">
                                <span>Proteccionistas UC</span>
                            </div>
                            <p class="carousel-comment">{{ $content['testimonials_card_2_text'] ?? '' }}</p>
                            <a href="#" class="about-discover-btn">LEARN MORE &gt;</a>
                        </div>
                        <div class="carousel-card-right">
                            <img src="{{asset('20220913_1737000.jpg')}}" alt="Testimonial Image 2">
                        </div>
                    </div>
                    <div class="carousel-item carousel-card">
                        <div class="carousel-card-left">
                            <div class="carousel-profile">
                                <img src="{{asset('example.jpg')}}" alt="Profile picture">
                                <span>Luis tortolero</span>
                            </div>
                            <p class="carousel-comment">{{ $content['testimonials_card_3_text'] ?? '' }}</p>
                            <a href="#" class="about-discover-btn">SEE RESULTS &gt;</a>
                        </div>
                        <div class="carousel-card-right">
                            <img src="{{asset('sz4HHWxvvwQAuxZKn1Rw.jpg')}}" alt="Testimonial Image 3">
                        </div>
                    </div>
                    </div>
                <div class="carousel-btns">
                    <button class="prev-carousel">&#10094;</button>
                    <span>READ REVIEWS</span>
                    <button class="next-carousel">&#10095;</button>
                </div>
            </div>
        </section>
    
        <section class="section section-numbers row justify-content-center">
            <div class="numbers-container col-12 col-md-9">
                <h2 class="text-uppercase clipped-container-stripes"><p class="carousel-comment">{{ $content['numbers_title'] ?? '' }}</p></h2>
                <div class="numbers-cards-container px-0 px-md-auto " >
                    <p class="px-3 ps-sm-5">{{ $content['numbers_text'] ?? '' }}</p>
                    <div class="numbers" >
                        <div class="numbers-card">
                            <div class="icon"><span>ICON</span></div>
                            <span class="card-number">{{ $content['numbers_of_people_helped'] ?? '' }}</span>
                            <div class="card-title-container"><span class="card-title">People Helped</span></div>
                        </div>
                        <div class="numbers-card">
                            <div class="icon"><span>ICON</span></div>
                            <span class="card-number">{{ $content['numbers_of_volunteers'] ?? '' }}</span>
                            <div class="card-title-container"><span class="card-title">Volunteers</span></div>
                        </div>
                        <div class="numbers-card">
                            <div class="icon"><span>ICON</span></div>
                            <span class="card-number">{{ $content['numbers_of_educated_children'] ?? '' }}</span>
                            <div class="card-title-container"><span class="card-title">Educated Children</span></div>
                        </div>
                        <div class="numbers-card">
                            <div class="icon"><span>ICON</span></div>
                            <span class="card-number">{{ $content['numbers_of_served_meal'] ?? '' }}</span>
                            <div class="card-title-container"><span class="card-title">Served Meal</span></div>
                        </div>
                    </div>
                </div>
                <a class="read-more" href="">Read More about us</a>
            </div>
        </section>
    
        <section class="section section-help row">
            <div class="help-container col-12 col-md-9">
                <div class="help-top">
                    <div class="help-top-left">
                        <h2 class="text-uppercase">{{ $content['call_to_action_title'] ?? '' }}</h2>
                        <h3 class="text-uppercase">{{ $content['call_to_action_text'] ?? '' }}</h3>
                        <a href="#" class="donate-btn d-none d-md-inline">DONATE &gt;</a>
                    </div>
                    <div class="help-top-right">
                        <img src="{{asset('example.jpg')}}" alt="">
                    </div>
                    <div class="help-top-left d-md-none">
                        <a href="#" class="donate-btn d-inline d-flex justify-content-center">DONATE &gt;</a>
                    </div>
                </div>
                <div class="help-bottom">
                    <div class="contacs-cards">
                        <h4 class="text-uppercase">{{ $content['call_to_action_card_1_title'] ?? '' }}</h4>
                        <p>{{ $content['call_to_action_card_1_text'] ?? '' }}</p>
                        <a href="" class="about-discover-btn">CONTACT US  &gt;</a>
                    </div>
                    <div class="contacs-cards">
                        <h4 class="text-uppercase">{{ $content['call_to_action_card_2_title'] ?? '' }}</h4>
                        <p>{{ $content['call_to_action_card_2_text'] ?? '' }}</p>
                        <a href="" class="about-discover-btn">CONTACT US  &gt;</a>
                    </div>
                    <div class="contacs-cards">
                        <h4 class="text-uppercase">{{ $content['call_to_action_card_3_title'] ?? '' }}</h4>
                        <p>{{ $content['call_to_action_card_3_text'] ?? '' }}</p>
                        <a href="" class="about-discover-btn">CONTACT US  &gt;</a>
                </div>
            </div>
        </section>
        <section class="section section-subscribe row">
            <div class="subscribe-container col-12 col-md-9 px-0">
                <div class="subscribe-top">
                    <div class="subscribe-logo d-none d-md-block"><img src="{{asset('logo.png')}}" alt="">
                    </div>
                    <div class="subscribe-text">
                        <h2 class="text-uppercase">Explore Fundarisings</h2>
                        <h3 class="text-uppercase">Subscribe to Our Newsletter To Stay Updated</h3>
                    </div>
                    <div class="subscribe-form">
                        <input type="email" placeholder="Insert Your best email">
                        <button class="d-none d-md-inline subscribe-form-btn">Send Email ></button>
                    </div>
                        <button class="d-inline d-md-none subscribe-form-btn">Send Email ></button>
    
                </div>
                <div class="social-contact-section w-100 py-3">
                <div class="row align-items-center">
    
                    <div class="col-12 col-md-5 col-lg-4 pe-md-3">
                        <div class="social-column social-left d-flex align-items-center gap-2 justify-content-center justify-content-md-start">
                            <a href="https://wa.me/TUNUMERODEWHATSAPP" target="_blank" class="social-icon whatsapp-icon d-flex align-items-center justify-content-center" aria-label="Contactar por WhatsApp">
                                <i class="fab fa-whatsapp"></i> </a>
                            <a href="https://wa.me/TUNUMERODEWHATSAPP" target="_blank" class="contact-link text-decoration-none">
                                CONTACT US ON WHATSAPP &gt;
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-7 mt-3 mt-md-0 ps-md-3">
                        <div class="social-column social-right d-flex align-items-center flex-wrap gap-3 justify-content-center justify-content-md-start">
                            <div class="d-flex gap-2">
                                <a href="#" class="social-icon social-placeholder color-1 d-flex align-items-center justify-content-center" aria-label="Red Social 1">
                                    <i class="fab fa-facebook-f"></i> </a>
                                <a href="#" class="social-icon social-placeholder color-2 d-flex align-items-center justify-content-center" aria-label="Red Social 2">
                                    <i class="fab fa-twitter"></i> </a>
                                <a href="#" class="social-icon social-placeholder color-3 d-flex align-items-center justify-content-center" aria-label="Red Social 3">
                                    <i class="fab fa-instagram"></i> </a>
                                <a href="#" class="social-icon social-placeholder color-4 d-flex align-items-center justify-content-center" aria-label="Red Social 4">
                                    <i class="fab fa-linkedin-in"></i> </a>
                            </div>
                            <a href="#" class="contact-link text-decoration-none">
                                Follow us on our social media
                            </a>
                        </div>
                    </div>
    
                </div>
            </div>
            </div>
        </section>
        {{-- <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-chevron-up"></i></button> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
            integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
        </script>
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>-->
    
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
        </script>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"
            integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
        <script>
            let index = 0;
            const slides = document.querySelector('.slides');
            const totalSlides = document.querySelectorAll('.slide').length;
            
            function showSlide(i) {
                index = (i + totalSlides) % totalSlides;
                slides.style.transform = `translateX(-${index * 100}vw)`;
            }
            
            document.querySelector('.prev').addEventListener('click', () => showSlide(index - 1));
            document.querySelector('.next').addEventListener('click', () => showSlide(index + 1));
    
             const track = document.querySelector('.carousel-track');
            const $slides = Array.from(track.children);
            const prevButton = document.querySelector('.prev-carousel');
            const nextButton = document.querySelector('.next-carousel');
            let currentIndex = 0;
    
            function updateSlides() {
                $slides.forEach((slide, index) => {
                    slide.classList.remove('active');
                    if (index === currentIndex) {
                        slide.classList.add('active');
                    }
                });
                const offset = -currentIndex * 100;
                track.style.transform = `translateX(${offset}%)`;
            }
            
            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % $slides.length;
                updateSlides();
            });
            
            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + $slides.length) % $slides.length;
                updateSlides();
            });
        </script>
        <script>
                document.addEventListener('DOMContentLoaded', () => {
        // Selecciona los elementos relevantes solo DENTRO de la sección de testimonios
        const testimonialSection = document.querySelector('.section-testimonials');
    
        // Si no existe la sección, no ejecutes el script
        if (!testimonialSection) {
            console.warn("La sección de testimonios no fue encontrada. El carrusel no se inicializará.");
            return;
        }
    
        const track = testimonialSection.querySelector('.carousel-track');
        const prevButton = testimonialSection.querySelector('.prev-carousel');
        const nextButton = testimonialSection.querySelector('.next-carousel');
    
        // Verifica si todos los elementos necesarios existen
        if (!track || !prevButton || !nextButton) {
            console.error("Faltan elementos esenciales para el carrusel (track, prevButton o nextButton) dentro de .section-testimonials.");
            return;
        }
    
        const slides = Array.from(track.children);
    
        // Verifica si hay slides
        if (slides.length === 0) {
            console.warn("No se encontraron slides en el carrusel.");
            // Opcional: Ocultar botones si no hay slides o solo hay uno
            if (slides.length <= 1) {
               if(prevButton) prevButton.style.display = 'none';
               if(nextButton) nextButton.style.display = 'none';
               const readReviewsSpan = testimonialSection.querySelector('.carousel-btns span');
               if(readReviewsSpan) readReviewsSpan.style.display = 'none';
            }
            return; // No hagas nada más si no hay slides
        }
    
    
        let currentIndex = 0;
    
        // Función para actualizar la vista del carrusel
        function updateSlides() {
            // Mueve el track
            const offset = -currentIndex * 100;
            track.style.transform = `translateX(${offset}%)`;
    
            // Actualiza la clase 'active'
            slides.forEach((slide, index) => {
                if (index === currentIndex) {
                    slide.classList.add('active');
                } else {
                    slide.classList.remove('active');
                }
            });
        }
    
        // Event listener para el botón "siguiente"
        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            updateSlides();
        });
    
        // Event listener para el botón "anterior"
        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlides();
        });
    
        // Inicializa el carrusel mostrando el primer slide como activo
        updateSlides();
    
         // Opcional: Ocultar botones si solo hay un slide después de la inicialización
         if (slides.length <= 1) {
            prevButton.style.display = 'none';
            nextButton.style.display = 'none';
            const readReviewsSpan = testimonialSection.querySelector('.carousel-btns span');
            if(readReviewsSpan) readReviewsSpan.style.display = 'none';
         }
    });
        </script>
@endsection

@push('styles')
<style>

    .cards-position{
        margin-bottom: 4rem;
    }

    .help-others .help-cards:nth-of-type(1) {
        border-bottom: 15px solid #FFF0A1;
    }

    .help-others .help-cards:nth-of-type(2) {
            border-bottom: 15px solid #2261AA;
    }

    .help-others .help-cards:nth-of-type(3) {
            border-bottom: 15px solid #D94647;
    }

    .help-top-right{
        max-height: 350px
    }

    @media (max-width: 768px){
        .help-container{
            width: 100%;
        }
    }

    .news-cards-container .news-card:first-child {
        width: 62%;
    }

</style>
@endpush