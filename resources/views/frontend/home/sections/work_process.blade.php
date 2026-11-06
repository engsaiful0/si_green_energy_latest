@use('App\Support\Media')
@if(count($c['steps']))
<!-- Work Process Area Start -->
<div class="work__process section-padding">
    <div class="container">
        <div class="row mb-70">
            <div class="col-xl-12">
                <div class="work__process-title t-center">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                </div>
            </div>
        </div>
        <div class="row g-0 dark_image">
            @foreach($c['steps'] as $step)
            <div class="col-lg-3 col-sm-6 {{ $loop->last ? '' : ($loop->first ? 'lg-mb-45' : 'sm-mb-45') }}">
                <div class="work__process-item">
                    @if(!empty($step['label']))<p><span>{{ $step['label'] }}</span></p>@endif
                    @if(!empty($step['image']))
                    <img src="{{ Media::url($step['image']) }}" alt="{{ $step['title'] ?? '' }}">
                    @endif
                    <h6>{{ $step['title'] ?? '' }}</h6>
                    <p class="des">{{ $step['text'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Work Process Area End -->
@endif
