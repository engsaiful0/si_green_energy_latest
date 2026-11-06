@if($items->isNotEmpty())
<!-- Team Area Start -->
<div class="team__one">
    <div class="container">
        <div class="row mb-35">
            <div class="col-xl-12">
                <div class="team__one-title t-center">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                </div>
            </div>
        </div>
        <div class="row mb-35 dark_image">
            @foreach($items as $member)
            <div class="col-lg-3 col-md-6 {{ $loop->last ? '' : ($loop->first ? 'lg-mb-35' : 'md-mb-35') }}">
                @include('frontend.partials.team-card', ['member' => $member])
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Team Area End -->
@endif
