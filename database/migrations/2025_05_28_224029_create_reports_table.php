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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); // Relación con Project
            $table->json('slug')->unique(); // Traducible
            $table->json('title');          // Traducible
            $table->json('excerpt')->nullable(); // Traducible
            $table->json('content')->nullable(); // Traducible, estructura flexible JSON
            $table->string('status')->default('draft'); // Ej: draft, published, archived
            $table->timestamp('published_at')->nullable(); // Fecha de publicación del reporte
            
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null'); // Usuario que creó el reporte
            $table->foreignId('editor_id')->nullable()->constrained('users')->onDelete('set null');  // Usuario que editó por última vez

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};