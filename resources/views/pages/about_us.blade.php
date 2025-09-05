@php
    $currentLocale = app()->getLocale();
    $content = $page->getTranslation('content', $currentLocale, useFallbackLocale: true) ?? [];
@endphp

@extends('layouts.app')

@section('title', $page->title)

@section('content')
<section class="section hero-about flare-container" style="background-image: url(https://sai.malcacorp.com/public/storage/pages/May2021/IMG_7729_Large-1024x7681.jpg);">
    <div class="about-hero-text-container w-100 row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="hero-about-text d-flex flex-column">
                <h1 class="text-uppercase">{{ $content['h1_title'] ?? '' }}</h1>
                <span class="text-uppercase">{{ $content['hero_text'] ?? '' }}</span>
            </div>
        </div>
    </div>
</section>

<section class="section our-mission row align-items-center flex-column">
    
    <div class="mission-top col-12 d-flex flex-column align-items-end">
        <img src="{{ asset('south_red.png') }}" alt="">
        <div class="mission-top-right d-flex flex-column">
            <h2 class="text-uppercase">{{ $content['mission_title'] ?? '' }}</h2>
            <p class="d-none d-md-block">{{ $content['mission_text'] ?? '' }}</p>
        </div>
        <div class="explore-more-container">
            <a href="#help-section" class="explore-more d-flex flex-column align-items-center">
                <span>EXPLORE MORE</span>
                <i class="bi bi-chevron-down text-white fs-5"></i> 
            </a>
        </div>
        <p class="mission-second-text d-block d-md-none">{{ $content['mission_text'] ?? '' }}</p>
    </div>
    <div id="help-section" class="floating-text-img mission-bottom col-12 col-md-9 d-flex">
        <div class="floating-text-left d-flex flex-column">
            <h3>{{ $content['floating_title'] ?? '' }}</h3>
            <p>{{ $content['floating_text'] ?? '' }}</p>
            <a href="" class="red-btn">DONATE to FEEDING DREAM</a>
        </div>
        <div class="floating-text-right">
            <div class="floating-img-container">
                <img class="image1" src="https://sai.malcacorp.com/public/storage/pages/May2021/SAI_58_de_59_Large.jpg" alt="">
            </div>
            <div class="floating-img-container">
                <img class="image2" src="https://sai.malcacorp.com/public/storage/pages/May2021/helporph12 (1)1.jpg" alt="">
            </div>
        </div>
    </div>
</section>

<section  class="section section-help section-help-about row">
    <div class="help-container col-12 col-md-9">
        <div class="help-top flex-row-reverse">
            <div class="help-top-left d-flex flex-column">
                <h2 class="text-uppercase">{{ $content['help_title'] ?? '' }}</h2>
                <p>{{ $content['help_text'] ?? '' }}</p>
                <a href="#" class="white-btn white-about d-none d-md-inline"><span>DONATE to DOG SANCTUARY</span></a>
            </div>
            <div class="help-top-right">
                <img src="{{asset('example.jpg')}}" alt="">
            </div>
            <div class="help-top-left d-md-none">
                <a href="#" class="white-btn white-about d-inline d-flex justify-content-center"><span>DONATE to DOG SANCTUARY</span></a>
            </div>
        </div>
    </div>
</section>

<section class="section our-mission section-helping row justify-content-center">
    <div class="floating-text-img mission-bottom col-12 col-md-9 d-flex">
        <div class="floating-text-left d-flex flex-column">
            <h3 class="text-uppercase">Helping People & Animals in Their Deepest Time of Need</h3>
            <p>SAI began operating in Venezuela providing humanitarian aid to hospitalized patients, orphaned children, the homeless, elderly who have been abandoned and forgotten in nursing homes and families who do not have shelter or food to eat.</p>
            <a href="" class="red-btn">DONATE to ORPHANS PROGRAM ></a>
        </div>
        <div class="floating-text-right">
            <div class="floating-img-container">
                <img class="image1" src="https://sai.malcacorp.com/public/storage/pages/May2021/SAI_58_de_59_Large.jpg" alt="">
            </div>
            <div class="floating-img-container">
                <img class="image2" src="https://sai.malcacorp.com/public/storage/pages/May2021/helporph12 (1)1.jpg" alt="">
            </div>
        </div>
    </div>
</section>

<section class="red-top-shadow section section-certifications d-flex">
    <div class="section-certifications-container">
        <h2 class="text-uppercase">{{ $content['certifications_title'] ?? '' }}</h2> 
        <div class="certifications">
            <a href="https://www.globalgiving.org/donate/42484/south-american-initiative/" class="certification-item"><img class="vargas" src="{{asset('example.jpg')}}" alt=""></a>
            <a href="https://greatnonprofits.org/organizations/view/south-american-initiative-inc/page:2" class="certification-item"><img class="globalgiving" src="{{asset('example.jpg')}}" alt=""></a>
            <a href="https://www.guidestar.org/profile/81-1747993" class="certification-item"><img class="google" src="{{asset('example.jpg')}}" alt=""></a>
            <a href="https://www.globalgiving.org/learn/introducing-gg-rewards" class="certification-item"><img class="benevity" src="{{asset('example.jpg')}}" alt=""></a>
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

