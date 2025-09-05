<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->json('meta')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Lógica para revertir el cambio
            $table->dropColumn('meta');
        });
    }
};