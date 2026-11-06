@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">General Settings</h1>
            <p class="text-muted mb-0">Logos, contact details, social links and the content of the header, sidebar and footer</p>
        </div>
        <a href="{{ route('admin.homepage-sections.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-th-large me-2"></i>Homepage Sections
        </a>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach($groups as $groupName => $fields)
            <div class="col-xl-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $groupName }}</h5>
                        @foreach($fields as $key => $field)
                            @if($field['type'] === 'image')
                                @include('admin.partials.image-input', [
                                    'name' => $key,
                                    'value' => $values[$key] ?? '',
                                    'label' => $field['label'],
                                    'help' => 'Leave as is to keep the theme image.',
                                ])
                            @else
                                <div class="mb-3">
                                    <label class="form-label" for="setting-{{ $key }}">{{ $field['label'] }}</label>
                                    @if($field['type'] === 'textarea')
                                        <textarea class="form-control @error($key) is-invalid @enderror" id="setting-{{ $key }}"
                                                  name="{{ $key }}" rows="3">{{ old($key, $values[$key] ?? '') }}</textarea>
                                    @else
                                        <input type="text" class="form-control @error($key) is-invalid @enderror" id="setting-{{ $key }}"
                                               name="{{ $key }}" value="{{ old($key, $values[$key] ?? '') }}"
                                               @if($field['type'] === 'url') placeholder="https://..." @endif>
                                    @endif
                                    @if(!empty($field['help']))<small class="text-muted">{{ $field['help'] }}</small>@endif
                                    @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <small class="text-muted">Leave a social link empty to hide its icon.</small>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
