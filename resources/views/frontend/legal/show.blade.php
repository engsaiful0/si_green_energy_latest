@extends('layouts.frontend')

@section('content')
@include('frontend.partials.breadcrumb', ['title' => $settings['title'], 'image' => $settings['breadcrumb_image']])

@include('frontend.partials.sections')

@include('frontend.partials.page-cta', ['page' => $page])
@endsection
