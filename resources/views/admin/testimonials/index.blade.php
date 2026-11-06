@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Testimonials</h1>
            <p class="text-muted mb-0">Manage client reviews</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Testimonial
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Client</th>
                            <th>Testimonial</th>
                            <th>Rating</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $item)
                            <tr>
                                <td class="text-nowrap">
                                    @if($item->avatar)<img src="{{ $item->avatarUrl() }}" alt="" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">@endif
                                    <strong>{{ $item->client_name }}</strong>
                                    <div class="small text-muted">{{ $item->byline() }}</div></td>
                                <td class="small">{{ \Illuminate\Support\Str::limit($item->testimonial, 90) }}
                                    @if($item->is_featured)<span class="badge bg-warning text-dark ms-1">Featured</span>@endif</td>
                                <td class="text-nowrap text-warning">{!! str_repeat('<i class="fas fa-star"></i>', $item->rating) !!}</td>
                                <td>{{ $item->order }}</td>
                                <td><span class="badge {{ $item->status === 'approved' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($item->status) }}</span></td>
                                <td class="text-end text-nowrap">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.testimonials.edit', $item) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" title="Delete"
                                                onclick="if(confirm('Delete this testimonial?')) document.getElementById('delete-{{ $item->id }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-{{ $item->id }}" action="{{ route('admin.testimonials.destroy', $item) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No testimonials found. <a href="{{ route('admin.testimonials.create') }}">Add the first one</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $testimonials->links() }}</div>
        </div>
    </div>
</div>
@endsection
