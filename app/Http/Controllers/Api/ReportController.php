<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Http\Resources\ReportResource;

class ReportController extends Controller
{
    /**
     * Muestra una lista de reportes, con capacidad de búsqueda y filtro.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $locale = $request->query('lang', app()->getLocale());

        $query = Report::query()
                       ->where('status', 'published')
                       ->with([
                        'project:id,title,slug',
                        'creator:id,name',
                        'media',
                        'tags:id,name,color_bg,color_text' // Especificar campos necesarios
                    ]);

        // Filtro de búsqueda por texto (en title y excerpt)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm, $locale) {
                $q->where("title->{$locale}", 'LIKE', "%{$searchTerm}%")
                  ->orWhere("excerpt->{$locale}", 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtro por Tag ID
        if ($request->filled('tag_id')) {
            $tagId = $request->input('tag_id');
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        // Ordenar por más vistos por defecto
        $reports = $query->orderBy('view_count', 'desc')
                         ->latest('published_at') // Como segundo criterio de orden
                         ->paginate(12);

        return ReportResource::collection($reports);
    }
    
    /**
     * Muestra un reporte específico.
     *
     * @param \App\Models\Report $report
     * @return \App\Http\Resources\ReportResource
     */
    public function show(Report $report)
    {
        if ($report->status !== 'published') {
            abort(404);
        }
        
        return new ReportResource($report->load(['project', 'creator', 'media', 'tags']));
    }
}
