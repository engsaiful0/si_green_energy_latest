{{-- Call-to-action of a CMS page ("Call to Action" section in its admin CMS). Expects $page. --}}
@php
    $ctaSection = \App\Support\PageSections::sections($page)->firstWhere('section_key', \App\Support\PageSections::CTA);
@endphp
@if($ctaSection && $ctaSection->is_active)
    @include('frontend.partials.cta', ['c' => $ctaSection->content])
@endif
