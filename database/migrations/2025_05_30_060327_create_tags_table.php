<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // Nombre en múltiples idiomas
            $table->string('color_bg', 7); // Color de fondo HEX
            $table->string('color_text', 7); // Color de texto HEX
            $table->string('slug')->unique(); // Slug único para URLs
            $table->json('url')->nullable();  // if needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
