@use('App\Support\Media')
<!-- Mission & Vision Area Start -->
<div class="consultation__area section-padding pt-0">
    @if($c['shape_light'])<img class="about__one-shape dark-n" src="{{ Media::url($c['shape_light']) }}" alt="shape">@endif
    @if($c['shape_dark'])<img class="about__one-shape light-n" src="{{ Media::url($c['shape_dark']) }}" alt="shape">@endif
    <div class="container">
        <div class="row al-center">
            <div class="col-lg-6 lg-mb-25">
                <div class="consultation__area-left t-right dark_image">
                    @if($c['image'])<img src="{{ Media::url($c['image']) }}" alt="{{ $c['title'] }}">@endif
                    @if($c['badge_number'] || $c['badge_text'])
                    <div class="content">
                        @if($c['badge_image'])<img src="{{ Media::url($c['badge_image']) }}" alt="">@endif
                        <p><span>{{ $c['badge_number'] }}</span> {{ $c['badge_text'] }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="consultation__area-right">
                    <div class="consultation__area-right-title">
                        @if($c['subtitle'])<span class="subtitle-three">{{ $c['subtitle'] }}</span>@endif
                        <h2>{!! nl2br(e($c['title'])) !!}</h2>
                        @if($c['text'])<p>{!! nl2br(e($c['text'])) !!}</p>@endif
                    </div>
                    <div class="consultation__area-right-list">
                        <div class="row">
                            @foreach([['mission', 'sm-mb-25'], ['vision', '']] as [$key, $spacing])
                            @if($c[$key . '_title'])
                            <div class="col-sm-6">
                                <div class="consultation__area-right-list-item {{ $spacing }}" @if($c['card_background']) style="background-image: url('{{ Media::url($c['card_background']) }}');" @endif>
                                    <div class="consultation__area-right-list-item-icon">
                                        <i class="{{ $c[$key . '_icon'] }}"></i>
                                    </div>
                                    <div class="consultation__area-right-list-item-content">
                                        <h6>{{ $c[$key . '_title'] }}</h6>
                                        <p>{!! nl2br(e($c[$key . '_text'])) !!}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mission & Vision Area End -->
