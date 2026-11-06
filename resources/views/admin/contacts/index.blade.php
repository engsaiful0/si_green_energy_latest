@extends('layouts.admin')

@section('title', 'Contact Messages')

@php
    $badges = ['new' => 'bg-primary', 'read' => 'bg-secondary', 'replied' => 'bg-success', 'archived' => 'bg-dark'];
@endphp

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Contact Messages</h1>
            <p class="text-muted mb-0">Messages sent from the contact page and team member pages</p>
        </div>
        <a href="{{ route('admin.content.index', 'contact') }}" class="btn btn-outline-secondary"><i class="fas fa-th-large me-2"></i>Contact Page CMS</a>
    </div>

    @include('admin.partials.alerts')

    <ul class="nav nav-pills mb-3 gap-1">
        <li class="nav-item"><a class="nav-link {{ request('status') ? '' : 'active' }}" href="{{ route('admin.contacts.index') }}">All <span class="badge bg-light text-dark">{{ $counts->sum() }}</span></a></li>
        @foreach($statuses as $status)
        <li class="nav-item"><a class="nav-link {{ request('status') === $status ? 'active' : '' }}" href="{{ route('admin.contacts.index', ['status' => $status]) }}">{{ ucfirst($status) }} <span class="badge bg-light text-dark">{{ $counts[$status] ?? 0 }}</span></a></li>
        @endforeach
    </ul>

    <form method="GET" class="mb-3" style="max-width: 420px;">
        @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Search name, email or subject..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Received</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                        <tr class="{{ $message->status === 'new' ? 'fw-semibold' : '' }}">
                            <td>
                                {{ $message->name }}
                                <div class="small text-muted">{{ $message->email }}{{ $message->phone ? ' · ' . $message->phone : '' }}</div>
                            </td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $message) }}">{{ $message->subject }}</a>
                                <div class="small text-muted">{{ \Illuminate\Support\Str::limit($message->message, 80) }}</div>
                            </td>
                            <td class="small text-nowrap">{{ $message->created_at->format('M d, Y H:i') }}</td>
                            <td><span class="badge {{ $badges[$message->status] ?? 'bg-secondary' }}">{{ ucfirst($message->status) }}</span></td>
                            <td class="text-end text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.contacts.show', $message) }}" class="btn btn-info text-white" title="Open"><i class="fas fa-eye"></i></a>
                                    <button type="button" class="btn btn-danger" title="Delete"
                                            onclick="if(confirm('Delete this message?')) document.getElementById('delete-{{ $message->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-{{ $message->id }}" action="{{ route('admin.contacts.destroy', $message) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>No messages.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $messages->links() }}</div>
        </div>
    </div>
</div>
@endsection
