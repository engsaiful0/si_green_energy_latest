@php
    $member = $member ?? null;
@endphp
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Member Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                               name="full_name" value="{{ old('full_name', $member->full_name ?? '') }}" required>
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Position <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror"
                               name="position" value="{{ old('position', $member->position ?? '') }}" required>
                        @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email', $member->email ?? '') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               name="phone" value="{{ old('phone', $member->phone ?? '') }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                               name="slug" value="{{ old('slug', $member->slug ?? '') }}" placeholder="Generated from the name">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Years of Experience</label>
                        <input type="number" min="0" class="form-control @error('experience_years') is-invalid @enderror"
                               name="experience_years" value="{{ old('experience_years', $member->experience_years ?? '') }}">
                        @error('experience_years')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Short Bio</label>
                        <textarea class="form-control @error('short_bio') is-invalid @enderror"
                                  name="short_bio" rows="3">{{ old('short_bio', $member->short_bio ?? '') }}</textarea>
                        @error('short_bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Social Links</h5>
                <div class="row">
                    @foreach(\App\Models\TeamMember::SOCIAL_NETWORKS as $network => $icon)
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-capitalize">{{ $network === 'twitter' ? 'X / Twitter' : $network }}</label>
                        <input type="url" class="form-control @error('social_links.' . $network) is-invalid @enderror"
                               name="social_links[{{ $network }}]" value="{{ old('social_links.' . $network, $member->social_links[$network] ?? '') }}"
                               placeholder="https://...">
                        @error('social_links.' . $network)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
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
                        <option value="active" {{ old('status', $member->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $member->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                           name="order" value="{{ old('order', $member->order ?? '') }}" min="0" placeholder="Added last">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
                           {{ old('is_featured', $member->is_featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured (shown first on the homepage)</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>{{ $member ? 'Update Member' : 'Create Member' }}
                </button>
                <a href="{{ route('admin.team.index') }}" class="btn btn-light w-100">Cancel</a>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Photo</h5>
                @include('admin.partials.image-input', [
                    'name' => 'photo',
                    'value' => $member->photo ?? '',
                    'label' => 'Photo',
                    'required' => true,
                    'help' => 'Portrait photo, approx. 300x380px.',
                ])
            </div>
        </div>
    </div>
</div>
