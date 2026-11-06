@extends('layouts.admin')

@section('title', 'Partners')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Partners</h1>
            <p class="text-muted mb-0">Manage partner logos shown in the brand slider</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Partner
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Website</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $item)
                            <tr>
                                <td><img src="{{ $item->logoUrl() }}" alt="" class="bg-light p-1 rounded" style="width: 110px; height: 48px; object-fit: contain;"></td>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td class="small">@if($item->website_url)<a href="{{ $item->website_url }}" target="_blank" rel="noopener">{{ $item->website_url }}</a>@else - @endif</td>
                                <td>{{ $item->order }}</td>
                                <td><span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($item->status) }}</span></td>
                                <td class="text-end text-nowrap">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.partners.edit', $item) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" title="Delete"
                                                onclick="if(confirm('Delete this partner?')) document.getElementById('delete-{{ $item->id }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-{{ $item->id }}" action="{{ route('admin.partners.destroy', $item) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No partners found. <a href="{{ route('admin.partners.create') }}">Add the first one</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $partners->links() }}</div>
        </div>
    </div>
</div>
@endsection
