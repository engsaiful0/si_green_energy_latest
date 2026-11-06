@use('App\Support\Media')
@use('App\Support\Link')
<!-- Cta Area Start -->
<div class="cta__one">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="cta__one-area" @if($c['background_image']) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
                    <div class="row align-items-center">
                        <div class="col-lg-7 lg-mb-25">
                            <div class="cta__one-title lg-t-center">
                                <h3 class="cta__title-line">{{ str_replace(["\r", "\n"], ' ', $c['title']) }}</h3>
                            </div>
                        </div>
                        @if($c['phone'])
                        <div class="col-lg-5">
                            <div class="cta__one-contact lg-jc-center">
                                <div class="cta__one-contact-icon">
                                    <i class="{{ $c['icon'] }}"></i>
                                </div>
                                <div class="cta__one-contact-info">
                                    <span>{{ $c['contact_label'] }}</span>
                                    <h6><a href="{{ Link::tel($c['phone']) }}">{{ $c['phone'] }}</a></h6>
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
<!-- Cta Area End -->
