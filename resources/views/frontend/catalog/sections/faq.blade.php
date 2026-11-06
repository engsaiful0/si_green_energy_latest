@if(count($c['items']))
<!-- Faq Area Start -->
<div class="faq__one services section-padding">
    <div class="container">
        <div class="row al-center">
            <div class="col-lg-6 lg-mb-25">
                <div class="faq__one-title">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                    @if($c['text'])<p>{{ $c['text'] }}</p>@endif
                    @if($c['box_number'])
                    <div class="faq__one-title-box">
                        <i class="{{ $c['box_icon'] }}"></i>
                        <div class="faq__one-title-box-content">
                            <h3><span class="counter">{{ $c['box_number'] }}</span>{{ $c['box_suffix'] }}</h3>
                            <span>{{ $c['box_label'] }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                @include('frontend.partials.faq-accordion', ['faqs' => $c['items'], 'id' => 'faqAccordion'])
            </div>
        </div>
    </div>
</div>
<!-- Faq Area End -->
@endif
