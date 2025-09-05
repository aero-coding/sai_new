@extends('layouts.admin_app')

@section('content')
    <h1>Manage Projects</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mb-3">Create New Project</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title ({{ strtoupper(app()->getLocale()) }})</th>
                <th>Status</th>
                <th>Publication Date</th>
                <th>Last Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->getTranslation('title', app()->getLocale(), useFallbackLocale: true) }}</td>
                    <td>
                        <span class="badge bg-{{ $project->status === 'published' ? 'success' : 'warning' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                    <td>{{ $project->published_at?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $project->updated_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this project?')">Delete</button>
                        </form> --}}
                        <a href="{{ route('projects.show.localized', [
                                'locale' => app()->getLocale(), 
                                'project_slug' => $project->getTranslation('slug', app()->getLocale())
                            ]) }}" class="btn btn-sm btn-info" target="_blank">Visit</a>

                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-primary">Edit</a>

                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this project?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No projects found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $projects->links() }}
@endsection