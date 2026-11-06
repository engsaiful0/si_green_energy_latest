@use('App\Support\Media')
@use('App\Support\Link')
<!-- Why Choose Us Area Start -->
<div class="choose__us section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="choose__us-area">
                    <div class="choose__us-area-title">
                        @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                        <h2>{!! nl2br(e($c['title'])) !!}</h2>
                        @if($c['text'])<p>{!! nl2br(e($c['text'])) !!}</p>@endif
                    </div>
                    @if(count($c['items']))
                    <div class="choose__us-area-list">
                        @foreach($c['items'] as $item)
                        <div class="choose__us-area-list-item">
                            <i class="{{ $item['icon'] ?? '' }}"></i>
                            <div class="choose__us-area-list-item-bottom">
                                <h6>{{ $item['title'] ?? '' }}</h6>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="choose__us-area-bottom">
                        @if($c['button_text'])
                        <a class="btn-one" href="{{ Link::to($c['button_link']) }}">{{ $c['button_text'] }}</a>
                        @endif
                        @if($c['contact_text'] || $c['phone'])
                        <div class="choose__us-area-bottom-tel sm-mt-25">
                            <h6>{!! nl2br(e($c['contact_text'])) !!}
                                @if($c['phone'])<a href="{{ Link::tel($c['phone']) }}"> {{ $c['phone'] }}</a>@endif
                            </h6>
                        </div>
                        @endif
                    </div>
                    @if($c['image'])
                    <div class="choose__us-area-image dark_image">
                        <img src="{{ Media::url($c['image']) }}" alt="{{ $c['title'] }}">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Why Choose Us Area End -->
