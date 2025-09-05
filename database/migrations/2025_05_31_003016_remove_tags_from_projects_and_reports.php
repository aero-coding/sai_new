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
        // Eliminar solo si la columna existe en projects
        if (Schema::hasColumn('projects', 'tags')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('tags');
            });
        }
        
        // Eliminar solo si la columna existe en reports
        if (Schema::hasColumn('reports', 'tags')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->dropColumn('tags');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Restaurar columna en projects
        if (!Schema::hasColumn('projects', 'tags')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->json('tags')->nullable();
            });
        }
        
        // No restaurar en reports ya que nunca existió
    }
};