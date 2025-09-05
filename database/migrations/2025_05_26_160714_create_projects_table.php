<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->json('slug');
            $table->json('title');
            $table->json('excerpt')->nullable();
            $table->json('tags')->nullable(); // ["tag1", "tag2"]
            $table->json('donation_iframe')->nullable();
            $table->json('video_iframe')->nullable();
            $table->json('content')->nullable();
            $table->json('meta')->nullable();
            $table->json('social_links')->nullable(); // {"facebook": "url", "twitter": "url"}
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
