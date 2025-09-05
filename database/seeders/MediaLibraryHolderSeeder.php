<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MediaLibraryHolder;

class MediaLibraryHolderSeeder extends Seeder
{
    public function run(): void
    {
        // Crea el registro solo si no existe
        MediaLibraryHolder::firstOrCreate(['id' => 1]);
    }
}