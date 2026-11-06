@extends('layouts.frontend')

@section('title', $service->meta_title ?? $service->name . ' - SI Green Energy')
@section('meta_description', $service->meta_description ?? $service->short_description)

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>{{ $service->name }}</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('services.index') }}">Services</a></li>
                        @if($service->category)
                        <li>{{ $service->category->name }}</li>
                        @endif
                        <li>{{ $service->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Service Details Start -->
<div class="service__details pt-100 pb-70">
    <div class="container">
        <div class="row">
            <!-- Service Content -->
            <div class="col-lg-8 mb-30">
                <!-- Featured Image -->
                @if($service->featured_image)
                <div class="service__details-image mb-40">
                    <img src="{{ asset($service->featured_image) }}" alt="{{ $service->name }}" class="w-100">
                    @if($service->is_featured)
                    <span class="badge-featured">Featured Service</span>
                    @endif
                </div>
                @endif

                <!-- Service Info -->
                <div class="service__details-content">
                    @if($service->category)
                    <span class="service-category">
                        @if($service->category->icon)
                        <i class="{{ $service->category->icon }}"></i>
                        @endif
                        {{ $service->category->name }}
                    </span>
                    @endif

                    <h2>{{ $service->name }}</h2>

                    <!-- Short Description -->
                    @if($service->short_description)
                    <div class="service-short-desc">
                        <p class="lead">{{ $service->short_description }}</p>
                    </div>
                    @endif

                    <!-- Full Description -->
                    @if($service->description)
                    <div class="service-description mt-4">
                        <h3>Service Overview</h3>
                        <div class="description-content">
                            {!! nl2br(e($service->description)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Features -->
                    @if($service->features)
                    <div class="service-features mt-4">
                        <h3>Key Features</h3>
                        <div class="features-content">
                            {!! nl2br(e($service->features)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Gallery -->
                    @if($service->images && $service->images->count() > 0)
                    <div class="service-gallery mt-4">
                        <h3>Gallery</h3>
                        <div class="gallery-grid">
                            @foreach($service->images as $image)
                            <div class="gallery-item">
                                <img src="{{ asset($image->image_path) }}" alt="{{ $service->name }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 mb-30">
                <!-- Service Info Card -->
                <div class="sidebar__card mb-30">
                    <h4>Service Information</h4>

                    @if($service->price)
                    <div class="info-item">
                        <i class="fas fa-tag"></i>
                        <div>
                            <span class="label">Price</span>
                            <span class="value">{{ $service->price }}</span>
                        </div>
                    </div>
                    @endif

                    @if($service->category)
                    <div class="info-item">
                        <i class="fas fa-folder"></i>
                        <div>
                            <span class="label">Category</span>
                            <span class="value">{{ $service->category->name }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="sidebar__card-actions mt-3">
                        <a href="{{ route('quote') }}" class="btn-one w-100 mb-2">Request Quote</a>
                        <a href="{{ route('contact') }}" class="btn-two w-100">Contact Us</a>
                    </div>
                </div>

                <!-- Related Services -->
                @if($relatedServices && $relatedServices->count() > 0)
                <div class="sidebar__card">
                    <h4>Related Services</h4>
                    <div class="related-services">
                        @foreach($relatedServices as $related)
                        <div class="related-item">
                            <a href="{{ route('services.show', $related->slug) }}">
                                @if($related->featured_image)
                                <img src="{{ asset($related->featured_image) }}" alt="{{ $related->name }}">
                                @endif
                                <div class="related-content">
                                    <h5>{{ $related->name }}</h5>
                                    @if($related->price)
                                    <span class="price">{{ $related->price }}</span>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Service Details End -->
@endsection

@push('styles')
<style>
.service__details-image {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.service__details-image img {
    border-radius: 8px;
}

.badge-featured {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #ff6b35;
    color: #fff;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
}

.service__details-content {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.service-category {
    display: inline-block;
    background: #e8f5e9;
    color: #4caf50;
    padding: 8px 20px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
}

.service-category i {
    margin-right: 8px;
}

.service__details-content h2 {
    font-size: 36px;
    margin: 15px 0 25px;
    color: #333;
}

.service-short-desc .lead {
    font-size: 18px;
    line-height: 1.8;
    color: #666;
}

.service-description,
.service-features {
    border-top: 2px solid #f0f0f0;
    padding-top: 30px;
}

.service-description h3,
.service-features h3,
.service-gallery h3 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.description-content,
.features-content {
    font-size: 16px;
    line-height: 1.8;
    color: #666;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.gallery-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery-item img:hover {
    transform: scale(1.05);
}

.sidebar__card {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.sidebar__card h4 {
    font-size: 20px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.info-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item i {
    font-size: 20px;
    color: #4caf50;
    margin-right: 15px;
    width: 30px;
}

.info-item div {
    flex: 1;
}

.info-item .label {
    display: block;
    font-size: 12px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 3px;
}

.info-item .value {
    display: block;
    font-size: 16px;
    color: #333;
    font-weight: 600;
}

.related-item {
    margin-bottom: 20px;
}

.related-item a {
    display: flex;
    gap: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.related-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.related-content h5 {
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
}

.related-content .price {
    color: #4caf50;
    font-size: 14px;
    font-weight: 600;
}

.related-item:hover h5 {
    color: #4caf50;
}
</style>
@endpush
