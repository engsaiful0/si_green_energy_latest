@extends('layouts.frontend')

@section('content')
    {{-- Sections are ordered, shown and hidden from Admin > Home Page CMS. --}}
    @include('frontend.partials.sections', ['page' => 'home'])
@endsection
