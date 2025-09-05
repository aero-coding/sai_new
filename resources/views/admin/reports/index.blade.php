@extends('layouts.admin_app')

@section('content')
    <h1>Manage Reports</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('admin.reports.create') }}" class="btn btn-primary">Create New Report</a>
        {{-- Formulario de Filtro por Proyecto --}}
        <form method="GET" action="{{ route('admin.reports.index') }}" class="form-inline">
            <div class="input-group">
                <select name="project_id" class="form-select">
                    <option value="">All Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->getTranslation('title', app()->getLocale(), true) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </form>
    </div>


    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Report Title ({{ strtoupper(app()->getLocale()) }})</th>
                <th>Parent Project</th>
                <th>Status</th>
                <th>Publication Date</th>
                <th>Creator</th>
                <th>Last Editor</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->getTranslation('title', app()->getLocale(), true) }}</td>
                    <td>
                        @if($report->project)
                            <a href="{{ route('admin.projects.edit', $report->project->id) }}">
                                {{ $report->project->getTranslation('title', app()->getLocale(), true) }}
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $report->status === 'published' ? 'success' : ($report->status === 'draft' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td>{{ $report->published_at ? $report->published_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $report->creator->name ?? 'N/A' }}</td>
                    <td>{{ $report->editor->name ?? 'N/A' }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.reports.edit', $report->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                        </form> --}}
                        <a href="{{ route('report.show.localized', [
                                'locale' => app()->getLocale(), 
                                'report_slug' => $report->getTranslation('slug', app()->getLocale())
                            ]) }}" class="btn btn-sm btn-info" target="_blank">Visit</a>

                        <a href="{{ route('admin.reports.edit', $report->id) }}" class="btn btn-sm btn-primary">Edit</a>

                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No reports found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $reports->appends(request()->query())->links() }}
@endsection