@extends('layouts.admin')

@section('title', 'Edit ' . $config['singular'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit {{ $config['singular'] }}</h1>
            @if($item)<p class="text-muted mb-0">{{ $item->name }}</p>@endif
        </div>
        <a href="{{ route($config['route'] . '.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route($config['route'] . '.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.catalog._form')
    </form>
</div>
@endsection
