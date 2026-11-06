@php
    $post = $blogPost ?? null;
    $tagsValue = old('tags_input', $post ? $post->tags->pluck('name')->implode(', ') : '');
    $publishValue = old('publish_date', optional($post?->publish_date ?? now())->format('Y-m-d\TH:i'));
@endphp
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Post Content</h5>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                               value="{{ old('title', $post->title ?? '') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">URL Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug"
                               value="{{ old('slug', $post->slug ?? '') }}" placeholder="Generated from the title">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Excerpt / Description</label>
                    <textarea class="form-control @error('excerpt') is-invalid @enderror" name="excerpt" rows="2" maxlength="500">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    <small class="text-muted">Shown on the blog list and as the highlighted quote of the post.</small>
                    @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-0">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="14" required>{{ old('content', $post->content ?? '') }}</textarea>
                    <small class="text-muted">Leave an empty line between paragraphs.</small>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        @include('admin.partials.seo-fields', ['model' => $post])
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Publish</h5>
                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="published" @selected(old('status', $post->status ?? 'published') === 'published')>Published</option>
                        <option value="draft" @selected(old('status', $post->status ?? '') === 'draft')>Draft (unpublished)</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Publication Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control @error('publish_date') is-invalid @enderror" name="publish_date"
                           value="{{ $publishValue }}" required>
                    <small class="text-muted">A future date schedules the post: it appears automatically at that time.</small>
                    @error('publish_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $post->is_featured ?? false))>
                    <label class="form-check-label" for="is_featured">Featured Post</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2"><i class="fas fa-save me-2"></i>{{ $post ? 'Update Post' : 'Create Post' }}</button>
                <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-light w-100">Cancel</a>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Post Details</h5>
                <div class="mb-3">
                    <label class="form-label">Author <span class="text-danger">*</span></label>
                    <select class="form-select @error('author_id') is-invalid @enderror" name="author_id" required>
                        @foreach($authors as $author)
                        <option value="{{ $author->id }}" @selected((string) old('author_id', $post->author_id ?? auth()->id()) === (string) $author->id)>{{ $author->name }}</option>
                        @endforeach
                    </select>
                    @error('author_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                        <option value="">No category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $post->category_id ?? '') === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <small><a href="{{ route('admin.blog-categories.index') }}" target="_blank">Manage categories</a></small>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Tags</label>
                    <input type="text" class="form-control @error('tags_input') is-invalid @enderror" name="tags_input"
                           value="{{ $tagsValue }}" placeholder="solar, maintenance, batteries" list="blog-tags">
                    <datalist id="blog-tags">
                        @foreach($tags as $tag)<option value="{{ $tag->name }}">@endforeach
                    </datalist>
                    <small class="text-muted">Comma separated. New tags are created automatically.</small>
                    @error('tags_input')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-0">
                    <label class="form-label">Reading Time (minutes)</label>
                    <input type="number" min="1" max="600" class="form-control @error('reading_time') is-invalid @enderror" name="reading_time"
                           value="{{ old('reading_time', $post->reading_time ?? '') }}" placeholder="Calculated automatically">
                    @error('reading_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Featured Image</h5>
                @include('admin.partials.image-input', ['name' => 'featured_image', 'value' => $post->featured_image ?? '', 'label' => 'Image', 'required' => true])
            </div>
        </div>
    </div>
</div>
