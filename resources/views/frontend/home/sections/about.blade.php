@use('App\Support\Media')
@use('App\Support\Link')
<!-- About Area Start -->
<div class="about__one section-padding pt-0">
    @if($c['shape_light'])
    <img class="about__one-shape dark-n" src="{{ Media::url($c['shape_light']) }}" alt="shape">
    @endif
    @if($c['shape_dark'])
    <img class="about__one-shape light-n" src="{{ Media::url($c['shape_dark']) }}" alt="shape">
    @endif
    <div class="container">
        <div class="row al-center">
            <div class="col-xl-6 col-lg-5 lg-mb-25">
                <div class="about__one-left">
                    <div class="about__one-left-image dark_image">
                        @if($c['image_main'])
                        <img src="{{ Media::url($c['image_main']) }}" alt="about-image">
                        @endif
                        @if($c['image_shape'])
                        <img class="about__one-left-image-shape" src="{{ Media::url($c['image_shape']) }}" alt="shape">
                        @endif
                        @if($c['image_secondary'])
                        <div class="about__one-left-image-two">
                            <img src="{{ Media::url($c['image_secondary']) }}" alt="about-image">
                        </div>
                        @endif
                        @if(is_numeric($c['progress_percent']))
                        <div class="about__one-left-image-content">
                            <div class="circle__progress">
                                <div class="circle__progress-item">
                                    <div class="circle__progress-item-bar" data-percent="{{ (int) $c['progress_percent'] }}"></div>
                                </div>
                            </div>
                            <h6>{{ $c['progress_label'] }}</h6>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="about__one-right">
                    <div class="about__one-right-title">
                        @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                        <h2>{!! nl2br(e($c['title'])) !!}</h2>
                        @if($c['text'])<p>{!! nl2br(e($c['text'])) !!}</p>@endif
                    </div>
                    @if(count($c['skills']))
                    <div class="about__one-right-skill">
                        @foreach($c['skills'] as $skill)
                        <div class="skill__area-item">
                            <div class="skill__area-item-content">
                                <h6>{{ $skill['label'] ?? '' }}</h6>
                                <span class="skill__area-item-count"><span class="counter">{{ (int) ($skill['percent'] ?? 0) }}</span>%</span>
                            </div>
                            <div class="skill__area-item-inner">
                                <div class="skill__area-item-bar" data-width="{{ (int) ($skill['percent'] ?? 0) }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="about__one-right-bottom">
                        @if($c['button_text'])
                        <div class="about__one-right-bottom-btn">
                            <a class="btn-one" href="{{ Link::to($c['button_link']) }}">{{ $c['button_text'] }}</a>
                        </div>
                        @endif
                        @if($c['video_url'])
                        <div class="about__one-right-bottom-video">
                            <div class="about__one-right-bottom-video-icon video video-pulse">
                                <a class="video-popup" href="{{ $c['video_url'] }}" aria-label="{{ $c['video_label'] }}"><i class="fas fa-play"></i></a>
                            </div>
                            <span>{{ $c['video_label'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Area End -->
