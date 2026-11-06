@extends('layouts.admin')

@section('title', 'Create Slider')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create Slider</h1>
            <p class="text-muted mb-0">Add a homepage banner slide</p>
        </div>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.sliders._form')
    </form>
</div>
@endsection
