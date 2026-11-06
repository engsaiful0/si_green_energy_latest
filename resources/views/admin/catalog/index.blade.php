@extends('layouts.admin')

@section('title', $config['title'])

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $config['title'] }}</h1>
            <p class="text-muted mb-0">Add, edit, publish and categorise {{ strtolower($config['title']) }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route($config['categories_route']) }}" class="btn btn-outline-secondary"><i class="fas fa-folder me-2"></i>Categories</a>
            <a href="{{ route('admin.content.index', $config['content_page']) }}" class="btn btn-outline-secondary"><i class="fas fa-th-large me-2"></i>Page Content</a>
            <a href="{{ route($config['route'] . '.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add {{ $config['singular'] }}</a>
        </div>
    </div>

    @include('admin.partials.alerts')

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="search" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((string) request('category') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Any status</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft (unpublished)</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-filter me-1"></i>Filter</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>{{ $config['singular'] }}</th>
                            <th>Category</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr>
                            <td><img src="{{ $item->imageUrl() }}" alt="" style="width: 72px; height: 50px; object-fit: cover; border-radius: 4px;"></td>
                            <td>
                                <strong>{{ $item->name }}</strong>
                                @if($item->is_featured)<span class="badge bg-warning text-dark ms-1">Featured</span>@endif
                                <div class="small text-muted">/{{ $item->slug }}</div>
                            </td>
                            <td>{{ $item->category->name ?? '-' }}</td>
                            <td>{{ $item->order }}</td>
                            <td><span class="badge {{ $item->status === 'published' ? 'bg-success' : 'bg-secondary' }}">{{ $item->status === 'published' ? 'Published' : 'Draft' }}</span></td>
                            <td class="text-end text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    @if($item->status === 'published')
                                    <a href="{{ route($config['frontend'], $item->slug) }}" target="_blank" class="btn btn-info text-white" title="View on site"><i class="fas fa-eye"></i></a>
                                    @endif
                                    <a href="{{ route($config['route'] . '.edit', $item->id) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger" title="Delete"
                                            onclick="if(confirm('Delete this {{ strtolower($config['singular']) }}?')) document.getElementById('delete-{{ $item->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-{{ $item->id }}" action="{{ route($config['route'] . '.destroy', $item->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted mb-0">Nothing found. <a href="{{ route($config['route'] . '.create') }}">Add a {{ strtolower($config['singular']) }}</a></p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $items->links() }}</div>
        </div>
    </div>
</div>
@endsection
