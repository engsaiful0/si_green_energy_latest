@extends('layouts.admin')

@section('title', 'Edit Partner')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Partner</h1>
            <p class="text-muted mb-0">Update partner details</p>
        </div>
        <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.partners._form')
    </form>
</div>
@endsection
