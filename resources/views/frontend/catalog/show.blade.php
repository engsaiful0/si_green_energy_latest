@extends('layouts.frontend')

@use('App\Support\Media')
@use('App\Support\Link')

@php
    $featureIcons = ['flaticon-reputation', 'flaticon-talk', 'flaticon-global-shipping', 'flaticon-check', 'flaticon-trophy', 'flaticon-energy'];
    $paragraphs = array_filter(preg_split('/\R{2,}/', trim((string) $item->description)));
@endphp

@section('content')
@include('frontend.partials.breadcrumb', [
    'title' => $item->name,
    'image' => $settings['breadcrumb_image'],
    'crumbs' => array_values(array_filter([
        ['label' => $catalog['label'], 'url' => route($catalog['prefix'] . '.index')],
        $item->category ? ['label' => $item->category->name, 'url' => route($catalog['prefix'] . '.category', $item->category->slug)] : null,
    ])),
])

<!-- {{ $catalog['singular'] }} Details Area Start -->
<div class="service__details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 lg-mb-50">
                <div class="service__details-content">
                    <div class="service__details-content-image dark_image">
                        <img src="{{ $item->imageUrl() }}" alt="{{ $item->name }}">
                    </div>
                    <h3>{{ $item->name }}</h3>
                    @if($item->short_description)
                    <p>{{ $item->short_description }}</p>
                    @endif
                    @foreach($paragraphs as $paragraph)
                    <p>{!! nl2br(e($paragraph)) !!}</p>
                    @endforeach

                    @if($item->priceLabel())
                    <p><strong>{{ $item->priceLabel() }}</strong></p>
                    @endif

                    @if(count($item->featureList()))
                    <h4>{{ $sidebar['features_title'] }}</h4>
                    <div class="row mb-30 mt-30">
                        @foreach($item->featureList() as $feature)
                        <div class="col-md-4 col-sm-6 mb-25">
                            <div class="service__details-content-list">
                                <i class="{{ $featureIcons[$loop->index % count($featureIcons)] }}"></i>
                                <h6>{{ $feature }}</h6>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if(count((array) ($item->applications ?? [])))
                    <h4>Suitable Applications</h4>
                    <div class="about__four-right-list mb-30">
                        @foreach($item->applications as $application)
                        <span><i class="fa-sharp fa-solid fa-circle-check"></i>{{ $application }}</span>
                        @endforeach
                    </div>
                    @endif

                    @if(count((array) ($item->specifications ?? [])))
                    <h4>Technical Specifications</h4>
                    <div class="table-responsive mb-30">
                        <table class="table catalog-specs mb-0">
                            <tbody>
                                @foreach($item->specifications as $spec)
                                <tr><th scope="row">{{ $spec['label'] ?? '' }}</th><td>{{ $spec['value'] ?? '' }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if($faq && count($faq['items']))
                    <h4>{{ $sidebar['faq_title'] }}</h4>
                    <div class="service__details-content-faq">
                        @include('frontend.partials.faq-accordion', ['faqs' => $faq['items'], 'id' => 'detailsFaq'])
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="all__sidebar ml-25">
                    @include('frontend.partials.sidebar-links', ['title' => $sidebar['categories_title'], 'links' => $categories])

                    @include('frontend.partials.sidebar-links', [
                        'title' => 'More ' . $catalog['label'],
                        'links' => $related->map(fn ($other) => ['label' => $other->name, 'url' => route($catalog['prefix'] . '.show', $other->slug)])->all(),
                    ])

                    @if(count($sidebar['downloads']))
                    <div class="all__sidebar-item">
                        <h6>{{ $sidebar['downloads_title'] }}</h6>
                        <div class="all__sidebar-item-download">
                            <ul>
                                @foreach($sidebar['downloads'] as $download)
                                <li><a href="{{ Link::to($download['url'] ?? '') }}" target="_blank" rel="noopener"><div><i class="{{ ($download['icon'] ?? '') ?: 'fa-light fa-file-pdf' }}"></i>{{ $download['label'] ?? '' }}</div><span class="fal fa-arrow-to-bottom"></span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($sidebar['help_title'])
                    <div class="all__sidebar-item-help mt-30" @if($sidebar['help_image']) style="background-image: url('{{ Media::url($sidebar['help_image']) }}');" @endif>
                        <div class="all__sidebar-item-help-icon">
                            <i class="fal fa-phone-alt"></i>
                        </div>
                        <h5>{!! nl2br(e($sidebar['help_title'])) !!}</h5>
                        @if($sidebar['help_phone'])
                        <div class="all__sidebar-item-help-contact">
                            <div class="all__sidebar-item-help-contact-content">
                                <span>{{ $sidebar['help_label'] }}</span>
                                <h6><a href="{{ Link::tel($sidebar['help_phone']) }}">{{ $sidebar['help_phone'] }}</a></h6>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {{ $catalog['singular'] }} Details Area End -->

@include('frontend.partials.page-cta', ['page' => $catalog['prefix']])
@endsection
