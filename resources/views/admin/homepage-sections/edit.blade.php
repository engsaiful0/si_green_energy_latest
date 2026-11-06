@extends('layouts.admin')

@section('title', 'Edit ' . $section->section_name)

@php
    // After a failed validation, show what the admin submitted.
    $content = array_merge($content, old('content', []));
    $fields = $definition['fields'] ?? [];
    $textFields = array_filter($fields, fn ($field) => ($field['type'] ?? 'text') !== 'image');
    $imageFields = array_filter($fields, fn ($field) => ($field['type'] ?? 'text') === 'image');
@endphp

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $section->section_name }}</h1>
            <p class="text-muted mb-0">{{ $definition['description'] ?? 'Homepage section' }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-external-link-alt me-2"></i>View Homepage
            </a>
            <a href="{{ route('admin.homepage-sections.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    @include('admin.partials.alerts')
    @include('admin.partials.icon-picker')

    <form action="{{ route('admin.homepage-sections.update', $section) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                @if(count($textFields))
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Content</h5>
                        <div class="row">
                            @foreach($textFields as $name => $field)
                            <div class="{{ in_array($field['type'] ?? 'text', ['textarea']) ? 'col-12' : 'col-md-6' }}">
                                @include('admin.homepage-sections._field', [
                                    'field' => $field,
                                    'name' => "content[{$name}]",
                                    'value' => $content[$name] ?? '',
                                ])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                @foreach($definition['repeaters'] ?? [] as $repeaterName => $repeater)
                <div class="card shadow-sm mb-3" data-repeater>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">{{ $repeater['label'] }}</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-add-row>
                                <i class="fas fa-plus me-1"></i>Add {{ $repeater['item_label'] ?? 'Item' }}
                            </button>
                        </div>

                        <div data-rows>
                            @foreach(array_values((array) ($content[$repeaterName] ?? [])) as $index => $row)
                                @include('admin.homepage-sections._repeater-row', compact('repeaterName', 'repeater', 'index', 'row'))
                            @endforeach
                        </div>
                        <p class="text-muted small mb-0" data-empty>No items yet. Use "Add {{ $repeater['item_label'] ?? 'Item' }}".</p>

                        <template data-row-template>
                            @include('admin.homepage-sections._repeater-row', ['repeaterName' => $repeaterName, 'repeater' => $repeater, 'index' => '__INDEX__', 'row' => []])
                        </template>
                    </div>
                </div>
                @endforeach

                @if(!empty($definition['manage']))
                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-info-circle me-2"></i>The items listed in this section come from their own module.</span>
                    <a href="{{ route($definition['manage']['route']) }}" class="btn btn-sm btn-info text-white">{{ $definition['manage']['label'] }}</a>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Publish</h5>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                   {{ old('is_active', $section->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Show this section on the homepage</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-2"></i>Save Section
                        </button>
                        <button type="submit" form="reset-form" class="btn btn-outline-danger w-100"
                                onclick="return confirm('Replace this section\'s content with the template defaults?')">
                            <i class="fas fa-undo me-2"></i>Restore Defaults
                        </button>
                    </div>
                </div>

                @if(count($imageFields))
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Images</h5>
                        @foreach($imageFields as $name => $field)
                            @include('admin.homepage-sections._field', [
                                'field' => $field,
                                'name' => "content[{$name}]",
                                'fileName' => "files[{$name}]",
                                'removeName' => "remove[{$name}]",
                                'value' => $content[$name] ?? '',
                            ])
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </form>

    <form id="reset-form" action="{{ route('admin.homepage-sections.reset', $section) }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-repeater]').forEach(function (repeater) {
    const rows = repeater.querySelector('[data-rows]');
    const template = repeater.querySelector('[data-row-template]');
    const empty = repeater.querySelector('[data-empty]');

    function refresh() {
        const items = rows.querySelectorAll('[data-repeater-row]');
        items.forEach(function (row, i) { row.querySelector('[data-row-number]').textContent = '#' + (i + 1); });
        empty.style.display = items.length ? 'none' : '';
    }

    repeater.querySelector('[data-add-row]').addEventListener('click', function () {
        const html = template.innerHTML.replace(/__INDEX__/g, 'n' + Date.now());
        rows.insertAdjacentHTML('beforeend', html);
        refresh();
    });

    rows.addEventListener('click', function (event) {
        const button = event.target.closest('button');
        if (!button) return;
        const row = button.closest('[data-repeater-row]');

        if (button.hasAttribute('data-remove-row')) {
            if (confirm('Remove this item?')) { row.remove(); refresh(); }
        } else if (button.dataset.move === 'up' && row.previousElementSibling) {
            row.parentNode.insertBefore(row, row.previousElementSibling);
            refresh();
        } else if (button.dataset.move === 'down' && row.nextElementSibling) {
            row.parentNode.insertBefore(row.nextElementSibling, row);
            refresh();
        }
    });

    refresh();
});
</script>
@endpush
