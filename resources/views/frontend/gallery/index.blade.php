@extends('layouts.frontend')

@section('content')
@include('frontend.partials.breadcrumb', ['title' => $settings['title'], 'image' => $settings['breadcrumb_image']])

<!-- Gallery Area Start (Slaze project-four portfolio layout) -->
<div class="portfolio__two-page gallery__page section-padding-three">
    <div class="container">
        @if($listing['intro'])
        <div class="row justify-content-center mb-30">
            <div class="col-xl-9"><p class="gallery__intro">{!! nl2br(e($listing['intro'])) !!}</p></div>
        </div>
        @endif

        @if($categories->count() > 1)
        <div class="row">
            <div class="col-xl-12">
                <div class="who__area-right-btn gallery__filter">
                    <ul class="nav justify-content-center gap-3" role="tablist" aria-label="Filter gallery">
                        <li><button type="button" class="btn-two active" data-filter="*">{{ $listing['all_label'] }}</button></li>
                        @foreach($categories as $category)
                        <li><button type="button" class="btn-two" data-filter=".gallery-cat-{{ $category->id }}">{{ $category->name }}</button></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="row dark_image gallery__grid">
            @forelse($images as $image)
            <div class="col-xl-3 col-lg-4 col-md-6 mt-25 gallery__grid-item {{ $image->category_id ? 'gallery-cat-' . $image->category_id : '' }}">
                <div class="portfolio__two-item">
                    <a class="img-popup" href="{{ $image->imageUrl() }}" title="{{ $image->title }}{{ $image->description ? ' - ' . $image->description : '' }}">
                        <img src="{{ $image->imageUrl() }}" alt="{{ $image->altText() }}" loading="lazy">
                    </a>
                    <div class="portfolio__two-item-content">
                        <div class="portfolio__two-item-content-icon">
                            <a class="img-popup" href="{{ $image->imageUrl() }}" title="{{ $image->title }}{{ $image->description ? ' - ' . $image->description : '' }}" aria-label="View {{ $image->title }}"><i class="fa-sharp fa-regular fa-magnifying-glass-plus"></i></a>
                        </div>
                        @if($image->category)<span><i class="fa-regular fa-horizontal-rule"></i>{{ $image->category->name }}</span>@endif
                        <h6>{{ $image->title }}</h6>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 t-center mt-25"><p>{{ $listing['empty_text'] }}</p></div>
            @endforelse
        </div>
    </div>
</div>
<!-- Gallery Area End -->

@include('frontend.partials.page-cta', ['page' => 'gallery'])
@endsection

@push('scripts')
<script>
    // Category filtering (Isotope, bundled with the theme). The lightbox is the theme's ".img-popup" gallery.
    jQuery(function ($) {
        var $grid = $('.gallery__grid');
        if (!$grid.length || !$.fn.isotope) { return; }
        $grid.isotope({ itemSelector: '.gallery__grid-item', layoutMode: 'fitRows' });
        $('.gallery__filter').on('click', 'button', function () {
            $('.gallery__filter button').removeClass('active');
            $(this).addClass('active');
            $grid.isotope({ filter: $(this).data('filter') });
        });
    });
</script>
@endpush
