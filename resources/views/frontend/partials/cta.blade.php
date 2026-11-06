{{--
    Call-to-action box (Slaze footer__cta design), shared by the homepage and every inner page.
    Expects $c: title, text (optional), button_text, button_link, help_label, phone, image, background_image.
--}}
@use('App\Support\Media')
@use('App\Support\Link')
<!-- Call To Action Area Start -->
<div class="footer__cta">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="footer__cta-area" @if($c['background_image'] ?? null) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
                    <div class="row al-center">
                        <div class="{{ ($c['image'] ?? null) ? 'col-lg-9' : 'col-lg-12' }}">
                            <div class="footer__cta-area-left">
                                <h3 class="cta__title-line">{{ str_replace(["\r", "\n"], ' ', $c['title']) }}</h3>
                                @if(!empty($c['text']))
                                <p class="footer__cta-area-text">{{ $c['text'] }}</p>
                                @endif
                                <div class="footer__cta-area-left-btn lg-jc-center">
                                    @if($c['button_text'])
                                    <a class="btn-one" href="{{ Link::to($c['button_link']) }}">{{ $c['button_text'] }}</a>
                                    @endif
                                    @if($c['phone'])
                                    <div class="footer__cta-area-left-btn-tel author">
                                        <i class="flaticon-phone-call"></i>
                                        <div class="info">
                                            <span>{{ $c['help_label'] }}</span>
                                            <h6><a href="{{ Link::tel($c['phone']) }}">{{ $c['phone'] }}</a></h6>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($c['image'] ?? null)
                        <div class="col-lg-3 lg-mt-25">
                            <div class="footer__cta-area-right t-right lg-t-center">
                                <div class="footer__cta-area-right-image dark_image">
                                    <img src="{{ Media::url($c['image']) }}" alt="">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Call To Action Area End -->
