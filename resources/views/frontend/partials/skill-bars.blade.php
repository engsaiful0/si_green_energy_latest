{{-- Slaze skill bars. $skills = [['label' => ..., 'percent' => ...], ...], optional $countClass (e.g. "text-two"). --}}
@foreach($skills as $skill)
<div class="skill__area-item">
    <div class="skill__area-item-content">
        <h6>{{ $skill['label'] ?? '' }}</h6>
        <span class="skill__area-item-count {{ $countClass ?? '' }}"><span class="counter">{{ (int) ($skill['percent'] ?? 0) }}</span>%</span>
    </div>
    <div class="skill__area-item-inner">
        <div class="skill__area-item-bar" data-width="{{ min(100, (int) ($skill['percent'] ?? 0)) }}"></div>
    </div>
</div>
@endforeach
