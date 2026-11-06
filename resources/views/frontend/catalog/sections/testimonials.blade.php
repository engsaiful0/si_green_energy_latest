@if($items->isNotEmpty())
<!-- Testimonial Area Start -->
<div class="testimonial__two section-padding">
    <div class="container">
        <div class="row mb-60">
            <div class="col-xl-12">
                <div class="testimonial__two-title t-center">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="testimonial__two-area testimonial_one_slider swiper">
                    <div class="swiper-wrapper">
                        @foreach($items as $testimonial)
                        <div class="testimonial__two-item swiper-slide">
                            <div class="testimonial__two-item-content">
                                <i class="flaticon-straight-quotes"></i>
                                <p>{{ $testimonial->testimonial }}</p>
                                <div class="testimonial__two-item-content-bottom">
                                    <div class="testimonial__two-item-content-bottom-author dark_image">
                                        @if($testimonial->avatar)<img src="{{ $testimonial->avatarUrl() }}" alt="{{ $testimonial->client_name }}">@endif
                                        <div class="testimonial__two-item-content-bottom-author-info">
                                            <h6>{{ $testimonial->client_name }}</h6>
                                            <span>{{ $testimonial->byline() }}</span>
                                        </div>
                                    </div>
                                    @if($testimonial->company_logo)
                                    <div class="testimonial__two-item-content-bottom-brand">
                                        <img src="{{ $testimonial->companyLogoUrl() }}" alt="{{ $testimonial->company }}">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="testimonial-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial Area End -->
@endif
