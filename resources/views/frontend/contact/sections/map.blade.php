@php
    // Accept either a bare embed URL or a full <iframe> snippet pasted from Google Maps.
    $embed = trim((string) $c['embed']);
    if (preg_match('/src=["\']([^"\']+)["\']/i', $embed, $match)) {
        $embed = html_entity_decode($match[1]);
    }
    $isAllowed = preg_match('#^https://(www\.)?google\.[a-z.]+/maps/embed#i', $embed);
@endphp
@if($embed && $isAllowed)
<div class="contact__two-map">
    <iframe src="{{ $embed }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map"></iframe>
</div>
@endif
