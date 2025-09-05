@extends('layouts.admin_app')

@section('content')
    <h1>Create New Project</h1>

    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Mismo contenido que edit.blade.php, pero sin valores iniciales -->
        @include('admin.projects.form_fields', ['project' => null])

        <button type="submit" class="btn btn-success">Create Project</button>
    </form>
@endsection