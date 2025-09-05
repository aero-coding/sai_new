<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $defaultLocale = config('app.locale', 'en'); // ej. 'en'
        $secondaryLocale = 'es'; // ej. 'es'
        // Asegúrate que estos locales estén en config/translatable.php o donde los definas

        Page::updateOrCreate(
            ['slug->'.$defaultLocale => 'home'], // Condición para encontrar el registro
            [
                'slug' => [
                    $defaultLocale => 'home',
                    $secondaryLocale => 'inicio',
                ],
                'title' => [
                    $defaultLocale => 'Homepage',
                    $secondaryLocale => 'Página de Inicio',
                ],
                'excerpt' => [
                    $defaultLocale => 'Welcome to our website. This is the main landing page.',
                    $secondaryLocale => 'Bienvenido a nuestro sitio web. Esta es la página principal.',
                ],
                'status' => 'active',
                'donation_iframe' => [
                    $defaultLocale => '<iframe src="https://donations.example.com/widget?lang='.$defaultLocale.'" title="Donation Widget EN"></iframe>',
                    $secondaryLocale => '<iframe src="https://donations.example.com/widget?lang='.$secondaryLocale.'" title="Widget de Donación ES"></iframe>',
                ],
                'video_iframe' => [
                    $defaultLocale => '<iframe src="https://www.youtube.com/embed/videoID_EN" title="Intro Video EN"></iframe>',
                    $secondaryLocale => '<iframe src="https://www.youtube.com/embed/videoID_ES" title="Video Introductorio ES"></iframe>',
                ],
                'content' => [
                    $defaultLocale => [
                        'main_banner_text' => 'Welcome!',
                        'welcome_paragraph' => 'Discover our services and products.',
                        'features_title' => 'Our Features',
                    ],
                    $secondaryLocale => [
                        'main_banner_text' => '¡Bienvenido!',
                        'welcome_paragraph' => 'Descubre nuestros servicios y productos.',
                        'features_title' => 'Nuestras Características',
                    ],
                ],
                'meta' => [
                    $defaultLocale => [
                        'seo_title' => 'Homepage - Our Company',
                        'seo_description' => 'The official homepage of Our Company.',
                        'keywords' => 'company, services, products',
                    ],
                    $secondaryLocale => [
                        'seo_title' => 'Página de Inicio - Nuestra Empresa',
                        'seo_description' => 'La página de inicio oficial de Nuestra Empresa.',
                        'keywords' => 'empresa, servicios, productos',
                    ],
                ]
            ]
        );

        Page::updateOrCreate(
            ['slug->'.$defaultLocale => 'about-us'],
            [
                'slug' => [
                    $defaultLocale => 'about-us',
                    $secondaryLocale => 'sobre-nosotros',
                ],
                'title' => [
                    $defaultLocale => 'About Us',
                    $secondaryLocale => 'Sobre Nosotros',
                ],
                'excerpt' => [
                    $defaultLocale => 'Learn about our history, mission, and values.',
                    $secondaryLocale => 'Conoce nuestra historia, misión y valores.',
                ],
                'status' => 'active',
                'content' => [
                    $defaultLocale => [
                        'page_heading' => 'Who We Are',
                        'history_section' => 'Our journey started in...',
                    ],
                    $secondaryLocale => [
                        'page_heading' => 'Quiénes Somos',
                        'history_section' => 'Nuestra trayectoria comenzó en...',
                    ],
                ],
                'meta' => [
                    $defaultLocale => [
                        'seo_title' => 'About Us - Our Company',
                        'seo_description' => 'Learn more about Our Company.',
                    ],
                    $secondaryLocale => [
                        'seo_title' => 'Sobre Nosotros - Nuestra Empresa',
                        'seo_description' => 'Conoce más sobre Nuestra Empresa.',
                    ],
                ]
                // donation_iframe, video_iframe pueden ser null si no aplican a todas las páginas
            ]
        );

        // Añade más páginas (contact, explore) de forma similar...

        // Adjuntar media en seeders sigue siendo igual:
        // $homePage = Page::where('slug->'.$defaultLocale, 'home')->first();
        // if ($homePage && !$homePage->hasMedia('featured_image')) {
        //     // Asegúrate de tener una imagen de prueba en storage/app/public/seed_images/
        //     // Y que el disco 'public' esté symlinkeado (php artisan storage:link)
        //     if (file_exists(storage_path('app/public/seed_images/home_featured.jpg'))) {
        //         $homePage->addMedia(storage_path('app/public/seed_images/home_featured.jpg'))
        //             ->preservingOriginal()
        //             ->toMediaCollection('featured_image'); // El disco se toma de la colección
        //     }
        // }
    }
}