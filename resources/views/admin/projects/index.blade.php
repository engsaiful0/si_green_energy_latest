@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Projects</h1>
            <p class="text-muted mb-0">Manage the project gallery</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Project
        </a>
    </div>

    @include('admin.partials.alerts')

    <form method="GET" class="mb-3" style="max-width: 360px;">
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Search projects..." value="{{ request('search') }}">
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
                            <th>Project</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $item)
                            <tr>
                                <td><img src="{{ $item->imageUrl() }}" alt="" style="width: 70px; height: 52px; object-fit: cover; border-radius: 4px;"></td>
                                <td><strong>{{ $item->name }}</strong>
                                    @if($item->is_featured)<span class="badge bg-warning text-dark ms-1">Featured</span>@endif
                                    <div class="small text-muted">{{ collect([$item->client_name, $item->location])->filter()->implode(' / ') }}</div></td>
                                <td>{{ $item->category->name ?? '-' }}</td>
                                <td><span class="badge {{ $item->status === 'published' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($item->status) }}</span></td>
                                <td class="text-end text-nowrap">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.projects.edit', $item) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" title="Delete"
                                                onclick="if(confirm('Delete this project?')) document.getElementById('delete-{{ $item->id }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-{{ $item->id }}" action="{{ route('admin.projects.destroy', $item) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No projects found. <a href="{{ route('admin.projects.create') }}">Add the first one</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $projects->links() }}</div>
        </div>
    </div>
</div>
@endsection