<div class="big-section section">
    <section class="section section-values">
        <div class="values-center container-fluid row justify-content-center">
            <div class="values-container col-12 col-md-9 d-flex">
            <div class="values-card">
                <div class="card-top">
                    <img src="{{asset('example.jpg')}}" alt="">
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
                    <img src="{{asset('example.jpg')}}" alt="">
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
                    <img src="{{asset('example.jpg')}}" alt="">
                </div>
                <div class="card-bottom">
                    <div class="card-bottom-container">
                        <h3 class="text-uppercase">{{ $content['values_card_3_title'] ?? '' }}</h3>
                        <p>{{ $content['values_card__text'] ?? '' }}</p>
                    </div>
                </div>
            </div>
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
    </div>
</section>

<section class="section annual-reports row">
    <div class="annual-container col-12 col-md-8 d-flex">
        <div class="annual-left d-flex ">
            <h2 class="text-uppercase">{{ $content['reports_title'] ?? '' }}</h2>
            <div class="annual-text d-flex flex-column">
                <p>{{ $content['reports_text'] ?? '' }}</p>
                <a href="" class="white-btn"><span>DOWNLOAD REPORT ></span></a>
            </div>
        </div>
        <div class="annual-right d-flex">
            <div class="annual-right-container"></div>
        </div>
    </div>
</section>
</div>

<section class="section section-help row">
    <div class="help-container col-12 col-md-9">
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
            <div class="subscribe-logo d-none d-md-block"><img src="{{ asset('logo.png') }}" alt="">
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
@endsection

@push('styles')
    <style>
        main {
    padding: 0;
}

.about-hero-text-container{
    max-width: none !important;
    z-index: 10;
}

.about-hero-text-container > div{
    max-width: 1400px;
}

.flare-container::after{
    content: none;
}

.hero-about {
    width: 100%;
    height: 80vh;
    position: relative;

    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    text-align: center;
}

.hero-about-text {
    /* position: absolute; */
    width: 550px;
    bottom: 40%;
    left: 10rem;
    text-align: left;
}

.hero-about-text h1 {
    color: #fff0a1;
    font-size: 1.4rem;
    margin-bottom: 1.7rem;
}

.hero-about-text span {
    font-size: 2.3rem;
    color: #fff;
    font-weight: 400;
    line-height: 1.1;
}

/* MISSION */

.our-mission {
    margin-bottom: 6rem;
}

.mission-top {
    background: linear-gradient(
        70deg,
        rgba(218, 69, 71, 1) 0%,
        rgba(252, 103, 104, 1) 100%
    );
    padding: 0;
    padding-top: 3rem;
    padding-bottom: 6rem;
    position: relative;
}

.mission-top img {
    position: absolute;
    top: 0;
    left: 0;
    max-width: 50%;
    mask-image: linear-gradient(to bottom, black 70%, transparent 100%);
    mask-size: 100% 100%;
    mask-repeat: no-repeat;
}

.mission-top-left {
    width: 40%;
}

.mission-top-right {
    width: 60%;
    padding-right: 9rem;
    z-index: 5;
}

.mission-top h2 {
    text-transform: uppercase;
    color: #fff0a1;
    font-weight: bold;
    font-size: 2.1rem;
    margin-bottom: 1rem;
}

.mission-top p {
    z-index: 5;
    font-size: 1.7rem;
    color: #fff;
    line-height: 1.2;
}

.explore-more-container {
    z-index: 5;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 5rem;
}

.explore-more {
    color: #fff;
    text-decoration: none;
    font-size: 1.3rem;
}

.explore-more:hover {
    color: #fff;
    text-decoration: none;
}

/* FLOATING TEXT-IMG */

.floating-text-img {
    z-index: 30;
    margin-top: 8rem;
    justify-content: space-between;
}

.floating-text-left {
    width: 50%;
    gap: 2.1rem;
    justify-content: center;
}

.floating-text-left h3 {
    font-size: 1.7rem;
    font-weight: bold;
    color: #454545;
}

.floating-text-left p {
    font-size: 1.2rem;
    color: #8f827d;
}

.floating-text-right {
    position: relative;
    width: 40%;
}

.floating-img-container {
}

.floating-img-container img {
    border-radius: 10px;
    position: absolute;
}

