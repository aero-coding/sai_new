<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {

            $table->id();
            $table->json('slug')->unique();

            $table->json('title');
            $table->json('excerpt')->nullable();
            $table->string('status')->default('draft');
            $table->json('donation_iframe')->nullable();
            $table->json('video_iframe')->nullable();
            $table->json('content')->nullable(); 
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};