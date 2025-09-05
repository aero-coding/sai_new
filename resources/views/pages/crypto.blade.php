@php
    $currentLocale = app()->getLocale();
    $content = $page->getTranslation('content', $currentLocale, useFallbackLocale: true) ?? [];
@endphp


@extends('layouts.app')

@section('title', 'Donate Crypto')

@section('content')

<section class="how-to section row justify-content-center">
    <div class="col-12 col-md-9 title-container">
        <h1 class="text-uppercase">{{ $content['h1_title'] ?? '' }}</h1>
    </div>
    <div class="col-12 col-md-9 text-container row">
        <div class="text-left col-12 col-md-8">
            <p>{{ $content['paragraph_1'] ?? '' }}</p>
            <div>
            <h3>{{ $content['text_title'] ?? '' }}</h3>
            <p>{{ $content['paragraph_2'] ?? '' }}</p>
            <p>{{ $content['paragraph_3'] ?? '' }}</p>
            </div>
            <p>{{ $content['paragraph_4'] ?? '' }}</p>
        </div>
        <div class="text-right col-md-4 d-none d-md-block">

        </div>

    </div>
</section>

<section class="section row contact-us justify-content-center">
    <h2 class="text-uppercase col-12 col-md-3" >{{ $content['contact_title'] ?? '' }}<</h2>
    {{-- TODO ESTE PÁRRAFO CON CONDICIONAL --}}
    <div class="col-12 col-md-6" > 
        <p>If you have any questions, please email us at <a href="">donate@sai.ngo</a>. If youd like to donate to a pacific project please indicate the project name in the note section of the donation form. Projects are as follows: Venezuelan orphans, SAI childrens medical clinic, Abandoned Venezuelan Pets, Zoo animals Venezuela.</p>
        <p>{{ $content['contact_side_text_2'] ?? '' }}<</p>
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

    .how-to{
        margin-top: 8rem;
        margin-bottom: 4rem;
    }

    .text-right, .text-left{
        padding: 0;
    }

    .text-right{
        background-color: #8F827D;
        height: 500px;
    }

    
    .title-container{
        background-color: #FD6768;
        padding: 2rem 8rem 3.5rem 3rem;
        margin-bottom: 2rem;
    }

    .title-container h1{
        font-weight: 400;
        font-size: 2.9rem;
        line-height: 1;
        color: #FFFFFF;
    }

    .text-container{
        padding-right: 4rem;
    }

    .text-container h3{
        margin-bottom: 1rem;
        color: #484341;
        font-size: 1.6rem;
}

    .text-container p{
        margin-bottom: 1.5rem;
        color: #8F827D;
        font-size: 1.3rem;
}

.contact-us{
    background-color: #E6EDF5;
    padding: 3rem 0 6rem 0;
}

.contact-us h2{
    color: #D94647;
    font-size: 2.5rem;
    font-weight: 600;
}

.contact-us p{
    color: #8F827D;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.section-subscribe{
    position: relative;
}

.subscribe-container{
    position: relative;
    top: -5rem;
}

/* MEDIA FOR bootstrap MD max */
@media (max-width: 768px) {

    .title-container{
        padding: 1rem;
    }

    .title-container h1{
        font-size: 2.2rem;
    }

    .contact-us{
        background-color: transparent;
        margin-top: 0;
    }

    .text-container{
        padding: 0 1rem;
    }

    .contact-us h2{
        margin-bottom: 1rem;
    }

    .how-to{
        margin-bottom: 0;
    }
}



</style>

@endpush