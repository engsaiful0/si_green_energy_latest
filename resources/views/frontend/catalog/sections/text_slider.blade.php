@use('App\Support\Media')
@use('App\Support\Link')
@if(count($c['words']))
<!-- Text Slide Area Start -->
<div class="text__slider two">
    <div class="text-slide">
        @for($copy = 0; $copy < 2; $copy++)
        <div class="sliders scroll" @if($copy) aria-hidden="true" @endif>
            <ul>
                @foreach($c['words'] as $word)
                <li><a href="{{ Link::to($c['link']) }}">{{ $word['text'] ?? '' }} @if($c['icon_image'])<span><img src="{{ Media::url($c['icon_image']) }}" alt=""></span>@endif</a></li>
                @endforeach
            </ul>
        </div>
        @endfor
    </div>
</div>
<!-- Text Slide Area End -->
@endif
