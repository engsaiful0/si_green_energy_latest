@extends('layouts.admin')

@section('title', 'Upload Gallery Images')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Upload Gallery Images</h1>
            <p class="text-muted mb-0">Select several images at once; the settings below apply to all of them</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Images <span class="text-danger">*</span></h5>
                        <input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                               name="images[]" id="gallery-files" accept="image/*" multiple required>
                        <small class="text-muted">Up to 30 images, JPG/PNG/GIF/WEBP, max 4 MB each.</small>
                        @error('images')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        @error('images.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <div class="row g-2 mt-2" id="gallery-previews"></div>
                    </div>
                </div>
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}"
                                   placeholder="Leave empty to use each file name">
                            <small class="text-muted">With several images, a number is added to each title.</small>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Settings</h5>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id">
                                <option value="">No category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
                                <option value="draft" @selected(old('status') === 'draft')>Unpublished</option>
                            </select>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured'))>
                            <label class="form-check-label" for="is_featured">Featured (shown first in the gallery)</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="show_on_home" value="1" id="show_on_home" @checked(old('show_on_home'))>
                            <label class="form-check-label" for="show_on_home">Show in the homepage carousel</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-upload me-2"></i>Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('gallery-files').addEventListener('change', function () {
        const previews = document.getElementById('gallery-previews');
        previews.innerHTML = '';
        Array.from(this.files).forEach(function (file) {
            const col = document.createElement('div');
            col.className = 'col-3';
            col.innerHTML = '<img class="w-100 rounded border" style="height:90px;object-fit:cover" alt="">';
            col.querySelector('img').src = URL.createObjectURL(file);
            previews.appendChild(col);
        });
    });
</script>
@endpush
