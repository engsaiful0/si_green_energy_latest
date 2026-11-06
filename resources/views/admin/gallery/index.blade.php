@extends('layouts.admin')

@section('title', 'Gallery Images')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gallery Images</h1>
            <p class="text-muted mb-0">Images for the Gallery page and the homepage carousel</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.gallery-categories.index') }}" class="btn btn-outline-secondary"><i class="fas fa-folder me-2"></i>Categories</a>
            <a href="{{ route('admin.gallery.home') }}" class="btn btn-outline-secondary"><i class="fas fa-images me-2"></i>Homepage Carousel</a>
            <a href="{{ route('admin.content.index', 'gallery') }}" class="btn btn-outline-secondary"><i class="fas fa-th-large me-2"></i>Page Content</a>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary"><i class="fas fa-upload me-2"></i>Upload Images</a>
        </div>
    </div>

    @include('admin.partials.alerts')

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3"><input type="search" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}"></div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((string) request('category') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Any status</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
                <option value="draft" @selected(request('status') === 'draft')>Unpublished</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="home" value="1" id="filter-home" @checked(request()->boolean('home'))>
                <label class="form-check-label" for="filter-home">On homepage</label>
            </div>
        </div>
        <div class="col-md-2 d-grid"><button class="btn btn-outline-secondary" type="submit"><i class="fas fa-filter me-1"></i>Filter</button></div>
    </form>

    @if($images->isEmpty())
        <div class="card shadow-sm"><div class="card-body text-center py-5 text-muted">
            <i class="fas fa-images fa-3x mb-3 d-block"></i>No images found. <a href="{{ route('admin.gallery.create') }}">Upload images</a>
        </div></div>
    @else
    <form id="order-form" action="{{ route('admin.gallery.reorder') }}" method="POST">
        @csrf @method('PUT')
    </form>

    <div class="row g-3">
        @foreach($images as $image)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card shadow-sm h-100 {{ $image->status === 'published' ? '' : 'opacity-75' }}">
                <div class="position-relative">
                    <img src="{{ $image->imageUrl() }}" alt="{{ $image->altText() }}" class="card-img-top" style="height: 170px; object-fit: cover;">
                    <div class="position-absolute top-0 start-0 p-2 d-flex flex-wrap gap-1">
                        <span class="badge {{ $image->status === 'published' ? 'bg-success' : 'bg-secondary' }}">{{ $image->status === 'published' ? 'Published' : 'Unpublished' }}</span>
                        @if($image->is_featured)<span class="badge bg-warning text-dark">Featured</span>@endif
                        @if($image->show_on_home)<span class="badge bg-info text-dark">Homepage #{{ $image->home_order }}</span>@endif
                    </div>
                </div>
                <div class="card-body pb-2">
                    <h6 class="card-title mb-1 text-truncate" title="{{ $image->title }}">{{ $image->title }}</h6>
                    <div class="small text-muted mb-2">{{ $image->category->name ?? 'No category' }}</div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Order</span>
                        <input type="number" min="0" class="form-control" form="order-form" name="order[{{ $image->id }}]" value="{{ $image->order }}">
                    </div>
                </div>
                <div class="card-footer bg-white d-flex flex-wrap gap-1 justify-content-between">
                    <div class="btn-group btn-group-sm">
                        <button type="submit" form="toggle-home-{{ $image->id }}" class="btn {{ $image->show_on_home ? 'btn-info text-white' : 'btn-outline-info' }}" title="{{ $image->show_on_home ? 'Remove from' : 'Add to' }} homepage carousel"><i class="fas fa-home"></i></button>
                        <button type="submit" form="toggle-status-{{ $image->id }}" class="btn {{ $image->status === 'published' ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="{{ $image->status === 'published' ? 'Unpublish' : 'Publish' }}"><i class="fas {{ $image->status === 'published' ? 'fa-eye-slash' : 'fa-eye' }}"></i></button>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.gallery.edit', $image) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <button type="submit" form="delete-{{ $image->id }}" class="btn btn-danger" title="Delete" onclick="return confirm('Delete this image?')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <form id="toggle-home-{{ $image->id }}" action="{{ route('admin.gallery.toggle', $image) }}" method="POST" class="d-none">@csrf @method('PATCH')<input type="hidden" name="field" value="show_on_home"></form>
            <form id="toggle-status-{{ $image->id }}" action="{{ route('admin.gallery.toggle', $image) }}" method="POST" class="d-none">@csrf @method('PATCH')<input type="hidden" name="field" value="status"></form>
            <form id="delete-{{ $image->id }}" action="{{ route('admin.gallery.destroy', $image) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
        </div>
        @endforeach
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 gap-2">
        <div>{{ $images->links() }}</div>
        <button type="submit" form="order-form" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Order</button>
    </div>
    @endif
</div>
@endsection
