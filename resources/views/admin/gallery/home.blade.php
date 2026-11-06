@extends('layouts.admin')

@section('title', 'Homepage Gallery Carousel')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Homepage Gallery Carousel</h1>
            <p class="text-muted mb-0">Choose which gallery images appear in the homepage carousel and in what order. Only published images are shown on the site.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary"><i class="fas fa-images me-2"></i>All Images</a>
            <a href="{{ route('home') }}#home-gallery" target="_blank" class="btn btn-outline-primary"><i class="fas fa-external-link-alt me-2"></i>View Homepage</a>
        </div>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.gallery.home.update') }}" method="POST">
        @csrf @method('PUT')

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">In the Carousel ({{ $selected->count() }})</h5>
                @if($selected->isEmpty())
                    <p class="text-muted mb-0">No images selected yet. Add some below.</p>
                @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light"><tr><th style="width: 110px;">Order</th><th>Image</th><th>Title</th><th>Status</th><th class="text-end">Keep</th></tr></thead>
                        <tbody>
                            @foreach($selected as $image)
                            <tr>
                                <td><input type="number" min="0" class="form-control form-control-sm" name="images[{{ $image->id }}][home_order]" value="{{ $image->home_order }}"></td>
                                <td><img src="{{ $image->imageUrl() }}" alt="" style="width: 90px; height: 60px; object-fit: cover; border-radius: 4px;"></td>
                                <td>{{ $image->title }}<div class="small text-muted">{{ $image->category->name ?? '' }}</div></td>
                                <td><span class="badge {{ $image->status === 'published' ? 'bg-success' : 'bg-secondary' }}">{{ $image->status === 'published' ? 'Published' : 'Unpublished (hidden)' }}</span></td>
                                <td class="text-end">
                                    <input type="hidden" name="images[{{ $image->id }}][keep]" value="0">
                                    <div class="form-check form-switch d-inline-block mb-0">
                                        <input class="form-check-input" type="checkbox" name="images[{{ $image->id }}][keep]" value="1" checked aria-label="Keep in carousel">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <small class="text-muted">Lower numbers appear first. Switch off "Keep" to remove an image from the carousel (it stays in the gallery).</small>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Add Published Images</h5>
                @if($available->isEmpty())
                    <p class="text-muted mb-0">All published images are already in the carousel.</p>
                @else
                <div class="row g-2">
                    @foreach($available as $image)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <label class="d-block border rounded p-1 h-100" style="cursor: pointer;">
                            <img src="{{ $image->imageUrl() }}" alt="" class="w-100 rounded" style="height: 90px; object-fit: cover;">
                            <span class="d-flex gap-1 align-items-start mt-1 small">
                                <input type="checkbox" class="form-check-input mt-1" name="add[]" value="{{ $image->id }}">
                                <span class="text-truncate" title="{{ $image->title }}">{{ $image->title }}</span>
                            </span>
                        </label>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Carousel</button>
        </div>
    </form>
</div>
@endsection
