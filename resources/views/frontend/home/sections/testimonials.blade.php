@use('App\Support\Media')
@if($items->isNotEmpty())
<!-- Testimonial Area Start -->
<div class="testimonial__one section-padding" @if($c['background_image']) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
    <div class="container">
        <div class="row al-center">
            <div class="col-xl-5 col-lg-6 lg-mb-45">
                <div class="testimonial__one-left lg-t-center">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                    @if($items->count() > 1)
                    <div class="testimonial__one-arrow lg-jc-center">
                        <div class="testimonial__one-arrow-prev testimonial_prev"><i class="fal fa-long-arrow-left"></i></div>
                        <div class="testimonial__one-arrow-next testimonial_next"><i class="fal fa-long-arrow-right"></i></div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">
                <div class="testimonial__one-right testimonial_one_slider swiper dark_image">
                    <div class="swiper-wrapper">
                        @foreach($items as $testimonial)
                        <div class="testimonial__one-right-item swiper-slide">
                            @if($testimonial->avatar)
                            <div class="testimonial__one-right-item-avatar">
                                <img src="{{ $testimonial->avatarUrl() }}" alt="{{ $testimonial->client_name }}">
                            </div>
                            @endif
                            <div class="testimonial__one-right-item-content">
                                <div class="rating">
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial Area End -->
@endif
