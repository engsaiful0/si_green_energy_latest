@extends('layouts.frontend')

@section('title', 'About Us - SI Green Energy')
@section('meta_description', 'Learn about SI Green Energy - Your trusted partner in solar and renewable energy solutions')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 100px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content text-center">
                    <h1 class="text-white">About Us</h1>
                    <p class="text-white mt-3">Learn more about our commitment to renewable energy</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- About Section Start -->
<div class="about__section pt-90 pb-90">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about__content">
                    <h2>SI Green Energy</h2>
                    <p class="mt-20">We are a leading provider of solar and renewable energy solutions, committed to creating a sustainable future for generations to come.</p>
                    <p class="mt-20">Our team of experts delivers innovative, cost-effective energy solutions tailored to meet your specific needs.</p>

                    <div class="row mt-30">
                        <div class="col-md-6">
                            <h4>Our Mission</h4>
                            <p>To provide clean, affordable energy solutions that reduce environmental impact and create lasting value.</p>
                        </div>
                        <div class="col-md-6">
                            <h4>Our Vision</h4>
                            <p>A world powered by sustainable energy, where every home and business has access to clean power.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__image">
                    <img src="{{ asset('img/about-placeholder.jpg') }}" alt="About SI Green Energy" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Section End -->
@endsection
