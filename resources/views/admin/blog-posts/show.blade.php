@extends('layouts.admin')

@section('title', 'View Blog Post')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $blogPost->title }}</h1>
            <p class="text-muted mb-0">Blog Post Details</p>
        </div>
        <div>
            <a href="{{ route('admin.blog-posts.edit', $blogPost) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Post Information</h5>

                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Title:</th>
                            <td>{{ $blogPost->title }}</td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td><code>{{ $blogPost->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td>
                                @if($blogPost->category)
                                    <span class="badge bg-info">{{ $blogPost->category->name }}</span>
                                @else
                                    <span class="text-muted">No category</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Author:</th>
                            <td>
                                @if($blogPost->author)
                                    {{ $blogPost->author->name }}
                                    <br><small class="text-muted">{{ $blogPost->author->email }}</small>
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($blogPost->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                                @if($blogPost->is_featured)
                                    <span class="badge bg-warning text-dark ms-2">Featured</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tags:</th>
                            <td>
                                @if($blogPost->tags && $blogPost->tags->count() > 0)
                                    @foreach($blogPost->tags as $tag)
                                        <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No tags</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($blogPost->excerpt)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Excerpt</h5>
                    <p class="mb-0">{{ $blogPost->excerpt }}</p>
                </div>
            </div>
            @endif

            @if($blogPost->content)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Content</h5>
                    <div class="content-preview">
                        {!! nl2br(e($blogPost->content)) !!}
                    </div>
                </div>
            </div>
            @endif

            @if($blogPost->meta_title || $blogPost->meta_description)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">SEO Settings</h5>
                    @if($blogPost->meta_title)
                        <p class="mb-2"><strong>Meta Title:</strong> {{ $blogPost->meta_title }}</p>
                    @endif
                    @if($blogPost->meta_description)
                        <p class="mb-0"><strong>Meta Description:</strong> {{ $blogPost->meta_description }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            @if($blogPost->featured_image)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Featured Image</h5>
                    <img src="{{ asset($blogPost->featured_image) }}" class="img-fluid rounded" alt="{{ $blogPost->title }}">
                </div>
            </div>
            @endif

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Metadata</h5>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th>Created:</th>
                            <td>{{ $blogPost->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated:</th>
                            <td>{{ $blogPost->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @if($blogPost->published_at)
                        <tr>
                            <th>Published:</th>
                            <td>{{ $blogPost->published_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @endif
                        @if($blogPost->deleted_at)
                        <tr>
                            <th>Deleted:</th>
                            <td class="text-danger">{{ $blogPost->deleted_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Actions</h5>
                    @if($blogPost->status === 'published')
                        <a href="{{ route('blog.show', $blogPost->slug) }}" target="_blank" class="btn btn-success w-100 mb-2">
                            <i class="fas fa-external-link-alt me-2"></i>View on Frontend
                        </a>
                    @else
                        <button class="btn btn-success w-100 mb-2" disabled>
                            <i class="fas fa-external-link-alt me-2"></i>View on Frontend (Draft)
                        </button>
                    @endif
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i>Delete Post
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $blogPost->title }}</strong>?
                This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.blog-posts.destroy', $blogPost) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
