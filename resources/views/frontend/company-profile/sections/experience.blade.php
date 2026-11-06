@use('App\Support\Media')
<!-- Experience Area Start -->
<div class="experience__area section-padding" @if($c['background_image']) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 lg-mb-25">
                <div class="experience__area-left">
                    <div class="experience__area-left-title">
                        @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                        <h2>{!! nl2br(e($c['title'])) !!}</h2>
                        @if($c['text'])<p>{!! nl2br(e($c['text'])) !!}</p>@endif
                    </div>
                    @if(count($c['skills']))
                    <div class="about__one-right-skill">
                        @include('frontend.partials.skill-bars', ['skills' => $c['skills']])
                    </div>
                    @endif
                </div>
            </div>
            @if($c['image'])
            <div class="col-lg-6">
                <div class="experience__area-image dark_image">
                    <img src="{{ Media::url($c['image']) }}" alt="{{ $c['title'] }}">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- Experience Area End -->
