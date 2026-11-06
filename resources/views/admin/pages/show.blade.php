@extends('layouts.admin')

@section('title', 'View Page')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Page Details</h1>
            <p class="text-muted mb-0">View page information</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Page
            </a>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Page Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="mb-1">{{ $page->title }}</h2>
                            <p class="text-muted mb-0">
                                <code>{{ $page->slug }}</code>
                            </p>
                        </div>
                        <div>
                            @if($page->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                            @if($page->is_featured)
                                <span class="badge bg-warning text-dark">Featured</span>
                            @endif
                        </div>
                    </div>

                    @if($page->excerpt)
                        <div class="alert alert-info mb-3">
                            <strong>Excerpt:</strong> {{ $page->excerpt }}
                        </div>
                    @endif

                    @if($page->content)
                        <hr>
                        <h5>Content</h5>
                        <div class="page-content">
                            {!! nl2br(e($page->content)) !!}
                        </div>
                    @else
                        <p class="text-muted">No content</p>
                    @endif
                </div>
            </div>

            <!-- SEO Information -->
            @if($page->meta_title || $page->meta_description || $page->meta_keywords)
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-search me-2"></i>SEO Information</h5>
                    </div>
                    <div class="card-body">
                        @if($page->meta_title)
                            <p class="mb-2"><strong>Meta Title:</strong> {{ $page->meta_title }}</p>
                        @endif
                        @if($page->meta_description)
                            <p class="mb-2"><strong>Meta Description:</strong> {{ $page->meta_description }}</p>
                        @endif
                        @if($page->meta_keywords)
                            <p class="mb-0"><strong>Meta Keywords:</strong> {{ $page->meta_keywords }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Child Pages -->
            @if($page->children->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-sitemap me-2"></i>Child Pages</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($page->children as $child)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $child->title }}</strong>
                                        <br><small class="text-muted">{{ $child->slug }}</small>
                                    </div>
                                    <a href="{{ route('admin.pages.show', $child) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Page Information -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Page Information</h5>
                    <p class="mb-2"><strong>ID:</strong> #{{ $page->id }}</p>
                    <p class="mb-2"><strong>Status:</strong>
                        @if($page->status === 'published')
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </p>
                    <p class="mb-2"><strong>Featured:</strong>
                        @if($page->is_featured)
                            <span class="badge bg-warning text-dark">Yes</span>
                        @else
                            <span class="badge bg-light text-dark">No</span>
                        @endif
                    </p>
                    <p class="mb-2"><strong>Template:</strong> {{ $page->template ?? 'default' }}</p>
                    <p class="mb-2"><strong>Parent:</strong>
                        @if($page->parent)
                            <a href="{{ route('admin.pages.show', $page->parent) }}">{{ $page->parent->title }}</a>
                        @else
                            <span class="text-muted">None</span>
                        @endif
                    </p>
                    <p class="mb-2"><strong>Child Pages:</strong> {{ $page->children->count() }}</p>
                    <p class="mb-2"><strong>Created:</strong> {{ $page->created_at->format('M d, Y g:i A') }}</p>
                    <p class="mb-2"><strong>Updated:</strong> {{ $page->updated_at->format('M d, Y g:i A') }}</p>
                    <p class="mb-0"><strong>Published:</strong>
                        @if($page->published_at)
                            {{ $page->published_at->format('M d, Y g:i A') }}
                        @else
                            <span class="text-muted">Not published</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Featured Image -->
            @if($page->featured_image)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Featured Image</h5>
                        <img src="{{ $page->featured_image }}" class="img-fluid rounded" alt="{{ $page->title }}">
                    </div>
                </div>
            @endif

            <!-- Page Sections -->
            @if($page->sections->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Page Sections</h5>
                        <p class="text-muted">This page has {{ $page->sections->count() }} section(s)</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
