@extends('layouts.frontend')

@section('title', 'Request a Quote - SI Green Energy')
@section('meta_description', 'Request a free quote for solar and renewable energy solutions')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>Request a Quote</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Get a Quote</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Quote Area Start -->
<div class="quote__area pt-100 pb-70">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-8 mb-30">
                <div class="quote__form">
                    <h3 class="mb-20">Get Your Free Quote</h3>
                    <p class="mb-30">Fill out the form below and we'll get back to you within 24 hours.</p>

                    <form action="{{ route('quote.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-20">
                                <label>Full Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <label>Email Address *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <label>Phone Number *</label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" required>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <label>Company (Optional)</label>
                                <input type="text" name="company" class="form-control @error('company') is-invalid @enderror"
                                       value="{{ old('company') }}">
                                @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <label>Service Interested In *</label>
                                <select name="service" class="form-control @error('service') is-invalid @enderror" required>
                                    <option value="">Select a service</option>
                                    <option value="Solar Panel Installation" {{ old('service') == 'Solar Panel Installation' ? 'selected' : '' }}>Solar Panel Installation</option>
                                    <option value="Solar Maintenance" {{ old('service') == 'Solar Maintenance' ? 'selected' : '' }}>Solar Maintenance</option>
                                    <option value="Energy Audit" {{ old('service') == 'Energy Audit' ? 'selected' : '' }}>Energy Audit</option>
                                    <option value="Battery Storage" {{ old('service') == 'Battery Storage' ? 'selected' : '' }}>Battery Storage</option>
                                    <option value="Other" {{ old('service') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('service')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <label>Budget (Optional)</label>
                                <input type="text" name="budget" class="form-control @error('budget') is-invalid @enderror"
                                       value="{{ old('budget') }}" placeholder="e.g., $5,000 - $10,000">
                                @error('budget')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-20">
                                <label>Additional Details *</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                          rows="6" required>{{ old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn-one">Request Quote</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 mb-30">
                <div class="quote__info">
                    <h3 class="mb-30">Why Choose Us?</h3>

                    <div class="feature__item">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h5>Free Consultation</h5>
                            <p>No obligation quote and energy assessment</p>
                        </div>
                    </div>

                    <div class="feature__item">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h5>Expert Team</h5>
                            <p>Certified and experienced professionals</p>
                        </div>
                    </div>

                    <div class="feature__item">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h5>Quality Products</h5>
                            <p>Premium solar panels and equipment</p>
                        </div>
                    </div>

                    <div class="feature__item">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h5>Quick Response</h5>
                            <p>We respond within 24 hours</p>
                        </div>
                    </div>

                    <div class="feature__item">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h5>Competitive Pricing</h5>
                            <p>Best value for your investment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quote Area End -->
@endsection

@push('styles')
<style>
.quote__form {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.quote__form label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 600;
    font-size: 14px;
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

.quote__info {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.feature__item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 25px;
    padding-bottom: 25px;
    border-bottom: 1px solid #f0f0f0;
}

.feature__item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.feature__item i {
    font-size: 24px;
    color: #4caf50;
    margin-right: 15px;
}

.feature__item h5 {
    font-size: 16px;
    margin-bottom: 5px;
    color: #333;
}

.feature__item p {
    color: #666;
    font-size: 14px;
    margin: 0;
}
</style>
@endpush
