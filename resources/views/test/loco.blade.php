
<h1>Proyectos cargados:</h1>

@if($projects->isEmpty())
    <p>⚠️ No se encontraron proyectos.</p>
@else
    @foreach($projects as $project)
        <div>
            <h2>{{ is_array($project->title) ? ($project->title[app()->getLocale()] ?? '[Sin título]') : $project->title }}</h2>
            <p>{{ is_array($project->excerpt) ? ($project->excerpt[app()->getLocale()] ?? '') : $project->excerpt }}</p>
        </div>
    @endforeach
@endif