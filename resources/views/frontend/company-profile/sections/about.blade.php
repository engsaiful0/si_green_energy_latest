@use('App\Support\Media')
@use('App\Support\Link')
<!-- About Area Start -->
<div class="about__four section-padding pt-0">
    <div class="container">
        <div class="row al-center">
            <div class="col-lg-6 lg-mb-25">
                <div class="about__four-left">
                    <div class="about__four-left-image dark_image">
                        @if($c['image_one'])
                        <div class="about__four-left-image-one">
                            <img src="{{ Media::url($c['image_one']) }}" alt="{{ $c['title'] }}">
                        </div>
                        @endif
                        @if($c['image_two'])
                        <div class="about__four-left-image-two">
                            <img src="{{ Media::url($c['image_two']) }}" alt="{{ $c['title'] }}">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__four-right">
                    <div class="about__four-right-title">
                        @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                        <h2>{!! nl2br(e($c['title'])) !!}</h2>
                        @if($c['text'])<p>{!! nl2br(e($c['text'])) !!}</p>@endif
                    </div>
                    @if(count($c['points']))
                    <div class="about__four-right-list">
                        @foreach($c['points'] as $point)
                        <span><i class="fa-sharp fa-solid fa-circle-check"></i>{{ $point['text'] ?? '' }}</span>
                        @endforeach
                    </div>
                    @endif
                    @if($c['button_text'])
                    <a class="btn-one" href="{{ Link::to($c['button_link']) }}">{{ $c['button_text'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Area End -->
