{{--
    One section field. Expects: $field (definition), $name (input name), $value,
    $fileName and $removeName (image fields only).
--}}
@php
    $type = $field['type'] ?? 'text';
    $errorKey = trim(str_replace(['[', ']'], ['.', ''], $name), '.');
@endphp

@if($type === 'image')
    @include('admin.partials.image-input', [
        'name' => $name,
        'fileName' => $fileName,
        'removeName' => $removeName,
        'value' => $value,
        'label' => $field['label'],
        'help' => $field['help'] ?? null,
    ])
@else
<div class="mb-3">
    <label class="form-label">{{ $field['label'] }}</label>
    @if($type === 'longtext')
        <textarea class="form-control @error($errorKey) is-invalid @enderror" name="{{ $name }}" rows="22">{{ $value }}</textarea>
        @if(!empty($field['help']))<small class="text-muted">{{ $field['help'] }}</small>@endif
    @elseif($type === 'textarea')
        <textarea class="form-control @error($errorKey) is-invalid @enderror" name="{{ $name }}" rows="3">{{ $value }}</textarea>
        <small class="text-muted">{{ $field['help'] ?? 'Line breaks are kept.' }}</small>
    @elseif($type === 'icon')
        <div class="input-group">
            <span class="input-group-text icon-preview"><i class="{{ $value }}"></i></span>
            <input type="text" class="form-control @error($errorKey) is-invalid @enderror" name="{{ $name }}"
                   value="{{ $value }}" list="flaticon-list" data-icon-input placeholder="flaticon-solar-energy">
        </div>
        <small class="text-muted">{{ $field['help'] ?? 'Theme icon class, e.g. flaticon-solar-energy (start typing for suggestions).' }}</small>
    @elseif($type === 'number')
        <input type="number" class="form-control @error($errorKey) is-invalid @enderror" name="{{ $name }}" value="{{ $value }}" min="0" step="any">
    @else
        <input type="text" class="form-control @error($errorKey) is-invalid @enderror" name="{{ $name }}" value="{{ $value }}"
               @if($type === 'url') placeholder="/about or https://..." @endif>
        @if($type === 'url')
            <small class="text-muted">{{ $field['help'] ?? 'Site path (e.g. /quote) or full URL.' }}</small>
        @elseif(!empty($field['help']))
            <small class="text-muted">{{ $field['help'] }}</small>
        @endif
    @endif
    @error($errorKey)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>
@endif
