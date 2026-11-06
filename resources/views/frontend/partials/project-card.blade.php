{{-- Project card (Slaze portfolio item). Used by the homepage gallery slider and project listings. --}}
@php
    $projectLink = route('projects.show', $project->slug);
@endphp
<div class="portfolio__one-item {{ $class ?? '' }}">
    <div class="portfolio__one-item-image">
        <img src="{{ $project->imageUrl() }}" alt="{{ $project->name }}">
        <div class="portfolio__one-item-image-content">
            @if($project->category)
            <span><i class="fa-regular fa-horizontal-rule"></i>{{ $project->category->name }}</span>
            @endif
            <h6><a href="{{ $projectLink }}">{{ $project->name }}</a></h6>
            <a href="{{ $projectLink }}" aria-label="{{ $project->name }}"><i class="fa-sharp fa-regular fa-arrow-up-right"></i></a>
        </div>
    </div>
</div>
