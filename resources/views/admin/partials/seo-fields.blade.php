{{-- SEO card for record forms. Expects $model (or null). Fields: meta_title, meta_description. --}}
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5 class="card-title mb-1">SEO</h5>
        <p class="text-muted small mb-3">Leave empty to use the title and short description.</p>
        <div class="mb-3">
            <label class="form-label">SEO Title</label>
            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" maxlength="255"
                   value="{{ old('meta_title', $model->meta_title ?? '') }}">
            @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-0">
            <label class="form-label">Meta Description</label>
            <textarea class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" rows="2" maxlength="500">{{ old('meta_description', $model->meta_description ?? '') }}</textarea>
            <small class="text-muted">About 150-160 characters.</small>
            @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
