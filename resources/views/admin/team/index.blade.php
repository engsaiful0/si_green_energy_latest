@extends('layouts.admin')

@section('title', 'Team Members')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Team Members</h1>
            <p class="text-muted mb-0">Manage the people shown in the team section</p>
        </div>
        <a href="{{ route('admin.team.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Team Member
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $item)
                            <tr>
                                <td><img src="{{ $item->photoUrl() }}" alt="" style="width: 52px; height: 52px; object-fit: cover; border-radius: 50%;"></td>
                                <td><strong>{{ $item->full_name }}</strong>
                                    @if($item->is_featured)<span class="badge bg-warning text-dark ms-1">Featured</span>@endif</td>
                                <td>{{ $item->position }}</td>
                                <td>{{ $item->order }}</td>
                                <td><span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($item->status) }}</span></td>
                                <td class="text-end text-nowrap">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.team.edit', $item) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" title="Delete"
                                                onclick="if(confirm('Delete this team member?')) document.getElementById('delete-{{ $item->id }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-{{ $item->id }}" action="{{ route('admin.team.destroy', $item) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No team members found. <a href="{{ route('admin.team.create') }}">Add the first one</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $members->links() }}</div>
        </div>
    </div>
</div>
@endsection
