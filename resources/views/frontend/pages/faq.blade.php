@extends('layouts.frontend')

@section('title', 'FAQ - SI Green Energy')
@section('meta_description', 'Frequently asked questions about our solar and renewable energy solutions')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 100px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content text-center">
                    <h1 class="text-white">Frequently Asked Questions</h1>
                    <p class="text-white mt-3">Find answers to common questions</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- FAQ Section Start -->
<div class="faq__section pt-90 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-center mb-50">Common Questions</h2>
                <p class="text-center">FAQ content coming soon. For immediate assistance, please <a href="{{ route('contact') }}">contact us</a>.</p>
            </div>
        </div>
    </div>
</div>
<!-- FAQ Section End -->
@endsection
