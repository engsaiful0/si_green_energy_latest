@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Project</h1>
            <p class="text-muted mb-0">Update project details</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.projects._form')
    </form>
</div>
@foreach($project->images as $image)
<form id="delete-image-{{ $image->id }}" action="{{ route('admin.projects.images.destroy', [$project, $image]) }}" method="POST" class="d-none">
    @csrf @method('DELETE')
</form>
@endforeach
@endsection
