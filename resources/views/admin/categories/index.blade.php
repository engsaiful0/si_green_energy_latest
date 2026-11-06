@extends('layouts.admin')

@section('title', $config['title'])

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $config['title'] }}</h1>
            <p class="text-muted mb-0">Group {{ $config['items'] }} and build the frontend category menu</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route($config['items_route']) }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-2"></i>{{ ucfirst($config['items']) }}
            </a>
            <a href="{{ route($config['route'] . '.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add {{ $config['singular'] }}
            </a>
        </div>
    </div>

    @include('admin.partials.alerts')

    <form method="GET" class="mb-3" style="max-width: 360px;">
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Search categories..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>{{ ucfirst($config['items']) }}</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>
                                @if($category->image)
                                    <img src="{{ $category->imageUrl() }}" alt="" style="width: 64px; height: 44px; object-fit: cover; border-radius: 4px;">
                                @elseif($category->icon ?? null)
                                    <span class="text-muted">{{ $category->icon }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $category->name }}</strong>
                                @if($category->description)<div class="small text-muted">{{ \Illuminate\Support\Str::limit($category->description, 70) }}</div>@endif
                            </td>
                            <td class="small">
                                @if(!empty($config['frontend']))
                                    <a href="{{ route($config['frontend'], $category->slug) }}" target="_blank">{{ $category->slug }}</a>
                                @else
                                    {{ $category->slug }}
                                @endif
                            </td>
                            <td><span class="badge bg-info">{{ $category->items_count }}</span></td>
                            <td>{{ $category->order }}</td>
                            <td>
                                <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td class="text-end text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route($config['route'] . '.edit', $category->id) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger" title="{{ $category->items_count ? 'Reassign its ' . $config['items'] . ' first' : 'Delete' }}"
                                            onclick="if(confirm('Delete this category?')) document.getElementById('delete-{{ $category->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-{{ $category->id }}" action="{{ route($config['route'] . '.destroy', $category->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No categories yet. <a href="{{ route($config['route'] . '.create') }}">Add the first one</a></p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $categories->links() }}</div>
        </div>
    </div>
</div>
@endsection
