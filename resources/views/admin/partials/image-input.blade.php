{{--
    Image field: preview + upload + (optional) path + remove.

    @include('admin.partials.image-input', [
        'name'     => 'photo',              // form field holding the stored path
        'fileName' => 'photo_file',         // upload input name (default: "{name}_file")
        'value'    => $model->photo ?? '',  // current stored path
        'label'    => 'Photo',
        'required' => false,
        'removable'=> true,                 // show "remove image" checkbox (default: !required)
    ])
--}}
@php
    $fileName = $fileName ?? $name . '_file';
    $removeName = $removeName ?? 'remove_' . $name;
    $errorKey = trim(str_replace(['[', ']'], ['.', ''], $name), '.');
    $fileErrorKey = trim(str_replace(['[', ']'], ['.', ''], $fileName), '.');
    $current = old($errorKey, $value ?? '');
    $required = $required ?? false;
    $removable = $removable ?? !$required;
    $inputId = 'img_' . md5($name . microtime());
@endphp
<div class="mb-3 image-input" data-image-input>
    <label class="form-label">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>

    <div class="d-flex gap-3 align-items-start">
        <div class="image-input-preview border rounded bg-light d-flex align-items-center justify-content-center flex-shrink-0"
             style="width: 96px; height: 72px; overflow: hidden;">
            <img src="{{ \App\Support\Media::url($current) }}" alt="" data-preview
                 style="max-width: 100%; max-height: 100%; object-fit: contain; {{ $current ? '' : 'display:none;' }}">
            <i class="fas fa-image text-muted" data-placeholder style="{{ $current ? 'display:none;' : '' }}"></i>
        </div>
        <div class="flex-grow-1">
            <input type="file" class="form-control form-control-sm mb-2 @error($fileErrorKey) is-invalid @enderror"
                   name="{{ $fileName }}" accept="image/*" data-file id="{{ $inputId }}">
            @error($fileErrorKey)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

            <input type="text" class="form-control form-control-sm @error($errorKey) is-invalid @enderror"
                   name="{{ $name }}" value="{{ $current }}" placeholder="Upload a file or enter a path / URL" data-path>
            @error($errorKey)<div class="invalid-feedback">{{ $message }}</div>@enderror

            <div class="d-flex justify-content-between mt-1">
                <small class="text-muted">{{ $help ?? 'JPG, PNG, GIF or WEBP, max 4 MB.' }}</small>
                @if($removable && $current)
                <div class="form-check form-check-inline small mb-0 me-0">
                    <input class="form-check-input" type="checkbox" name="{{ $removeName }}" value="1" id="{{ $inputId }}_remove">
                    <label class="form-check-label text-danger" for="{{ $inputId }}_remove">Remove</label>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    // Live preview for image inputs (also used by repeater rows added later).
    document.addEventListener('change', function (event) {
        const input = event.target;
        if (!input.matches('[data-image-input] [data-file]') || !input.files.length) {
            return;
        }
        const wrapper = input.closest('[data-image-input]');
        const preview = wrapper.querySelector('[data-preview]');
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = '';
        wrapper.querySelector('[data-placeholder]').style.display = 'none';
    });
</script>
@endpush
@endonce
