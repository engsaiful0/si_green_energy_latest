@use('App\Support\Media')
@use('App\Support\Link')
@if($items->isNotEmpty())
<!-- Banner Area Start -->
<div class="banner__one">
    <div class="swiper banner-slider">
        <div class="swiper-wrapper">
            @foreach($items as $slide)
            <div class="banner__one-image swiper-slide">
                @if($c['shape_image'])
                <img class="banner__one-shape" src="{{ Media::url($c['shape_image']) }}" alt="banner-shape">
                @endif
                <div class="container">
                    <div class="row">
                        <div class="col-xl-7">
                            <div class="banner__one-content">
                                @if($slide->subtitle)
                                <span class="subtitle-one" data-animation="fadeInUp" data-delay=".3s">{{ $slide->subtitle }}</span>
                                @endif
                                <h1 data-animation="fadeInUp" data-delay=".6s">{!! nl2br(e($slide->title)) !!}</h1>
                                @if($slide->description)
                                <p data-animation="fadeInUp" data-delay=".9s">{{ $slide->description }}</p>
                                @endif
                                @if($slide->button_text)
                                <div class="banner__one-content-button" data-animation="fadeInUp" data-delay="1.2s">
                                    <a class="btn-one" href="{{ Link::to($slide->button_link) }}">{{ $slide->button_text }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <div class="banner__one-right dark_image">
                                @if($slide->background_image_dark)
                                <img class="dark-n" src="{{ $slide->imageUrl() }}" alt="{{ $slide->title }}">
                                <img class="light-n" src="{{ $slide->darkImageUrl() }}" alt="{{ $slide->title }}">
                                @else
                                <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->title }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="container">
        <div class="row column-reverse">
            <div class="col-xl-7">
                <div class="banner__one-capacity">
                    <div class="container">
                        <div class="row">
                            @foreach($c['counters'] as $counter)
                            <div class="col-md-4 col-sm-5 {{ $loop->last ? '' : 'sm-mb-15' }}">
                                <div class="banner__one-capacity-item sm-t-center">
                                    <h3><span class="counter">{{ $counter['value'] ?? '' }}</span></h3>
                                    <h6>{{ $counter['label'] ?? '' }}</h6>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="banner__one-right">
                    @if($items->count() > 1)
                    <div class="banner__one-arrow">
                        <div class="banner__one-arrow-prev banner_prev"><i class="fal fa-long-arrow-left"></i></div>
                        <div class="banner__one-arrow-next banner_next"><i class="fal fa-long-arrow-right"></i></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Area End -->
@endif
