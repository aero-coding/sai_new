<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $admin = User::first(); // Asume que existe al menos un usuario admin

        // Crear 10 proyectos de prueba
        for ($i = 1; $i <= 1; $i++) {
            $project = Project::create([
                'title' => $this->generateTranslations($faker, 'sentence'),
                'slug' => $this->generateTranslations($faker, 'slug'),
                'excerpt' => $this->generateTranslations($faker, 'paragraph'),
                'tags' => $faker->words(5),
                'donation_iframe' => $this->generateIframeTranslations($faker),
                'video_iframe' => $this->generateIframeTranslations($faker),
                'content' => $this->generateContentTranslations($faker),
                'meta' => $this->generateMetaTranslations($faker),
                'social_links' => [
                    'facebook' => 'https://facebook.com/project-'.$i,
                    'twitter' => 'https://twitter.com/project-'.$i
                ],
                'status' => $faker->randomElement(['draft', 'published']),
                'published_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'user_id' => $admin->id
            ]);

            // Subir media
            $this->attachMedia($project, $i);
        }
    }

    // Helper: Generar traducciones para campos JSON
    private function generateTranslations($faker, $method)
    {
        $translations = [];
        foreach (config('app.available_locales') as $locale) {
            $translations[$locale] = $faker->$method();
        }
        return $translations;
    }

    // Helper: Generar iframes traducibles
    private function generateIframeTranslations($faker)
    {
        $iframes = [];
        foreach (config('app.available_locales') as $locale) {
            $iframes[$locale] = '<iframe src="https://example.com/'. $faker->slug .'"></iframe>';
        }
        return $iframes;
    }

    // Helper: Generar contenido traducible con estructura específica
    private function generateContentTranslations($faker)
    {
        $content = [];
        foreach (config('app.available_locales') as $locale) {
            $content[$locale] = [
                'h1_title' => $faker->sentence(3),
                'hero_text' => $faker->paragraph,
                'image_about' => '', // Se llenará con media
                'about_text_1' => $faker->paragraphs(2, true),
                'values_title' => $faker->sentence,
                'image_values_card_1' => '',
                'numbers_of_people_helped' => $faker->numberBetween(100, 1000)
            ];
        }
        return $content;
    }

    // Helper: Generar meta tags traducibles
    private function generateMetaTranslations($faker)
    {
        $meta = [];
        foreach (config('app.available_locales') as $locale) {
            $meta[$locale] = [
                'seo_title' => $faker->sentence,
                'seo_description' => $faker->paragraph,
                'keywords' => implode(',', $faker->words(5))
            ];
        }
        return $meta;
    }

    // Helper: Adjuntar imágenes de prueba
    private function attachMedia(Project $project, $index)
    {
        // Imagen destacada
        $project->addMedia(storage_path('seeders/projects/project-'.$index.'.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('featured_image');

        // Galería (3 imágenes)
        foreach (range(1, 3) as $galleryIndex) {
            $project->addMedia(storage_path('seeders/projects/gallery-'.$galleryIndex.'.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('gallery');
        }

        // Actualizar URLs en content
        foreach (config('app.available_locales') as $locale) {
            $content = $project->content;
            $content[$locale]['image_about'] = $project->getFirstMediaUrl('featured_image', 'optimized');
            $content[$locale]['image_values_card_1'] = $project->getFirstMediaUrl('gallery', 'optimized');
            $project->content = $content;
        }
        
        $project->save();
    }
}
