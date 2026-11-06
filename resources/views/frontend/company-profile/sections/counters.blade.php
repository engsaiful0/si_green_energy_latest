@use('App\Support\Media')
@if(count($c['items']))
<!-- Counter Area Start -->
<div class="counter__two" @if($c['background_image']) style="background-image: url('{{ Media::url($c['background_image']) }}');" @endif>
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="counter__two-grid">
                    @foreach($c['items'] as $counter)
                    <div class="counter__two-item">
                        <i class="{{ $counter['icon'] ?? '' }}"></i>
                        <h3><span class="counter">{{ $counter['value'] ?? '' }}</span><b>{{ $counter['suffix'] ?? '' }}</b></h3>
                        <p>{{ $counter['label'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Counter Area End -->
@endif
