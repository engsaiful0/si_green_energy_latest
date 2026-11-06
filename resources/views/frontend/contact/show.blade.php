@extends('layouts.frontend')

@section('content')
@include('frontend.partials.breadcrumb', ['title' => $settings['title'], 'image' => $settings['breadcrumb_image']])

{{-- Managed in Admin > Contact Page CMS. --}}
@include('frontend.partials.sections')

@include('frontend.partials.page-cta', ['page' => 'contact'])
@endsection
