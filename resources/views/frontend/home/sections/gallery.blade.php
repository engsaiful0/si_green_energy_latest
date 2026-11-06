@use('App\Support\Link')
@if($items->isNotEmpty())
<!-- Gallery Carousel Area Start -->
<div class="portfolio__one gallery__carousel section-padding" id="home-gallery">
    <div class="container">
        <div class="row al-end mb-60">
            <div class="col-xl-7 col-lg-6 lg-mb-25">
                <div class="portfolio__one-title lg-t-center">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{{ $c['title'] }}</h2>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6">
                <div class="gallery__carousel-actions t-right lg-t-center">
                    <div class="testimonial__one-arrow gallery__carousel-arrows">
                        <div class="testimonial__one-arrow-prev gallery_prev" role="button" aria-label="Previous image"><i class="fal fa-long-arrow-left"></i></div>
                        <div class="testimonial__one-arrow-next gallery_next" role="button" aria-label="Next image"><i class="fal fa-long-arrow-right"></i></div>
                    </div>
                    @if($c['button_text'])
                    <a class="btn-one" href="{{ Link::to($c['button_link']) }}">{{ $c['button_text'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="swiper gallery_slider dark_image">
        <div class="swiper-wrapper">
            @foreach($items as $image)
            <div class="portfolio__one-item swiper-slide">
                <div class="portfolio__one-item-image">
                    <img src="{{ $image->imageUrl() }}" alt="{{ $image->altText() }}" loading="lazy">
                    <div class="portfolio__one-item-image-content">
                        @if($image->category)<span><i class="fa-regular fa-horizontal-rule"></i>{{ $image->category->name }}</span>@endif
                        <h6>{{ $image->title }}</h6>
                        <a class="img-popup" href="{{ $image->imageUrl() }}" title="{{ $image->title }}" aria-label="View {{ $image->title }}"><i class="fa-sharp fa-regular fa-magnifying-glass-plus"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Gallery Carousel Area End -->

@push('scripts')
<script>
    // Homepage gallery carousel (same Swiper settings style as the theme's project slider).
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swiper === 'undefined') { return; }
        new Swiper('.gallery_slider', {
            spaceBetween: 25,
            loop: {{ $items->count() > 4 ? 'true' : 'false' }},
            speed: 1200,
            autoplay: { delay: {{ max(1, (int) $c['autoplay_delay']) * 1000 }}, disableOnInteraction: false, pauseOnMouseEnter: true },
            navigation: { nextEl: '.gallery_next', prevEl: '.gallery_prev' },
            breakpoints: {
                0: { slidesPerView: 1.15, centeredSlides: true },
                576: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
                1400: { slidesPerView: 4 }
            }
        });
    });
</script>
@endpush
@endif
