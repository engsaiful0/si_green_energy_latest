@extends('layouts.admin')

@section('title', 'Message from ' . $message->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $message->subject }}</h1>
            <p class="text-muted mb-0">Received {{ $message->created_at->format('F d, Y \a\t H:i') }}</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>

    @include('admin.partials.alerts')

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Message</h5>
                    <p class="mb-0" style="white-space: pre-line;">{{ $message->message }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Sender</h5>
                    <dl class="mb-0">
                        <dt>Name</dt><dd>{{ $message->name }}</dd>
                        <dt>Email</dt><dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>
                        @if($message->phone)<dt>Phone</dt><dd><a href="tel:{{ $message->phone }}">{{ $message->phone }}</a></dd>@endif
                        @if($message->ip_address)<dt>IP Address</dt><dd class="small">{{ $message->ip_address }}</dd>@endif
                        @if($message->replied_at)<dt>Replied</dt><dd class="small">{{ $message->replied_at->format('M d, Y H:i') }}</dd>@endif
                    </dl>
                    <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: ' . $message->subject) }}" class="btn btn-primary w-100 mt-3">
                        <i class="fas fa-reply me-2"></i>Reply by Email
                    </a>
                </div>
            </div>
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Status</h5>
                    <form action="{{ route('admin.contacts.update', $message) }}" method="POST" class="mb-3">
                        @csrf @method('PUT')
                        <div class="input-group">
                            <select name="status" class="form-select">
                                @foreach($statuses as $status)
                                <option value="{{ $status }}" @selected($message->status === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-outline-primary">Update</button>
                        </div>
                    </form>
                    <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100"><i class="fas fa-trash me-2"></i>Delete Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
