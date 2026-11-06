@extends('layouts.frontend')

@section('title', $site['site_name'] . ' - Solar & Renewable Energy')

@section('content')
    {{-- Sections are ordered, shown and hidden from Admin > Homepage Sections. --}}
    @foreach($sections as $section)
        @includeIf('frontend.home.sections.' . $section->section_key, [
            'c' => $section->content,
            'items' => $data[$section->section_key] ?? collect(),
        ])
    @endforeach
@endsection
