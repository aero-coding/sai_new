@extends('layouts.admin_app')

@section('content')
    <h1>Gestionar Páginas</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título ({{ strtoupper(app()->getLocale()) }})</th>
                <th>Slug ({{ strtoupper(app()->getLocale()) }})</th>
                <th>Estado</th>
                <th>Última Modificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->slug }}</td>
                    <td><span class="badge bg-{{ $page->status === 'active' ? 'success' : 'warning' }}">{{ ucfirst($page->status) }}</span></td>
                    <td>{{ $page->updated_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-primary">Editar</a> --}}
                        {{-- <a href="{{ route('admin.pages.edit', ['page' => $page->id]) }}" class="btn btn-sm btn-primary">Editar</a> --}}
                        {{-- Aquí podrías añadir un botón de eliminar con confirmación --}}

                        {{-- <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-primary">Editar</a> --}}

                        @php
                            // Comprobamos si el slug del idioma por defecto es 'home' para usar la ruta raíz.
                            $isHomePage = $page->getTranslation('slug', config('app.fallback_locale', 'en')) === 'home';
                            $publicUrl = $isHomePage 
                                ? route('pages.home') 
                                : route('page.show.localized', [
                                    'locale' => app()->getLocale(), 
                                    'page_slug' => $page->getTranslation('slug', app()->getLocale())
                                ]);
                        @endphp
                        <a href="{{ $publicUrl }}" class="btn btn-sm btn-info" target="_blank">Visit</a>
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay páginas para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $pages->links() }} {{-- Para paginación --}}
@endsection