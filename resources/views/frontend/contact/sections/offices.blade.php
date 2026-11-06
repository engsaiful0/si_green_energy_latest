@use('App\Support\Link')
@if(count($c['items']))
<!-- Offices Area Start -->
<div class="contact__offices section-padding pt-0">
    <div class="container">
        <div class="row mb-35">
            <div class="col-xl-12 t-center">
                @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                <h2>{!! nl2br(e($c['title'])) !!}</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($c['items'] as $office)
            <div class="col-lg-4 col-md-6 mb-25">
                <div class="office__card">
                    <h6>{{ $office['name'] ?? '' }}</h6>
                    <ul class="list-unstyled mb-0">
                        @if(!empty($office['address']))<li><i class="fal fa-map-marker-alt"></i><span>{!! nl2br(e($office['address'])) !!}</span></li>@endif
                        @foreach(array_filter(array_map('trim', explode(',', $office['phone'] ?? ''))) as $phone)
                        <li><i class="fal fa-phone-alt"></i><a href="{{ Link::tel($phone) }}">{{ $phone }}</a></li>
                        @endforeach
                        @foreach(array_filter(array_map('trim', explode(',', $office['email'] ?? ''))) as $mail)
                        <li><i class="fal fa-envelope"></i><a href="mailto:{{ $mail }}">{{ $mail }}</a></li>
                        @endforeach
                        @if(!empty($office['hours']))<li><i class="fal fa-clock"></i><span>{{ $office['hours'] }}</span></li>@endif
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Offices Area End -->
@endif
