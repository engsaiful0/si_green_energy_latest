{{-- Catalog grid (Slaze service-two.html). $items is a paginator. --}}
<!-- {{ $catalog['label'] }} Area Start -->
<div class="service__two services section-padding-three">
    <div class="container">
        @if(count($categories) > 1)
        <div class="row mb-25">
            <div class="col-xl-12">
                <div class="who__area-right-btn catalog-filter">
                    <ul class="nav justify-content-center gap-3">
                        <li><a class="btn-two {{ $category ? '' : 'active' }}" href="{{ route($catalog['prefix'] . '.index') }}">All</a></li>
                        @foreach($categories as $link)
                        <li><a class="btn-two {{ $link['active'] ? 'active' : '' }}" href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        <div class="row dark_image">
            @forelse($items as $item)
            <div class="col-lg-4 col-md-6">
                @include('frontend.catalog.card', ['item' => $item, 'number' => $items->firstItem() + $loop->index, 'linkText' => $c['link_text']])
            </div>
            @empty
            <div class="col-12 t-center">
                <p>{{ $c['empty_text'] }}</p>
            </div>
            @endforelse
        </div>
        {{ $items->links('frontend.partials.pagination') }}
    </div>
</div>
<!-- {{ $catalog['label'] }} Area End -->
