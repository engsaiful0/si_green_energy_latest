@use('App\Support\Media')
@use('App\Support\Link')
<!-- Footer Cta Area Start -->
<div class="footer__cta">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="footer__cta-area" @if($c['background_image']) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
                    <div class="row al-center">
                        <div class="{{ $c['image'] ? 'col-lg-9' : 'col-lg-12' }}">
                            <div class="footer__cta-area-left">
                                <h3>{!! nl2br(e($c['title'])) !!}</h3>
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
                        @if($c['image'])
                        <div class="col-lg-3 lg-mt-25">
                            <div class="footer__cta-area-right t-right lg-t-center">
                                <div class="footer__cta-area-right-image dark_image">
                                    <img src="{{ Media::url($c['image']) }}" alt="{{ $c['title'] }}">
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
<!-- Footer Cta Area End -->
