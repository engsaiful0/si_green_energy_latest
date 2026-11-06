@extends('layouts.admin')

@section('title', 'Edit Gallery Image')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Gallery Image</h1>
            <p class="text-muted mb-0">{{ $image->title }}</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.gallery.update', $image) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Image Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $image->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $image->description) }}</textarea>
                            <small class="text-muted">Shown in the lightbox caption.</small>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Alt Text</label>
                            <input type="text" class="form-control @error('alt_text') is-invalid @enderror" name="alt_text" value="{{ old('alt_text', $image->alt_text) }}"
                                   placeholder="Describe the image for screen readers and search engines">
                            @error('alt_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Image</h5>
                        @include('admin.partials.image-input', ['name' => 'image', 'value' => $image->image, 'label' => 'Replace Image', 'required' => true])
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Settings</h5>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="">No category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id', $image->category_id) === (string) $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="published" @selected(old('status', $image->status) === 'published')>Published</option>
                                <option value="draft" @selected(old('status', $image->status) === 'draft')>Unpublished</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gallery Order</label>
                            <input type="number" min="0" class="form-control" name="order" value="{{ old('order', $image->order) }}">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $image->is_featured))>
                            <label class="form-check-label" for="is_featured">Featured (shown first in the gallery)</label>
                        </div>
                        <hr>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="show_on_home" value="1" id="show_on_home" @checked(old('show_on_home', $image->show_on_home))>
                            <label class="form-check-label" for="show_on_home">Show in the homepage carousel</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Homepage Order</label>
                            <input type="number" min="0" class="form-control" name="home_order" value="{{ old('home_order', $image->home_order) }}">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2"><i class="fas fa-save me-2"></i>Update Image</button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-light w-100">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
