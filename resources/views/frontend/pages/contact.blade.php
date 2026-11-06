@extends('layouts.frontend')

@section('title', 'Contact Us - SI Green Energy')
@section('meta_description', 'Get in touch with SI Green Energy for solar and renewable energy solutions')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>Contact Us</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Contact</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Contact Area Start -->
<div class="contact__area pt-100 pb-70">
    <div class="container">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-30">
                <div class="contact__form">
                    <h3 class="mb-30">Send Us a Message</h3>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-20">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Your Name *" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Your Email *" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Your Phone" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                                       placeholder="Subject" value="{{ old('subject') }}">
                                @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-20">
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                          rows="6" placeholder="Your Message *" required>{{ old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn-one">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4 mb-30">
                <div class="contact__info">
                    <h3 class="mb-30">Get In Touch</h3>

                    <div class="info__item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h5>Address</h5>
                            <p>123 Solar Street<br>Green City, GC 12345</p>
                        </div>
                    </div>

                    <div class="info__item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h5>Phone</h5>
                            <p>+1 (555) 123-4567</p>
                        </div>
                    </div>

                    <div class="info__item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h5>Email</h5>
                            <p>info@sigreenenergy.com</p>
                        </div>
                    </div>

                    <div class="info__item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h5>Business Hours</h5>
                            <p>Mon - Fri: 9:00 AM - 6:00 PM<br>Sat: 10:00 AM - 4:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Area End -->
@endsection

@push('styles')
<style>
.contact__form {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.form-control {
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
}

.form-control:focus {
    border-color: #4caf50;
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
}

.contact__info {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.info__item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #f0f0f0;
}

.info__item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.info__item i {
    font-size: 24px;
    color: #4caf50;
    margin-right: 20px;
    width: 30px;
}

.info__item h5 {
    font-size: 16px;
    margin-bottom: 8px;
    color: #333;
}

.info__item p {
    color: #666;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}
</style>
@endpush
