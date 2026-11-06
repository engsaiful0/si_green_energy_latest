@extends('layouts.frontend')

@section('title', $page->meta_title ?? $page->title . ' - SI Green Energy')
@section('meta_description', $page->meta_description ?? Str::limit(strip_tags($page->content), 160))

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>{{ $page->title }}</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        @if($page->parent)
                        <li><a href="{{ route('pages.show', $page->parent->slug) }}">{{ $page->parent->title }}</a></li>
                        @endif
                        <li>{{ $page->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Page Content Start -->
<div class="page__content pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if($page->featured_image)
                <div class="page__image mb-40">
                    <img src="{{ asset($page->featured_image) }}" alt="{{ $page->title }}" class="w-100">
                </div>
                @endif

                <div class="page__body">
                    {!! nl2br(e($page->content)) !!}
                </div>

                @if($page->children && $page->children->count() > 0)
                <div class="child__pages mt-50">
                    <h3 class="mb-30">Related Pages</h3>
                    <div class="row">
                        @foreach($page->children->where('status', 'published') as $child)
                        <div class="col-md-4 mb-30">
                            <div class="child__page-card">
                                <h4><a href="{{ route('pages.show', $child->slug) }}">{{ $child->title }}</a></h4>
                                @if($child->content)
                                <p>{{ Str::limit(strip_tags($child->content), 100) }}</p>
                                @endif
                                <a href="{{ route('pages.show', $child->slug) }}" class="btn-two">Read More</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Page Content End -->
@endsection

@push('styles')
<style>
.page__image img {
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.page__body {
    font-size: 16px;
    line-height: 1.9;
    color: #666;
}

.child__page-card {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.child__page-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
}

.child__page-card h4 {
    font-size: 20px;
    margin-bottom: 15px;
}

.child__page-card h4 a {
    color: #333;
    text-decoration: none;
}

.child__page-card h4 a:hover {
    color: #4caf50;
}

.child__page-card p {
    color: #666;
    margin-bottom: 20px;
}
</style>
@endpush
