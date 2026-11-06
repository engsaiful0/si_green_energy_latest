@extends('layouts.frontend')

@use('App\Support\Link')

@section('content')
@include('frontend.partials.breadcrumb', [
    'title' => $member->full_name,
    'image' => $settings['breadcrumb_image'],
    'crumbs' => [['label' => $settings['title'], 'url' => route('team.index')]],
])

<!-- Team Details Area Start -->
<div class="team__details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5 lg-mb-30">
                <div class="team__details-left">
                    <div class="team__details-left-thumb dark_image">
                        <img class="img__full" src="{{ $member->photoUrl() }}" alt="{{ $member->full_name }}">
                    </div>
                    <div class="team__details-left-info">
                        <span>{{ $member->position }}</span>
                        <h4>{{ $member->full_name }}</h4>
                        <div class="team__details-left-info-contact">
                            @if($member->email)
                            <div class="team__details-left-info-contact-item">
                                <i class="far fa-envelope"></i>
                                <div class="team__details-left-info-contact-item-info">
                                    <span>Quick Email</span>
                                    <h6><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></h6>
                                </div>
                            </div>
                            @endif
                            @if($member->phone)
                            <div class="team__details-left-info-contact-item">
                                <i class="fal fa-phone-alt"></i>
                                <div class="team__details-left-info-contact-item-info">
                                    <span>Phone</span>
                                    <h6><a href="{{ Link::tel($member->phone) }}">{{ $member->phone }}</a></h6>
                                </div>
                            </div>
                            @endif
                            @if($member->experience_years)
                            <div class="team__details-left-info-contact-item">
                                <i class="far fa-briefcase"></i>
                                <div class="team__details-left-info-contact-item-info">
                                    <span>Experience</span>
                                    <h6>{{ $member->experience_years }}+ years</h6>
                                </div>
                            </div>
                            @endif
                            @if($site['address'])
                            <div class="team__details-left-info-contact-item">
                                <i class="far fa-map-marker-alt"></i>
                                <div class="team__details-left-info-contact-item-info">
                                    <span>Office Location</span>
                                    <h6><a href="{{ $site['address_link'] ?: '#' }}" target="_blank" rel="noopener">{{ $site['address'] }}</a></h6>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if(count($member->socialLinks()))
                        <div class="social__icon">
                            <ul>
                                @foreach($member->socialLinks() as $social)
                                <li><a href="{{ $social['url'] }}" target="_blank" rel="noopener"><i class="{{ $social['icon'] }}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7">
                <div class="team__details-right ml-20 xl-ml-0">
                    @if($member->bio || $member->short_bio)
                    <div class="team__details-right-experience">
                        <h3>{{ $listing['bio_heading'] }}</h3>
                        @foreach(array_filter(preg_split('/\R{2,}/', trim((string) ($member->bio ?: $member->short_bio)))) as $paragraph)
                        <p>{!! nl2br(e($paragraph)) !!}</p>
                        @endforeach
                    </div>
                    @endif

                    @if($member->qualifications)
                    <div class="team__details-right-experience mt-30">
                        <h3>{{ $listing['qualifications_heading'] }}</h3>
                        <div class="about__four-right-list">
                            @foreach(array_filter(array_map('trim', preg_split('/\R/', $member->qualifications))) as $qualification)
                            <span><i class="fa-sharp fa-solid fa-circle-check"></i>{{ $qualification }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(count($member->skills ?? []))
                    <div class="team__details-right-skill mt-30">
                        <h3>{{ $listing['skills_heading'] }}</h3>
                        <div class="skill__area mt-30">
                            @include('frontend.partials.skill-bars', ['skills' => $member->skills, 'countClass' => 'text-two'])
                        </div>
                    </div>
                    @endif

                    <div class="contact__form-area mt-40">
                        <h3 class="mb-25">{{ $listing['form_heading'] }}</h3>
                        @include('frontend.partials.contact-form', [
                            'labels' => ['button_text' => $listing['form_button']],
                            'subject' => 'Message for ' . $member->full_name,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team Details Area End -->

@include('frontend.partials.page-cta', ['page' => 'team'])
@endsection
