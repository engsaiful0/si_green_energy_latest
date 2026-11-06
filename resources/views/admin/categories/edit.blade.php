@extends('layouts.admin')

@section('title', 'Edit ' . $config['singular'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit {{ $config['singular'] }}</h1>
            <p class="text-muted mb-0">{{ $category->name }}</p>
        </div>
        <a href="{{ route($config['route'] . '.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route($config['route'] . '.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
    </form>
</div>
@endsection
