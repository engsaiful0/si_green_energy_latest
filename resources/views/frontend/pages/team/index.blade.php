@extends('layouts.frontend')

@section('title', 'Our Team - ' . config('app.name'))

@php
    $columnClass = [2 => 'col-md-6 mb-35', 3 => 'col-lg-4 col-md-6 mb-35', 4 => 'col-lg-3 col-md-6 mb-35'][$columns];
@endphp

@section('content')
@include('frontend.partials.breadcrumb', ['title' => 'Team'])

<!-- Team Area Start -->
<div class="team__area section-padding-three">
    <div class="container">
        <div class="row dark_image">
            @forelse($members as $member)
            <div class="{{ $columnClass }}">
                @include('frontend.partials.team-card', ['member' => $member])
            </div>
            @empty
            <div class="col-12 t-center">
                <p>Team members will be introduced soon.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Team Area End -->
@endsection
