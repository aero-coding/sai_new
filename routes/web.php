<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;



use Illuminate\Support\Facades\Storage;

use App\Models\Project;
use App\Http\Controllers\Admin\MediaController;

// Base Routes

// Route::get('/', function () {
//     return view('home');
// })->name('home');
//Route::get('projects/2', [AdminProjectController::class, 'index2'])->name('admin.projects.index.2');

Route::post('/reports/{report}/featured-image', [ReportsController::class, 'uploadFeaturedImage'])
    ->name('reports.featured-image.upload');



    Route::post('/reports/{report}/deleted-image', [ReportsController::class, 'deleteFeaturedImage'])
    ->name('reports.featured-image.delete');

Route::get('/reports/featured-image/{ext}/{id}', [ReportsController::class,'form']);
Route::get('/reports/featured-image/delete', [ReportsController::class, 'deleteFeatured']);
//Route::get('/upload-image-new', [AdminProjectController::class, 'uploadImageNew'])->name('admin.reports.upload_image_new');
Route::get('/upload-image-new2', [AdminProjectController::class, 'uploadImageNew2'])->name('admin.reports.upload_image_new2');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/news', function () {
    return view('news');
})->name('news');

Route::get('/project', function () {
    return view('project');
})->name('project');

Route::get('/help', function () {
    return view('help');
})->name('help');

Route::get('/explore', function () {
    return view('explore');
})->name('explore');

Route::get('/donate', function () {
    return view('donate');
})->name('donate');

Route::get('/donatecrypto', function () {
    return view('donatecrypto');
})->name('donatecrypto');

Route::get('/projectabout', function () {
    return view('projectabout');
})->name('projectabout');

// Dynamic Page Routes with Locale

// Route::get('/', [PagesController::class, 'showHome'])->name('pages.home');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('pages.home');

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '^(' . implode('|', config('app.available_locales')) . ')$'],
    'middleware' => 'setlocale'
                                
], function () {

    // STATIC ROUTES FOR SPECIAL PROTOCOLS
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.localized');
    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.localized');
    Route::get('/explore', [App\Http\Controllers\ExploreController::class, 'index'])->name('explore.localized');
    Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.localized');
    
    Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio.localized');
    Route::get('/explorar', [App\Http\Controllers\ExploreController::class, 'index'])->name('explorar.localized');
    Route::get('/noticias', [App\Http\Controllers\NewsController::class, 'index'])->name('noticias.localized');
    // END STATIC ROUTES FOR SPECIAL PROTOCOLS

    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index.localized');
    Route::get('/projects/{project_slug}', [ProjectsController::class, 'show'])->name('projects.show.localized');

    Route::get('/report/{report_slug}', [ReportsController::class, 'show'])->name('report.show.localized');
    // El método ReportsController@show necesitará ser modificado para aceptar $locale.

    Route::get('/{page_slug}', [PagesController::class, 'show'])->name('page.show.localized');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['web','auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Media Library
    Route::delete('media-library/{id}', [MediaController::class, 'destroy'])->name('admin.media-library.destroy');
    Route::post('media-library', [MediaController::class, 'store'])->name('admin.media-library.store');
    Route::get('media-library', [MediaController::class, 'index'])->name('admin.media-library.index');
    Route::post('media-library/{id}/update-alt-text', [MediaController::class, 'updateAltText'])->name('admin.media-library.update-alt-text');

    // --- NUEVAS RUTAS PARA CARPETAS Y DESCARGAS ---
    Route::post('media-library/folder', [MediaController::class, 'createFolder'])->name('admin.media-library.createFolder');
    Route::get('media-library/{media}/download', [MediaController::class, 'download'])->name('admin.media-library.download');

    // Text editor trying
    Route::post('reports/{id}/upload-image', [AdminReportController::class, 'uploadImage'])->name('admin.reports.upload_image');

    // Pages
    Route::get('pages', [AdminPageController::class, 'index'])->name('admin.pages.index'); // Listar todas las páginas
    Route::get('pages/{id}/edit', [AdminPageController::class, 'edit'])->name('admin.pages.edit'); // Formulario para editar una página
    Route::put('pages/{id}', [AdminPageController::class, 'update'])->name('admin.pages.update'); // Actualizar una página

    // Projects
    Route::get('projects', [AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('projects/create', [AdminProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('projects', [AdminProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('projects/{id}/edit', [AdminProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('projects/{id}', [AdminProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('projects/{id}', [AdminProjectController::class, 'destroy'])->name('admin.projects.destroy');
    Route::post('projects/{id}/upload-image', [AdminProjectController::class, 'uploadImage'])->name('admin.projects.upload_image');

    // Reports (MODIFICACIONES AQUÍ)
    Route::get('reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('reports/create', [AdminReportController::class, 'create'])->name('admin.reports.create');
    Route::get('projects/{project}/reports/create', [AdminReportController::class, 'createForProject'])->name('admin.projects.reports.create'); // Este usa {project} para RMB de Project, lo cual está bien.
    Route::post('reports', [AdminReportController::class, 'store'])->name('admin.reports.store');
    
    // Cambia {report} a {id} en las siguientes rutas
    Route::get('reports/{id}/edit', [AdminReportController::class, 'edit'])->name('admin.reports.edit'); 
    Route::put('reports/{id}', [AdminReportController::class, 'update'])->name('admin.reports.update');
    Route::delete('reports/{id}', [AdminReportController::class, 'destroy'])->name('admin.reports.destroy');

    // Tags
    Route::prefix('tags')->name('admin.tags.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\TagController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\TagController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\TagController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\TagController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\TagController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\TagController::class, 'destroy'])->name('destroy');
    });
});

// Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
// Route::get('/projects/{slug}', [ProjectsController::class, 'show'])->name('projects.show');

// Route::get('/reports/{report_slug}', [ReportsController::class, 'show'])->name('report.show');



Route::get('/test-image-url', function () {
    $project = Project::find(121); // Reemplaza con el ID real

    if (!$project) {
        return 'Proyecto no encontrado';
    }

    $media = $project->getFirstMedia('gallery');

    if (!$media) {
        return 'No hay imagenes en la colección gallery';
    }

    return [
        'original_path' => $media->getPath(),
        'original_url' => $media->getUrl(),
        'optimized_path' => $media->getPath('optimized'),
        'optimized_url' => $media->getUrl('optimized'),
        'thumbnail_url' => $media->getUrl('thumbnail'),
        'all_conversions' => $media->generated_conversions,
    ];
});


Route::get('/storage-test2', function () {
    // Ruta relativa dentro del disco 'public'
    //$path = 'media/149/conversions';
    //$path = 'media/149/conversions';

    $path = '';

    // Archivos disponibles dentro de esa ruta
    /*$files = Storage::disk('public')->files($path);

    if (empty($files)) {
        return 'No se encontraron archivos en: ' . $path;
    }

    $html = '<h2>Archivos encontrados en public/' . $path . ':</h2><ul>';
    foreach ($files as $file) {
        $url = Storage::url($file);
        $html .= "<li><a href='{$url}' target='_blank'>{$url}</a></li>";
    }
    $html .= '</ul>';*/




    $files = Storage::disk('public')->files();

    /*$image = Storage::path('149/8lkWrF8zk3ytXh3r85M9.jpg');

    $html = '<h2>Archivos encontrados en public/' . $path . ':</h2><h2>'. $image .'</h2><ul>';

    foreach ($files as $file) {
        $url = Storage::url($file);
        $html .= "<li><a href='{$url}' target='_blank'>{$url}</a></li>";
    }
    $html .= '</ul>';


    

    return $html;*/

    dd(public_path());
});
