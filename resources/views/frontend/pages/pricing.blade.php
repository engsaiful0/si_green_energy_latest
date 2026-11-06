@extends('layouts.frontend')

@section('title', 'Pricing - SI Green Energy')
@section('meta_description', 'View our competitive pricing for solar and renewable energy solutions')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 100px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content text-center">
                    <h1 class="text-white">Pricing Plans</h1>
                    <p class="text-white mt-3">Choose the perfect plan for your energy needs</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Pricing Section Start -->
<div class="pricing__section pt-90 pb-90">
    <div class="container">
        <div class="row text-center mb-50">
            <div class="col-lg-12">
                <h2>Our Pricing Plans</h2>
                <p class="mt-20">Flexible pricing options to suit every budget</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>Pricing plans will be available soon. Please <a href="{{ route('contact') }}">contact us</a> for a custom quote.</p>
            </div>
        </div>
    </div>
</div>
<!-- Pricing Section End -->
@endsection
