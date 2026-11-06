@extends('layouts.admin')

@section('title', 'Homepage Sections')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Homepage Sections</h1>
            <p class="text-muted mb-0">Edit content, change the order and show or hide each homepage section</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.settings.general') }}" class="btn btn-outline-secondary">
                <i class="fas fa-cog me-2"></i>Header & Footer
            </a>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-external-link-alt me-2"></i>View Homepage
            </a>
        </div>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.homepage-sections.arrange') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 110px;">Order</th>
                                <th>Section</th>
                                <th>Content Source</th>
                                <th style="width: 120px;">Visible</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sections as $section)
                                @php $definition = $definitions[$section->section_key]; @endphp
                                <tr class="{{ $section->is_active ? '' : 'table-secondary text-muted' }}">
                                    <td>
                                        <input type="number" class="form-control form-control-sm" min="0" max="999"
                                               name="sections[{{ $section->id }}][order]" value="{{ $section->order }}"
                                               aria-label="Order of {{ $section->section_name }}">
                                    </td>
                                    <td>
                                        <strong>{{ $section->section_name }}</strong>
                                        <div class="small text-muted">{{ $definition['description'] ?? '' }}</div>
                                    </td>
                                    <td>
                                        @if(!empty($definition['manage']))
                                            <a href="{{ route($definition['manage']['route']) }}" class="small">
                                                <i class="fas fa-link me-1"></i>{{ $definition['manage']['label'] }}
                                            </a>
                                        @else
                                            <span class="small text-muted">Section content</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                   name="sections[{{ $section->id }}][is_active]" id="active-{{ $section->id }}"
                                                   {{ $section->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="active-{{ $section->id }}">
                                                {{ $section->is_active ? 'Shown' : 'Hidden' }}
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.homepage-sections.edit', $section) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <small class="text-muted">Lower numbers appear first.</small>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Order & Visibility
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
