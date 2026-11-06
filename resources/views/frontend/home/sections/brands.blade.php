@if($items->isNotEmpty())
<!-- Brand Area Start -->
<div class="brand__area swiper brand_slider">
    <div class="swiper-wrapper">
        @foreach($items as $partner)
        <div class="brand__area-item swiper-slide">
            @if($partner->website_url)<a href="{{ $partner->website_url }}" target="_blank" rel="noopener" title="{{ $partner->name }}">@endif
            @if($partner->logo_dark)
                {{-- .dark-n hides in dark mode, .light-n shows only in dark mode --}}
                <img class="dark-n" src="{{ $partner->logoUrl() }}" alt="{{ $partner->name }}">
                <img class="light-n" src="{{ $partner->darkLogoUrl() }}" alt="{{ $partner->name }}">
            @else
                <img src="{{ $partner->logoUrl() }}" alt="{{ $partner->name }}">
            @endif
            @if($partner->website_url)</a>@endif
        </div>
        @endforeach
    </div>
</div>
<!-- Brand Area End -->
@endif
