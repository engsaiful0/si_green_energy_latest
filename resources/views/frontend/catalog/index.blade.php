@extends('layouts.frontend')

@section('content')
@include('frontend.partials.breadcrumb', [
    'title' => $title,
    'image' => $banner,
    'crumbs' => $category ? [['label' => $catalog['label'], 'url' => route($catalog['prefix'] . '.index')]] : [],
])

{{-- Sections, their order and visibility are managed in Admin > {{ $catalog['label'] }} Page CMS. --}}
@foreach($sections as $section)
    @include(\App\Support\PageSections::view($page, $section->section_key), [
        'c' => $section->content,
        'items' => $data[$section->section_key] ?? collect(),
    ])
@endforeach
@endsection
