@extends('layouts.admin')

@section('title', 'Add Team Member')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Add Team Member</h1>
            <p class="text-muted mb-0">Create a new team member</p>
        </div>
        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.team._form')
    </form>
</div>
@endsection
