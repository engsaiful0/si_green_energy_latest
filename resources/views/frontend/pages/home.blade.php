@extends('layouts.frontend')

@section('title', 'Home - SI Green Energy')
@section('meta_description', 'SI Green Energy - Your trusted partner in solar and renewable energy solutions')

@section('content')
<!-- Banner Area Start -->
<div class="banner__one">
    <div class="swiper banner-slider">
        <div class="swiper-wrapper">
            <div class="banner__one-image swiper-slide">
                <img class="banner__one-shape" src="{{ asset('img/shape/shape-3.png') }}" alt="banner-shape">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="banner__one-content">
                                <h6 class="wow fadeInUp" data-wow-delay="0.3s">Welcome to SI Green Energy</h6>
                                <h1 class="wow fadeInUp" data-wow-delay="0.5s">Solar & Renewable Energy Solutions</h1>
                                <p class="wow fadeInUp" data-wow-delay="0.7s">We provide comprehensive renewable energy solutions for residential and commercial applications. Join us in creating a sustainable future.</p>
                                <div class="banner__one-content-btn wow fadeInUp" data-wow-delay="0.9s">
                                    <a class="btn-one" href="{{ route('quote') }}">Get A Quote</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Area End -->

<!-- Welcome Section Start -->
<div class="about__one pt-90 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Welcome to SI Green Energy</h2>
                <p class="mt-20">This is a test page to verify that the frontend layout and assets are loading correctly.</p>
                <p class="mt-20">Phase 2 - Foundation & Asset Integration is in progress.</p>
            </div>
        </div>
    </div>
</div>
<!-- Welcome Section End -->
@endsection
