@extends('layouts.admin')

@section('title', 'Sliders')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Sliders</h1>
            <p class="text-muted mb-0">Manage homepage banner slides</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Slider
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Button</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                            <tr>
                                <td>
                                    @if($slider->background_image)
                                        <img src="{{ $slider->imageUrl() }}" alt="{{ $slider->title }}"
                                             style="width: 90px; height: 54px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $slider->title }}</strong>
                                    @if($slider->subtitle)
                                        <div class="small text-muted">{{ $slider->subtitle }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($slider->button_text)
                                        {{ $slider->button_text }}
                                        @if($slider->button_link)
                                            <div class="small text-muted">{{ $slider->button_link }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $slider->order }}</td>
                                <td>
                                    @if($slider->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" title="Delete"
                                                onclick="if(confirm('Delete this slider?')) document.getElementById('delete-{{ $slider->id }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-{{ $slider->id }}" action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No sliders found. <a href="{{ route('admin.sliders.create') }}">Create your first slider</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $sliders->links() }}</div>
        </div>
    </div>
</div>
@endsection
