@extends('layouts.frontend')

@section('content')
@include('frontend.partials.breadcrumb', ['title' => $settings['title'], 'image' => $settings['breadcrumb_image']])

<!-- Testimonial Area Start -->
<div class="testimonial__one-two section-padding">
    <div class="container">
        <div class="row">
            @forelse($testimonials as $testimonial)
            <div class="col-lg-6 {{ $loop->last ? '' : 'mb-25' }}">
                <div class="testimonial__one-right-item">
                    @if($testimonial->avatar)
                    <div class="testimonial__one-right-item-avatar dark_image">
                        <img src="{{ $testimonial->avatarUrl() }}" alt="{{ $testimonial->client_name }}">
                    </div>
                    @endif
                    <div class="testimonial__one-right-item-content">
                        <div class="rating" aria-label="{{ $testimonial->rating }} out of 5">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $testimonial->rating ? 'fa-solid' : 'fa-regular' }} fa-square-star"></i>
                            @endfor
                        </div>
                        <p>{{ $testimonial->testimonial }}</p>
                        <div class="testimonial__one-right-item-content-bottom">
                            <div class="testimonial__one-right-item-content-bottom-name">
                                <h6>{{ $testimonial->client_name }}</h6>
                                @if($testimonial->byline())<span>{{ $testimonial->byline() }}</span>@endif
                            </div>
                            @if($testimonial->company_logo)
                            <div class="testimonial__one-right-item-content-bottom-brand">
                                <img src="{{ $testimonial->companyLogoUrl() }}" alt="{{ $testimonial->company }}">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 t-center"><p>{{ $listing['empty_text'] }}</p></div>
            @endforelse
        </div>
        {{ $testimonials->links('frontend.partials.pagination') }}
    </div>
</div>
<!-- Testimonial Area End -->
@endsection
