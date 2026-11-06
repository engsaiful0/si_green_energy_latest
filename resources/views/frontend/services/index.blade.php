@extends('layouts.frontend')

@section('title', 'Our Services - SI Green Energy')
@section('meta_description', 'Explore our comprehensive solar and renewable energy services')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>Our Services</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Services Area Start -->
<div class="services__area pt-100 pb-70">
    <div class="container">
        <div class="row mb-40">
            <div class="col-lg-12">
                <div class="section__title text-center">
                    <h2>What We Offer</h2>
                    <p>Professional solar and renewable energy solutions for your home and business</p>
                </div>
            </div>
        </div>

        <!-- Service Categories -->
        @if($categories->count() > 0)
        <div class="row mb-40">
            <div class="col-lg-12">
                <div class="service__categories">
                    @foreach($categories as $category)
                    <div class="category__card">
                        @if($category->icon)
                        <i class="{{ $category->icon }}"></i>
                        @else
                        <i class="flaticon-solar-panel"></i>
                        @endif
                        <h4>{{ $category->name }}</h4>
                        <p>{{ $category->services_count }} {{ Str::plural('service', $category->services_count) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Services Grid -->
        @if($services->count() > 0)
        <div class="row">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6 mb-30">
                <div class="service__item">
                    @if($service->featured_image)
                    <div class="service__item-image">
                        <a href="{{ route('services.show', $service->slug) }}">
                            <img src="{{ asset($service->featured_image) }}" alt="{{ $service->name }}">
                        </a>
                        @if($service->is_featured)
                        <span class="badge-featured">Featured</span>
                        @endif
                    </div>
                    @endif

                    <div class="service__item-content">
                        @if($service->category)
                        <span class="service__item-category">
                            @if($service->category->icon)
                            <i class="{{ $service->category->icon }}"></i>
                            @endif
                            {{ $service->category->name }}
                        </span>
                        @endif

                        <h3><a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a></h3>

                        @if($service->short_description)
                        <p>{{ Str::limit($service->short_description, 120) }}</p>
                        @endif

                        @if($service->price)
                        <div class="service__item-price">
                            <span class="price-label">Starting at</span>
                            <span class="price-value">{{ $service->price }}</span>
                        </div>
                        @endif

                        <a href="{{ route('services.show', $service->slug) }}" class="btn-two">
                            Learn More <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-40">
            <div class="col-lg-12">
                <div class="pagination__area">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-12">
                <div class="no-services text-center py-5">
                    <i class="flaticon-solar-energy" style="font-size: 64px; color: #ccc;"></i>
                    <h4 class="mt-3">No Services Found</h4>
                    <p>We're currently updating our service offerings. Please check back soon.</p>
                    <a href="{{ route('contact') }}" class="btn-one mt-3">Contact Us</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Services Area End -->

<!-- Why Choose Us -->
<div class="why-choose pt-70 pb-70" style="background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-40">
                <h2>Why Choose SI Green Energy?</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-30">
                <div class="feature__box text-center">
                    <i class="flaticon-award" style="font-size: 48px; color: #4caf50;"></i>
                    <h4 class="mt-3">Certified Professionals</h4>
                    <p>Licensed and experienced technicians</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-30">
                <div class="feature__box text-center">
                    <i class="flaticon-guarantee" style="font-size: 48px; color: #4caf50;"></i>
                    <h4 class="mt-3">Quality Guarantee</h4>
                    <p>Premium products and workmanship</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-30">
                <div class="feature__box text-center">
                    <i class="flaticon-support" style="font-size: 48px; color: #4caf50;"></i>
                    <h4 class="mt-3">24/7 Support</h4>
                    <p>Round-the-clock customer service</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-30">
                <div class="feature__box text-center">
                    <i class="flaticon-eco-friendly" style="font-size: 48px; color: #4caf50;"></i>
                    <h4 class="mt-3">Eco-Friendly</h4>
                    <p>Sustainable energy solutions</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="cta__area pt-70 pb-70">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Ready to Get Started?</h3>
                <p>Request a free consultation and let us help you find the perfect energy solution.</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('quote') }}" class="btn-one">Get A Quote</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.service__item {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.service__item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
}

.service__item-image {
    position: relative;
    overflow: hidden;
}

.service__item-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.service__item:hover .service__item-image img {
    transform: scale(1.1);
}

.badge-featured {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #ff6b35;
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.service__item-content {
    padding: 30px;
}

.service__item-category {
    display: inline-block;
    background: #e8f5e9;
    color: #4caf50;
    padding: 6px 15px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 15px;
}

.service__item-category i {
    margin-right: 5px;
}

.service__item-content h3 {
    margin: 15px 0;
    font-size: 22px;
}

.service__item-content h3 a {
    color: #333;
    text-decoration: none;
}

.service__item-content h3 a:hover {
    color: #4caf50;
}

.service__item-content p {
    color: #666;
    font-size: 15px;
    line-height: 1.6;
    margin: 15px 0;
}

.service__item-price {
    margin: 20px 0;
    padding: 15px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
}

.service__item-price .price-label {
    display: block;
    color: #999;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.service__item-price .price-value {
    color: #4caf50;
    font-size: 20px;
    font-weight: 700;
}

.service__categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.category__card {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.category__card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
}

.category__card i {
    font-size: 40px;
    color: #4caf50;
    margin-bottom: 15px;
}

.category__card h4 {
    font-size: 18px;
    margin: 10px 0;
    color: #333;
}

.category__card p {
    color: #999;
    font-size: 14px;
    margin: 0;
}

.feature__box {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    height: 100%;
    transition: all 0.3s ease;
}

.feature__box:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.feature__box h4 {
    font-size: 18px;
    color: #333;
}

.feature__box p {
    color: #666;
    font-size: 14px;
    margin: 10px 0 0;
}

.pagination__area {
    text-align: center;
}

.no-services {
    background: #f8f9fa;
    padding: 60px 20px;
    border-radius: 8px;
}
</style>
@endpush
