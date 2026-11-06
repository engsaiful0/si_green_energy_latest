@php
    $testimonial = $testimonial ?? null;
@endphp
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Testimonial</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Client Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                               name="client_name" value="{{ old('client_name', $testimonial->client_name ?? '') }}" required>
                        @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <select class="form-select @error('rating') is-invalid @enderror" name="rating" required>
                            @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ (int) old('rating', $testimonial->rating ?? 5) === $i ? 'selected' : '' }}>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror"
                               name="position" value="{{ old('position', $testimonial->position ?? '') }}" placeholder="CEO">
                        @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror"
                               name="company" value="{{ old('company', $testimonial->company ?? '') }}">
                        @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Testimonial <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('testimonial') is-invalid @enderror"
                                  name="testimonial" rows="5" required>{{ old('testimonial', $testimonial->testimonial ?? '') }}</textarea>
                        @error('testimonial')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
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
                        <option value="approved" {{ old('status', $testimonial->status ?? 'approved') === 'approved' ? 'selected' : '' }}>Approved (visible)</option>
                        <option value="pending" {{ old('status', $testimonial->status ?? '') === 'pending' ? 'selected' : '' }}>Pending (hidden)</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                           name="order" value="{{ old('order', $testimonial->order ?? '') }}" min="0" placeholder="Added last">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
                           {{ old('is_featured', $testimonial->is_featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured (shown first on the homepage)</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>{{ $testimonial ? 'Update Testimonial' : 'Create Testimonial' }}
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light w-100">Cancel</a>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Images</h5>
                @include('admin.partials.image-input', [
                    'name' => 'avatar',
                    'value' => $testimonial->avatar ?? '',
                    'label' => 'Client Photo',
                ])
                @include('admin.partials.image-input', [
                    'name' => 'company_logo',
                    'value' => $testimonial->company_logo ?? '',
                    'label' => 'Company Logo',
                ])
            </div>
        </div>
    </div>
</div>
