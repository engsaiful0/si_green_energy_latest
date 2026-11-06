@extends('layouts.admin')

@section('title', 'View Service')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $service->name }}</h1>
            <p class="text-muted mb-0">Service Details</p>
        </div>
        <div>
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Service Information</h5>

                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Name:</th>
                            <td>{{ $service->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td><code>{{ $service->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td>
                                @if($service->category)
                                    <span class="badge bg-info">{{ $service->category->name }}</span>
                                @else
                                    <span class="text-muted">No category</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td>{{ $service->price ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($service->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                                @if($service->is_featured)
                                    <span class="badge bg-warning text-dark ms-2">Featured</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($service->short_description)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Short Description</h5>
                    <p class="mb-0">{{ $service->short_description }}</p>
                </div>
            </div>
            @endif

            @if($service->description)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Description</h5>
                    <div class="content-preview">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                </div>
            </div>
            @endif

            @if($service->features)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Features</h5>
                    <div class="content-preview">
                        {!! nl2br(e($service->features)) !!}
                    </div>
                </div>
            </div>
            @endif

            @if($service->images && $service->images->count() > 0)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Gallery Images ({{ $service->images->count() }})</h5>
                    <div class="row">
                        @foreach($service->images as $image)
                        <div class="col-md-3 mb-2">
                            <img src="{{ asset($image->image_path) }}" class="img-fluid rounded" alt="Service Image">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            @if($service->featured_image)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Featured Image</h5>
                    <img src="{{ asset($service->featured_image) }}" class="img-fluid rounded" alt="{{ $service->name }}">
                </div>
            </div>
            @endif

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Metadata</h5>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th>Created:</th>
                            <td>{{ $service->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated:</th>
                            <td>{{ $service->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @if($service->deleted_at)
                        <tr>
                            <th>Deleted:</th>
                            <td class="text-danger">{{ $service->deleted_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Actions</h5>
                    <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="btn btn-success w-100 mb-2">
                        <i class="fas fa-external-link-alt me-2"></i>View on Frontend
                    </a>
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i>Delete Service
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $service->name }}</strong>?
                This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
