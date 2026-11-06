{{-- Catalog card (Slaze service__two-item). Expects $item, $number, $linkText, $catalog. --}}
@php $url = route($catalog['prefix'] . '.show', $item->slug); @endphp
<div class="service__two-item">
    <div class="service__two-item-image">
        <a href="{{ $url }}"><img src="{{ $item->imageUrl() }}" alt="{{ $item->name }}"></a>
    </div>
    <div class="service__two-item-content">
        <div class="service__two-item-content-icon">
            <i class="{{ $item->icon ?? null ?: 'flaticon-solar-energy' }}"></i>
        </div>
        <span><i class="fa-regular fa-horizontal-rule"></i>{{ ($item->brand ?? null) ?: ($item->category?->name ?? str_pad($number, 2, '0', STR_PAD_LEFT)) }}</span>
        <h6><a href="{{ $url }}">{{ $item->name }}</a></h6>
        <p>{{ \Illuminate\Support\Str::limit($item->short_description, 90) }}</p>
        <a class="simple-btn" href="{{ $url }}">{{ $linkText }} <span><i class="fa-sharp fa-regular fa-arrow-up-right"></i></span></a>
    </div>
</div>
