@extends('layouts.frontend')

@php
    $columnClass = [2 => 'col-md-6 mt-25', 3 => 'col-lg-4 col-md-6 mt-25', 4 => 'col-xl-3 col-lg-4 col-md-6 mt-25'][$columns] ?? 'col-lg-4 col-md-6 mt-25';
@endphp

@section('content')
@include('frontend.partials.breadcrumb', [
    'title' => $category ? $category->name : $settings['title'],
    'image' => $category?->image ?: $settings['breadcrumb_image'],
    'crumbs' => $category ? [['label' => $settings['title'], 'url' => route('projects.index')]] : [],
])

<!-- Project Grid Area Start -->
<div class="portfolio__three-page section-padding-three">
    <div class="{{ $columns === 4 ? 'container-fluid' : 'container' }}">
        @if($categories->count() > 1)
        <div class="row">
            <div class="col-xl-12">
                <div class="who__area-right-btn">
                    <ul class="nav justify-content-center gap-3">
                        <li><a class="btn-two {{ $category ? '' : 'active' }}" href="{{ url()->current() }}">{{ $listing['all_label'] }}</a></li>
                        @foreach($categories as $filter)
                        <li><a class="btn-two {{ $category?->is($filter) ? 'active' : '' }}" href="{{ url()->current() }}?category={{ $filter->slug }}">{{ $filter->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        <div class="row dark_image">
            @forelse($projects as $project)
            <div class="{{ $columnClass }}">
                <div class="portfolio__three-item">
                    <a href="{{ route('projects.show', $project->slug) }}" aria-label="{{ $project->name }}"><i class="fa-sharp fa-regular fa-arrow-up-right"></i></a>
                    <div class="portfolio__three-item-image">
                        <img src="{{ $project->imageUrl() }}" alt="{{ $project->name }}">
                        <div class="portfolio__three-item-image-content">
                            @if($project->category)<span><i class="fa-regular fa-horizontal-rule"></i>{{ $project->category->name }}</span>@endif
                            <h6><a href="{{ route('projects.show', $project->slug) }}">{{ $project->name }}</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 t-center mt-25"><p>{{ $listing['empty_text'] }}</p></div>
            @endforelse
        </div>
        {{ $projects->links('frontend.partials.pagination') }}
    </div>
</div>
<!-- Project Grid Area End -->
@endsection
