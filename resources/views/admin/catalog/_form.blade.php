@if($config['icon'])
    @include('admin.partials.icon-picker')
@endif
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ $config['singular'] }} Information</h5>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                               value="{{ old('name', $item->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">URL Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug"
                               value="{{ old('slug', $item->slug ?? '') }}" placeholder="Generated from the name">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Short Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('short_description') is-invalid @enderror" name="short_description" rows="2" required>{{ old('short_description', $item->short_description ?? '') }}</textarea>
                    <small class="text-muted">Shown on listing cards.</small>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Details</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="8">{{ old('description', $item->description ?? '') }}</textarea>
                    <small class="text-muted">Leave an empty line between paragraphs.</small>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-0">
                    <label class="form-label">Features</label>
                    <textarea class="form-control @error('features') is-invalid @enderror" name="features" rows="4"
                              placeholder="One feature per line">{{ old('features', $item ? implode("\n", $item->featureList()) : '') }}</textarea>
                    @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        @if($config['manufacturer'] ?? false)
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-1">Manufacturer</h5>
                <p class="text-muted small mb-3">Only enter details confirmed by the manufacturer's website or datasheet.</p>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Brand / Manufacturer</label>
                        <input type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ old('brand', $item->brand ?? '') }}">
                        @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-7 mb-3">
                        <label class="form-label">Model / Series</label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ old('model', $item->model ?? '') }}">
                        @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @foreach(['manufacturer_url' => 'Official Manufacturer URL', 'datasheet_url' => 'Datasheet URL', 'source_url' => 'Source URL (where the information was verified)'] as $urlField => $urlLabel)
                    <div class="col-12 mb-3">
                        <label class="form-label">{{ $urlLabel }}</label>
                        <input type="url" class="form-control @error($urlField) is-invalid @enderror" name="{{ $urlField }}" value="{{ old($urlField, $item->{$urlField} ?? '') }}" placeholder="https://...">
                        @error($urlField)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if(!empty($config['list_fields']) || ($config['specifications'] ?? false))
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Additional Information</h5>
                @foreach($config['list_fields'] ?? [] as $listField => $listLabel)
                <div class="mb-3">
                    <label class="form-label">{{ $listLabel }}</label>
                    <textarea class="form-control @error($listField) is-invalid @enderror" name="{{ $listField }}" rows="4"
                              placeholder="One per line">{{ old($listField, implode(PHP_EOL, (array) ($item->{$listField} ?? []))) }}</textarea>
                    @error($listField)<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endforeach
                @if($config['specifications'] ?? false)
                <div class="mb-0">
                    <label class="form-label">Technical Specifications</label>
                    <textarea class="form-control @error('specifications') is-invalid @enderror" name="specifications" rows="6"
                              placeholder="One per line, e.g. Cell technology: Monocrystalline">{{ old('specifications', collect($item->specifications ?? [])->map(fn ($spec) => ($spec['label'] ?? '') . ': ' . ($spec['value'] ?? ''))->implode(PHP_EOL)) }}</textarea>
                    <small class="text-muted">Format <code>Label: value</code>. Only enter values confirmed by the manufacturer's datasheet.</small>
                    @error('specifications')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endif
            </div>
        </div>
        @endif

        @include('admin.partials.seo-fields', ['model' => $item])
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Publish</h5>
                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="published" @selected(old('status', $item->status ?? 'published') === 'published')>Published</option>
                        <option value="draft" @selected(old('status', $item->status ?? '') === 'draft')>Draft (unpublished)</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" min="0" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order', $item->order ?? 0) }}">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
                           @checked(old('is_featured', $item->is_featured ?? false))>
                    <label class="form-check-label" for="is_featured">Featured (listed first)</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2"><i class="fas fa-save me-2"></i>{{ $item ? 'Update' : 'Create' }} {{ $config['singular'] }}</button>
                <a href="{{ route($config['route'] . '.index') }}" class="btn btn-light w-100">Cancel</a>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Details</h5>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                        <option value="">No category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $item->category_id ?? '') === (string) $category->id)>{{ $category->name }}{{ $category->is_active ? '' : ' (inactive)' }}</option>
                        @endforeach
                    </select>
                    <small><a href="{{ route($config['categories_route']) }}" target="_blank">Manage categories</a></small>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @if($config['icon'])
                <div class="mb-3">
                    <label class="form-label">Icon @if($config['icon'] === 'required')<span class="text-danger">*</span>@endif</label>
                    <div class="input-group">
                        <span class="input-group-text icon-preview"><i class="{{ old('icon', $item->icon ?? 'flaticon-solar-energy') }}"></i></span>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" list="flaticon-list" data-icon-input
                               value="{{ old('icon', $item->icon ?? 'flaticon-solar-energy') }}" @if($config['icon'] === 'required') required @endif>
                    </div>
                    @error('icon')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                @endif
                @if($config['price'])
                <div class="mb-0">
                    <label class="form-label">{{ $config['price'] === 'price_from' ? 'Price From ($)' : 'Price ($)' }}</label>
                    <input type="number" step="0.01" min="0" class="form-control @error($config['price']) is-invalid @enderror"
                           name="{{ $config['price'] }}" value="{{ old($config['price'], $item?->getRawOriginal($config['price'])) }}">
                    @error($config['price'])<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Image</h5>
                @include('admin.partials.image-input', ['name' => 'featured_image', 'value' => $item->featured_image ?? '', 'label' => 'Featured Image', 'required' => true])
            </div>
        </div>
    </div>
</div>
