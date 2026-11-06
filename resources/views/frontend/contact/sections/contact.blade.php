@use('App\Support\Link')
<!-- Contact Form Area Start -->
<div class="contact__two section-padding">
    <div class="container">
        <div class="row al-center">
            <div class="col-xl-6 col-lg-5 lg-mb-25">
                <div class="contact__two-area mr-50 xl-mr-0">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                    @if($c['text'])<p>{!! nl2br(e($c['text'])) !!}</p>@endif
                    @include('frontend.partials.contact-form', ['labels' => $c])
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="row">
                    @foreach($c['items'] as $card)
                    <div class="col-md-6 mb-25">
                        <div class="contact__one-item">
                            <i class="{{ $card['icon'] ?? '' }}"></i>
                            <span>{{ $card['label'] ?? '' }}</span>
                            <h6>
                                @if(!empty($card['link']))
                                <a href="{{ Link::to($card['link']) }}" @if(Link::isExternal($card['link'])) target="_blank" rel="noopener" @endif>{{ $card['value'] ?? '' }}</a>
                                @else
                                {{ $card['value'] ?? '' }}
                                @endif
                            </h6>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($c['social_title'] && count($socialLinks))
                <div class="contact__two-social mt-10">
                    <h6 class="mb-15">{{ $c['social_title'] }}</h6>
                    <div class="social__icon">
                        <ul>
                            @include('components.frontend.social-links')
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Contact Form Area End -->
