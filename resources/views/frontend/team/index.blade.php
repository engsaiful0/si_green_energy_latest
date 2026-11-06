@extends('layouts.frontend')

@php
    $columnClass = [2 => 'col-md-6', 3 => 'col-lg-4 col-md-6', 4 => 'col-lg-3 col-md-6'][$columns] ?? 'col-lg-4 col-md-6';
@endphp

@section('content')
@include('frontend.partials.breadcrumb', ['title' => $settings['title'], 'image' => $settings['breadcrumb_image']])

<!-- Team Area Start -->
<div class="team__two section-padding-three">
    <div class="container">
        <div class="row dark_image">
            @forelse($members as $member)
            <div class="{{ $columnClass }}">
                <div class="team__two-item">
                    <div class="team__two-item-image">
                        <a href="{{ route('team.show', $member->slug) }}"><img src="{{ $member->photoUrl() }}" alt="{{ $member->full_name }}"></a>
                    </div>
                    <div class="team__two-item-content">
                        <div>
                            <h6><a href="{{ route('team.show', $member->slug) }}">{{ $member->full_name }}</a></h6>
                            <span>{{ $member->position }}</span>
                        </div>
                        @if(count($member->socialLinks()))
                        <div class="team__two-item-content-icon">
                            <span class="fa-sharp fa-regular fa-share-nodes"></span>
                            <div class="team__two-item-content-social">
                                <ul>
                                    @foreach($member->socialLinks() as $social)
                                    <li><a href="{{ $social['url'] }}" target="_blank" rel="noopener"><i class="{{ $social['icon'] }}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 t-center"><p>{{ $listing['empty_text'] }}</p></div>
            @endforelse
        </div>
    </div>
</div>
<!-- Team Area End -->

@include('frontend.partials.page-cta', ['page' => 'team'])
@endsection
