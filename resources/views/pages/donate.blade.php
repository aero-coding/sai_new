@php
    $currentLocale = app()->getLocale();
    $content = $page->getTranslation('content', $currentLocale, useFallbackLocale: true) ?? [];
@endphp

@extends('layouts.app')

@section('title', 'Donate')

@section('content')
    <section class="donor-advised section row justify-content-center">
        <div class="advised-left col-12 col-md-6 d-flex flex-column">
            <div class="advised-title-container">
                <h1><span>{{ $content['h1_color_title'] ?? '' }}</span>{{ $content['h1_rest_title'] ?? '' }}</h1>
            </div>
            <div class="advised-text d-flex flex-column">
                <p>{{ $content['paragraph_1'] ?? '' }}</p>
                <div>
                <h3>{{ $content['text_title_1'] ?? '' }}</h3>
                <p>{{ $content['paragraph_2'] ?? '' }}</p>
                <p>{{ $content['paragraph_3'] ?? '' }}</p>
                <p>{{ $content['paragraph_4'] ?? '' }}<p>
                </div>
                <div>
                <h3>{{ $content['text_title_2'] ?? '' }}</h3>
                <p>{{ $content['paragraph_5'] ?? '' }}</p>
                <p>{{ $content['paragraph_6'] ?? '' }}</p>
                </div>
                <div>
                <h3>{{ $content['text_title_3'] ?? '' }}</h3>
                <p>{{ $content['paragraph_7'] ?? '' }}</p>
                </div>
            </div>
        </div>
        <div class="advised-right col-3  d-none d-md-block">

        </div>
    </section>
    <section class="section section-subscribe row">
        <div class="subscribe-container col-12 col-md-9 px-0">
            <div class="subscribe-top">
                <div class="subscribe-logo d-none d-md-block"><img src="{{asset('example.jpg')}}" alt="">
                </div>
                <div class="subscribe-text">
                    <h2>EXPLORE FUNDARISINGS</h2>
                    <h3>SUBSCRIBE TO OUR NEWSLETTER TO STAY UPDATED</h3>
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
@endsection

@push('styles')

<style>

    .donor-advised{
        margin-top: 8rem;
    }

    .advised-left, .advised-right{
        padding: 0;
    }

    .advised-left{
        
    }

    .advised-title-container{
        background-color: #FD6768;
        padding: 2rem 8rem 3.5rem 3rem;
        margin-bottom: 2rem;
    }

    .advised-title-container h1{
        font-weight: 400;
        font-size: 2.9rem;
        line-height: 1;
        color: #FFFFFF;
    }

    .advised-title-container h1 span{
        color: #FFF0A1;
    }

    .advised-text{
        padding-right: 4rem;
    }

    .advised-text h3{
        margin-bottom: 1rem;
        color: #484341;
        font-size: 1.6rem;
}

    .advised-text p{
        margin-bottom: 1.5rem;
        color: #8F827D;
        font-size: 1.3rem;
}

    .advised-right{
        background-color: #DDDDDD;
        height: 500px;
    }

    .section-subscribe{
        margin-top: 4rem;
    }

    /* MEDIA FOR bootstrap MD max */

    @media (max-width: 768px) {

        .advised-text{
            padding: 0 1rem;

        }
    }
    
</style>

@endpush