@use('App\Support\Link')
@if($items->isNotEmpty())
<!-- Portfolio Area Start -->
<div class="portfolio__one">
    <div class="container">
        <div class="row al-end mb-60">
            <div class="col-xl-8 lg-mb-25">
                <div class="portfolio__one-title lg-t-center">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                </div>
            </div>
            @if($c['button_text'])
            <div class="col-xl-4">
                <div class="portfolio__one-btn t-right lg-t-center">
                    <a class="btn-one" href="{{ Link::to($c['button_link']) }}">{{ $c['button_text'] }}</a>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="swiper portfolio_slider_one dark_image">
        <div class="swiper-wrapper">
            @foreach($items as $project)
                @include('frontend.partials.project-card', ['project' => $project, 'class' => 'swiper-slide'])
            @endforeach
        </div>
    </div>
</div>
<!-- Portfolio Area End -->
@endif
