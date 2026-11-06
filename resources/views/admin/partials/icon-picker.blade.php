{{-- Flaticon support for icon fields: loads the theme icon font and a <datalist id="flaticon-list"> of icon classes. --}}
@once
@push('styles')
<link rel="stylesheet" href="{{ asset('font/flaticon_slaze.css') }}">
<style>
    .icon-preview { width: 42px; font-size: 1.6rem; display: inline-flex; align-items: center; justify-content: center; }
    .icon-preview i[class*="flaticon-"]:before { margin: 0; }
</style>
@endpush
@php
    $flaticonCss = public_path('font/flaticon_slaze.css');
    preg_match_all('/\.(flaticon-[a-z0-9-]+):before/', is_file($flaticonCss) ? file_get_contents($flaticonCss) : '', $iconMatches);
@endphp
<datalist id="flaticon-list">
    @foreach(array_unique($iconMatches[1]) as $iconClass)
    <option value="{{ $iconClass }}">
    @endforeach
</datalist>
@push('scripts')
<script>
    document.addEventListener('input', function (event) {
        if (event.target.matches('[data-icon-input]')) {
            const preview = event.target.closest('.input-group').querySelector('.icon-preview i');
            preview.className = event.target.value;
        }
    });
</script>
@endpush
@endonce
