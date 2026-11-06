@extends('layouts.admin')

@section('title', 'Content References')

@push('styles')
<style>
    .references-body h1 { font-size: 1.6rem; margin-bottom: 1rem; }
    .references-body h2 { font-size: 1.25rem; margin-top: 1.75rem; padding-bottom: .4rem; border-bottom: 1px solid #e5e7eb; }
    .references-body h3 { font-size: 1.05rem; margin-top: 1.25rem; }
    .references-body li { margin-bottom: .35rem; }
    .references-body a { word-break: break-all; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Content References</h1>
            <p class="text-muted mb-0">Sources used for the initial website content, and items to review before launch</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body references-body">
            {!! $html !!}
        </div>
    </div>
</div>
@endsection
