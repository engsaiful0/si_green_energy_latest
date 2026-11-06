@extends('layouts.admin')

@section('title', 'Edit Team Member')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Team Member</h1>
            <p class="text-muted mb-0">Update team member details</p>
        </div>
        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.team.update', $member) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.team._form')
    </form>
</div>
@endsection