.floating-img-container .image1 {
    width: 467px;
    height: 548px;
    max-height: 120%;
    max-width: 67%;
    object-fit: cover;
    object-position: center;
    top: -5rem;
}

.floating-img-container .image2 {
    width: 467px;
    height: 548px;
    max-height: 80%;
    max-width: 50%;
    object-fit: cover;
    object-position: center;
    bottom: -4rem;
    right: 3rem;
}

.floating-img-container img {
    /* position: absolute; */
}

.red-btn {
    display: inline-block;
    background-color: #d9534f;
    color: #ffffff;
    padding: 0.5rem 2.3rem;
    border-radius: 8px;
    border: none;
    cursor: pointer;

    align-self: flex-start;

    font-size: 1rem;
    font-weight: 400;
    text-align: center;
    text-decoration: none;
    white-space: nowrap;

    transition: background-color 0.2s ease-in-out, transform 0.1s ease;
}

.red-btn:hover {
    background-color: #c84a47;
    text-decoration: none;
    color: #fff;
}

/* HELP */

.section-help-about {
    margin-bottom: 2rem;
}

.section-help-about .help-top-left {
    gap: 2.1rem;
}

.section-help-about h2 {
    margin: 0;
    font-weight: bold;
}
.section-help-about .help-top-left {
    color: #fff;
}

.white-about {
    padding: 0.5rem 2.5rem;
    border-radius: 5px;
}

/* HELPING PEOPLE ANIMALS */

.section-helping {
    margin-bottom: 10rem;
}

/* CERTIFICATIONS */

.section-certifications {
    background-color: #D94647;
}

.section-certifications-container h2 {
    color: #fff;
}

.section-certifications-container {
    background-color: transparent;
}

/* SPONSORS */

.section-sponsors-container {
}

.section-values {
    margin-bottom: 2rem;
}

.values-card {
    background-color: #fff;
    /* light shadow */
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);

    /* light shadow */
}

.card-bottom-container {
    color: #fc6768;
}

/* BIG SECTION */

.big-section {
    padding-top: 2rem;
    background: linear-gradient(
        138deg,
        rgba(78, 101, 178, 1) 0%,
        rgba(224, 197, 197, 1) 29%,
        rgba(245, 235, 235, 1) 98%
    );
}

/* ANNUAL REPORTS */

.annual-reports {
    background: linear-gradient(
        138deg,
        rgba(218, 69, 71, 1) 0%,
        rgba(252, 103, 104, 1) 98%
    );
    justify-content: center;
    padding: 3rem 0;
    margin-bottom: 5rem;
}

.annual-container {
    justify-content: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.annual-left {
    width: 48%;
    padding-top: 2rem;
    border-top: 1px solid #fff;
    min-width: 400px;
    margin-bottom: 1rem;
}

@media (max-width: 767.98px) {
    .annual-left {
        width: 100%;
        min-width: auto;
    }
    .annual-left *{
        min-width: auto;
    }

    .our-mission{
        margin-bottom: 5rem;
    }

    .floating-text-img{
        margin-top: 0;
    }

    .section-help-about h2 {
        font-size: 1.2rem;
    }
}

.annual-text {
    width: 100%;
    gap: 4rem;
}

.annual-left h2 {
    width: 50%;
    font-size: 2.5rem;
    color: #fff0a1;
}

.annual-left .annual-text {
    width: 50%;
    color: #fff;
}

.annual-left .white-btn {
    margin: 0;
    padding: 0.5rem 2rem;
}

.annual-right {
    width: 48%;
    min-width: 445px;
}

.annual-right-container {
    width: 100%;
    height: 300px;
    background-color: #f28385;
    border-radius: 10px;
}

/* Media Querie for lower or equal than md bootstrap viewport size */

@media (max-width: 767.98px) {

    .about-hero-text-container{
        margin-bottom: 1rem
    }

    .hero-about{
        align-items: flex-end;
        height: 60vh;
    }

    .hero-about-text {
        bottom: 1rem;
        left: 1rem;
    }

    .mission-top img {
        max-width: 100%;
    }

    .mission-top-right {
        padding: 1rem;
    }

    .mission-second-text {
        padding: 1rem;
    }

    .floating-text-img {
        flex-direction: column;
        align-items: center;
    }

    .floating-text-left {
        width: 100%;
    }

    .floating-text-right {
        width: 100%;
    }

    .hero-about-text {
        width: auto;
    }

    .annual-left {
        flex-wrap: wrap;
    }

    .annual-left h2,
    .annual-left .annual-text {
        min-width: 235px;
        width: 100%;
        gap: 2rem;
    }

    .numbers-container {
        padding: 0;
    }

    .hero-about-text span {
        font-size: 2rem;
        max-width: 100%;
    }
}

/* Media Querie for lower than md bootstrap viewport size */

    </style>
@endpush