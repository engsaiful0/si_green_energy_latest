@php
    $partner = $partner ?? null;
@endphp
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Partner Information</h5>
                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name', $partner->name ?? '') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Website</label>
                    <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                           name="website_url" value="{{ old('website_url', $partner->website_url ?? '') }}" placeholder="https://...">
                    <small class="text-muted">The logo links here when set.</small>
                    @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-0">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              name="description" rows="3">{{ old('description', $partner->description ?? '') }}</textarea>
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
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="active" {{ old('status', $partner->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $partner->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                           name="order" value="{{ old('order', $partner->order ?? '') }}" min="0" placeholder="Added last">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
                           {{ old('is_featured', $partner->is_featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>{{ $partner ? 'Update Partner' : 'Create Partner' }}
                </button>
                <a href="{{ route('admin.partners.index') }}" class="btn btn-light w-100">Cancel</a>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Logos</h5>
                @include('admin.partials.image-input', [
                    'name' => 'logo',
                    'value' => $partner->logo ?? '',
                    'label' => 'Logo',
                    'required' => true,
                    'help' => 'Transparent PNG works best.',
                ])
                @include('admin.partials.image-input', [
                    'name' => 'logo_dark',
                    'value' => $partner->logo_dark ?? '',
                    'label' => 'Dark Mode Logo',
                ])
            </div>
        </div>
    </div>
</div>
