@extends('layouts.frontend')

@section('content')
@include('frontend.partials.breadcrumb', ['title' => $settings['title'], 'image' => $settings['breadcrumb_image']])

{{-- Managed in Admin > Company Profile CMS. --}}
@include('frontend.partials.sections')

@include('frontend.partials.page-cta', ['page' => 'company-profile'])
@endsection
