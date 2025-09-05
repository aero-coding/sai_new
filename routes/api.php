<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController; // Crearemos este controlador
use App\Http\Controllers\Api\ReportController;  // Y este también

// Rutas para Proyectos
Route::get('/projects', [ProjectController::class, 'index'])->name('api.projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('api.projects.show');

// Rutas para Reportes (aquí implementaremos el buscador)
Route::get('/reports', [ReportController::class, 'index']); // Obtener todos los reportes (o buscar)
Route::get('/reports/{report}', [ReportController::class, 'show']); // Obtener un reporte específico