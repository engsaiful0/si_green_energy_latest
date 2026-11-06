{{-- Renders the visible CMS sections of a page. Expects $page, $sections, $data. --}}
@foreach($sections as $section)
    @include(\App\Support\PageSections::view($page, $section->section_key), [
        'c' => $section->content,
        'items' => $data[$section->section_key] ?? collect(),
    ])
@endforeach
