@use('App\Support\Media')
@if($items->isNotEmpty())
<!-- Services Area Start -->
<div class="service__one" @if($c['background_image']) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
    <div class="container">
        <div class="row mb-35">
            <div class="col-xl-12">
                <div class="service__one-title t-center">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($items as $service)
            <div class="col-lg-4 col-md-6">
                <div class="service__one-item" @if($c['card_background']) style="background-image: url('{{ Media::url($c['card_background']) }}');" @endif>
                    <div class="service__one-item-icon">
                        <i class="{{ $service->icon ?: 'flaticon-solar-energy' }}"></i>
                    </div>
                    <div class="service__one-item-content">
                        <h6><a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a></h6>
                        <p>{{ $service->short_description }}</p>
                        <a class="simple-btn" href="{{ route('services.show', $service->slug) }}">{{ $c['link_text'] }} <span><i class="fa-sharp fa-regular fa-arrow-up-right"></i></span></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Services Area End -->
@endif
