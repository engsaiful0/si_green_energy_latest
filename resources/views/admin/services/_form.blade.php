@php
    $service = $service ?? null;
@endphp
@include('admin.partials.icon-picker')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Service Information</h5>

                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $service->name ?? '') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                           id="slug" name="slug" value="{{ old('slug', $service->slug ?? '') }}">
                    <small class="text-muted">Used in the URL. Leave empty to generate it from the name.</small>
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Short Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('short_description') is-invalid @enderror"
                              name="short_description" rows="2" required>{{ old('short_description', $service->short_description ?? '') }}</textarea>
                    <small class="text-muted">Shown on the homepage service cards.</small>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              name="description" rows="6">{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-0">
                    <label class="form-label">Features</label>
                    <textarea class="form-control @error('features') is-invalid @enderror"
                              name="features" rows="4" placeholder="Enter key features, one per line">{{ old('features', $service->features ?? '') }}</textarea>
                    @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Publish</h5>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="draft" {{ old('status', $service->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $service->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                           name="order" value="{{ old('order', $service->order ?? 0) }}" min="0">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
                           {{ old('is_featured', $service->is_featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured (shown first on the homepage)</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>{{ $service ? 'Update Service' : 'Create Service' }}
                </button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-light w-100">Cancel</a>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Service Details</h5>

                <div class="mb-3">
                    <label class="form-label">Icon <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text icon-preview"><i class="{{ old('icon', $service->icon ?? 'flaticon-solar-energy') }}"></i></span>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon"
                               value="{{ old('icon', $service->icon ?? 'flaticon-solar-energy') }}" list="flaticon-list" data-icon-input required>
                    </div>
                    @error('icon')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                        <option value="">No category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) old('category_id', $service->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-0">
                    <label class="form-label">Price From ($)</label>
                    <input type="number" step="0.01" min="0" class="form-control @error('price_from') is-invalid @enderror"
                           name="price_from" value="{{ old('price_from', $service->price_from ?? '') }}">
                    @error('price_from')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Featured Image</h5>
                @include('admin.partials.image-input', [
                    'name' => 'featured_image',
                    'value' => $service->featured_image ?? '',
                    'label' => 'Image',
                    'required' => true,
                ])
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Fill the slug from the name until the slug is edited by hand.
    (function () {
        const name = document.getElementById('name');
        const slug = document.getElementById('slug');
        let touched = slug.value !== '';
        slug.addEventListener('input', () => touched = true);
        name.addEventListener('input', function () {
            if (!touched) {
                slug.value = name.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-');
            }
        });
    })();
</script>
@endpush
