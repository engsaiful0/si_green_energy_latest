@if($config['icon'] ?? false)
    @include('admin.partials.icon-picker')
@endif
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Category</h5>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                               value="{{ old('name', $category->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug"
                               value="{{ old('slug', $category->slug ?? '') }}" placeholder="Generated from the name">
                        <small class="text-muted">Used in the category URL.</small>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-0">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $category->description ?? '') }}</textarea>
                    <small class="text-muted">Also used as the meta description of the category page.</small>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Publish</h5>
                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" min="0" class="form-control @error('order') is-invalid @enderror" name="order"
                           value="{{ old('order', $category->order ?? '') }}" placeholder="Added last">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                           {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active (shown in menus and filters)</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>{{ $category ? 'Update' : 'Create' }} Category
                </button>
                <a href="{{ route($config['route'] . '.index') }}" class="btn btn-light w-100">Cancel</a>
            </div>
        </div>
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Media</h5>
                @if($config['icon'] ?? false)
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <div class="input-group">
                        <span class="input-group-text icon-preview"><i class="{{ old('icon', $category->icon ?? '') }}"></i></span>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon"
                               value="{{ old('icon', $category->icon ?? '') }}" list="flaticon-list" data-icon-input placeholder="flaticon-solar-energy">
                    </div>
                    @error('icon')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                @endif
                @include('admin.partials.image-input', [
                    'name' => 'image',
                    'value' => $category->image ?? '',
                    'label' => 'Category Image',
                    'help' => 'Used as the banner of the category page.',
                ])
            </div>
        </div>
    </div>
</div>
