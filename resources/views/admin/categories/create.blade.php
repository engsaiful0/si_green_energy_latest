@extends('layouts.admin')

@section('title', 'Add ' . $config['singular'])

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Add {{ $config['singular'] }}</h1>
        </div>
        <a href="{{ route($config['route'] . '.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route($config['route'] . '.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.categories._form')
    </form>
</div>
@endsection
