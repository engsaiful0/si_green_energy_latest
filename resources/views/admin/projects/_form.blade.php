@php
    $project = $project ?? null;
@endphp
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Project Information</h5>

                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name', $project->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                               name="slug" value="{{ old('slug', $project->slug ?? '') }}" placeholder="Generated from the name">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Short Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('short_description') is-invalid @enderror"
                              name="short_description" rows="2" required>{{ old('short_description', $project->short_description ?? '') }}</textarea>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-0">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              name="description" rows="6">{{ old('description', $project->description ?? '') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Project Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Client</label>
                        <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                               name="client_name" value="{{ old('client_name', $project->client_name ?? '') }}">
                        @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror"
                               name="location" value="{{ old('location', $project->location ?? '') }}">
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Project Date</label>
                        <input type="date" class="form-control @error('project_date') is-invalid @enderror"
                               name="project_date" value="{{ old('project_date', optional($project?->project_date)->format('Y-m-d')) }}">
                        @error('project_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Project Link</label>
                        <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                               name="website_url" value="{{ old('website_url', $project->website_url ?? '') }}" placeholder="https://...">
                        <small class="text-muted">Where the gallery card links to (optional).</small>
                        @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Budget ($)</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('budget') is-invalid @enderror"
                               name="budget" value="{{ old('budget', $project->budget ?? '') }}">
                        @error('budget')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Video URL</label>
                        <input type="url" class="form-control @error('video_url') is-invalid @enderror"
                               name="video_url" value="{{ old('video_url', $project->video_url ?? '') }}">
                        @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
            <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Challenge, Solution & Results</h5>
                @foreach(['challenge' => 'The Challenge', 'solution' => 'The Solution', 'results' => 'The Results'] as $field => $label)
                <div class="mb-3">
                    <label class="form-label">{{ $label }}</label>
                    <textarea class="form-control @error($field) is-invalid @enderror" name="{{ $field }}" rows="4">{{ old($field, $project->{$field} ?? '') }}</textarea>
                    @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endforeach
                <small class="text-muted">Shown on the project details page; empty blocks are hidden.</small>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Gallery</h5>
                @if($project && $project->images->isNotEmpty())
                <div class="row g-3 mb-3">
                    @foreach($project->images as $image)
                    <div class="col-md-4">
                        <div class="border rounded p-2 h-100">
                            <img src="{{ $image->imageUrl() }}" alt="" class="w-100 rounded mb-2" style="height: 110px; object-fit: cover;">
                            <input type="text" class="form-control form-control-sm mb-1" name="gallery[{{ $image->id }}][alt_text]"
                                   value="{{ old('gallery.' . $image->id . '.alt_text', $image->alt_text) }}" placeholder="Caption / alt text">
                            <div class="d-flex gap-1">
                                <input type="number" min="0" class="form-control form-control-sm" name="gallery[{{ $image->id }}][order]"
                                       value="{{ old('gallery.' . $image->id . '.order', $image->order) }}" title="Order">
                                <button type="submit" form="delete-image-{{ $image->id }}" class="btn btn-sm btn-outline-danger" title="Remove"
                                        onclick="return confirm('Remove this image?')"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                <label class="form-label">Add Images</label>
                <input type="file" class="form-control @error('gallery_files') is-invalid @enderror @error('gallery_files.*') is-invalid @enderror"
                       name="gallery_files[]" accept="image/*" multiple>
                <small class="text-muted">Select several images at once (max 20, 4 MB each).</small>
                @error('gallery_files')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @error('gallery_files.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        @include('admin.partials.seo-fields', ['model' => $project])
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Publish</h5>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="published" {{ old('status', $project->status ?? 'published') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status', $project->status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
                           {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured (shown first on the homepage)</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>{{ $project ? 'Update Project' : 'Create Project' }}
                </button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-light w-100">Cancel</a>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Category</h5>
                <div class="mb-3">
                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                        <option value="">No category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) old('category_id', $project->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-0">
                    <input type="text" class="form-control form-control-sm @error('new_category') is-invalid @enderror"
                           name="new_category" value="{{ old('new_category') }}" placeholder="...or type a new category">
                    <small class="text-muted">Shown above the project name on the gallery card.</small>
                    @error('new_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Image</h5>
                @include('admin.partials.image-input', [
                    'name' => 'featured_image',
                    'value' => $project->featured_image ?? '',
                    'label' => 'Featured Image',
                    'required' => true,
                    'help' => 'Portrait images work best (approx. 420x560px).',
                ])
            </div>
        </div>
    </div>
</div>
