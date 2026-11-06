@extends('layouts.frontend')

@php
    $paragraphs = fn ($text) => array_filter(preg_split('/\R{2,}/', trim((string) $text)));
    $meta = array_filter([
        'Date :' => $project->project_date?->format('d F, Y'),
        'Category :' => $project->category?->name,
        'Client :' => $project->client_name,
        'Location :' => $project->location,
    ]);
    $blocks = array_filter([
        $listing['challenge_heading'] => $project->challenge,
        $listing['solution_heading'] => $project->solution,
        $listing['results_heading'] => $project->results,
    ]);
@endphp

@section('content')
@include('frontend.partials.breadcrumb', [
    'title' => $project->name,
    'image' => $settings['breadcrumb_image'],
    'crumbs' => [['label' => $settings['title'], 'url' => route('projects.index')]],
])

<!-- Portfolio Details Area Start -->
<div class="portfolio__details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="portfolio__details-image dark_image">
                    <img src="{{ $project->imageUrl() }}" alt="{{ $project->name }}">
                    @if(count($meta))
                    <div class="portfolio__details-meta">
                        @foreach($meta as $label => $value)
                        <div class="portfolio__details-meta-item">
                            <span>{{ $label }}</span>
                            <h6>{{ $value }}</h6>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-40">
            <div class="col-lg-4 lg-mb-15">
                <h3>{{ $listing['about_heading'] }}</h3>
            </div>
            <div class="col-lg-8">
                @if($project->short_description)<p>{{ $project->short_description }}</p>@endif
                @foreach($paragraphs($project->description) as $paragraph)
                <p>{!! nl2br(e($paragraph)) !!}</p>
                @endforeach
                @if($project->website_url || $project->video_url)
                <div class="d-flex flex-wrap gap-3 mt-25">
                    @if($project->website_url)<a class="btn-one" href="{{ $project->website_url }}" target="_blank" rel="noopener">Visit Project</a>@endif
                    @if($project->video_url)<a class="btn-two video-popup" href="{{ $project->video_url }}">Watch Video</a>@endif
                </div>
                @endif
            </div>
        </div>

        @if($project->images->isNotEmpty())
        <div class="row mt-30 dark_image">
            @foreach($project->images as $image)
            <div class="col-sm-4 mb-25">
                <a class="img-popup" href="{{ $image->imageUrl() }}">
                    <img class="img__full" src="{{ $image->imageUrl() }}" alt="{{ $image->alt_text ?: $project->name }}">
                </a>
            </div>
            @endforeach
        </div>
        @endif

        @foreach($blocks as $heading => $text)
        <div class="row {{ $loop->first ? 'mt-40' : 'mt-20' }}">
            <div class="col-lg-4 lg-mb-15">
                <h3>{{ $heading }}</h3>
            </div>
            <div class="col-lg-8">
                @foreach($paragraphs($text) as $paragraph)
                <p>{!! nl2br(e($paragraph)) !!}</p>
                @endforeach
            </div>
        </div>
        @endforeach

        @if($related->isNotEmpty())
        <div class="row mt-60">
            <div class="col-xl-12 mb-10"><h3>Related Projects</h3></div>
            @foreach($related as $other)
            <div class="col-lg-4 col-md-6 mt-25">
                <div class="portfolio__three-item">
                    <a href="{{ route('projects.show', $other->slug) }}" aria-label="{{ $other->name }}"><i class="fa-sharp fa-regular fa-arrow-up-right"></i></a>
                    <div class="portfolio__three-item-image">
                        <img src="{{ $other->imageUrl() }}" alt="{{ $other->name }}">
                        <div class="portfolio__three-item-image-content">
                            <h6><a href="{{ route('projects.show', $other->slug) }}">{{ $other->name }}</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- Portfolio Details Area End -->
@endsection
