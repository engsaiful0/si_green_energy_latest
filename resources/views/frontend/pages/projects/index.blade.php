@extends('layouts.frontend')

@section('title', 'Projects - ' . config('app.name'))

@php
    $columnClass = [2 => 'col-md-6 mt-25', 3 => 'col-lg-4 col-md-6 mt-25', 4 => 'col-xl-3 col-lg-4 col-md-6 mt-25'][$columns];
@endphp

@section('content')
@include('frontend.partials.breadcrumb', ['title' => 'Projects'])

<!-- Projects Area Start -->
<div class="portfolio__two-page section-padding-three">
    <div class="{{ $columns === 4 ? 'container-fluid' : 'container' }}">
        <div class="row dark_image">
            @forelse($projects as $project)
            <div class="{{ $columnClass }}">
                <div class="portfolio__two-item">
                    <img src="{{ $project->imageUrl() }}" alt="{{ $project->name }}">
                    <div class="portfolio__two-item-content">
                        @if($project->website_url)
                        <div class="portfolio__two-item-content-icon">
                            <a href="{{ $project->website_url }}" target="_blank" rel="noopener" aria-label="{{ $project->name }}"><i class="fa-sharp fa-regular fa-arrow-right"></i></a>
                        </div>
                        @endif
                        @if($project->category)
                        <span><i class="fa-regular fa-horizontal-rule"></i>{{ $project->category->name }}</span>
                        @endif
                        <h6>{{ $project->name }}</h6>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 t-center">
                <p>No projects have been published yet.</p>
            </div>
            @endforelse
        </div>
        @if($projects->hasPages())
        <div class="row mt-50">
            <div class="col-12 d-flex justify-content-center">{{ $projects->links() }}</div>
        </div>
        @endif
    </div>
</div>
<!-- Projects Area End -->
@endsection
