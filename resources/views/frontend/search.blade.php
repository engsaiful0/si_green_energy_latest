@extends('layouts.frontend')

@section('title', 'Search Results' . ($query ? ' for "' . $query . '"' : '') . ' - SI Green Energy')
@section('meta_description', 'Search results for SI Green Energy')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>Search Results</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Search</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Search Results Start -->
<div class="search__results pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-40">
                <div class="search__form">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."
                                   value="{{ $query }}" required>
                            <button type="submit" class="btn-one">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>

                @if($query)
                <p class="search__query mt-3">Showing results for: <strong>"{{ $query }}"</strong></p>
                @endif
            </div>
        </div>

        @if($query)
            @php
                $totalResults = ($results['pages']->count() ?? 0) +
                                ($results['products']->count() ?? 0) +
                                ($results['services']->count() ?? 0) +
                                ($results['posts']->count() ?? 0);
            @endphp

            @if($totalResults > 0)
                <!-- Pages Results -->
                @if(isset($results['pages']) && $results['pages']->count() > 0)
                <div class="row mb-50">
                    <div class="col-lg-12">
                        <h3 class="results__title">Pages ({{ $results['pages']->count() }})</h3>
                        @foreach($results['pages'] as $page)
                        <div class="result__item">
                            <h4><a href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a></h4>
                            <p>{{ Str::limit(strip_tags($page->content), 200) }}</p>
                            <span class="result__type"><i class="fas fa-file-alt"></i> Page</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Products Results -->
                @if(isset($results['products']) && $results['products']->count() > 0)
                <div class="row mb-50">
                    <div class="col-lg-12">
                        <h3 class="results__title">Products ({{ $results['products']->count() }})</h3>
                        <div class="row">
                            @foreach($results['products'] as $product)
                            <div class="col-md-4 mb-30">
                                <div class="search__product-card">
                                    @if($product->featured_image)
                                    <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}">
                                    @endif
                                    <div class="search__product-content">
                                        <span class="category">{{ $product->category->name ?? 'Product' }}</span>
                                        <h5><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h5>
                                        @if($product->price)
                                        <span class="price">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn-two btn-sm mt-2">View Details</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Services Results -->
                @if(isset($results['services']) && $results['services']->count() > 0)
                <div class="row mb-50">
                    <div class="col-lg-12">
                        <h3 class="results__title">Services ({{ $results['services']->count() }})</h3>
                        <div class="row">
                            @foreach($results['services'] as $service)
                            <div class="col-md-4 mb-30">
                                <div class="search__service-card">
                                    @if($service->featured_image)
                                    <img src="{{ asset($service->featured_image) }}" alt="{{ $service->name }}">
                                    @endif
                                    <div class="search__service-content">
                                        <span class="category">{{ $service->category->name ?? 'Service' }}</span>
                                        <h5><a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a></h5>
                                        <p>{{ Str::limit($service->short_description, 100) }}</p>
                                        <a href="{{ route('services.show', $service->slug) }}" class="btn-two btn-sm mt-2">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Blog Posts Results -->
                @if(isset($results['posts']) && $results['posts']->count() > 0)
                <div class="row mb-50">
                    <div class="col-lg-12">
                        <h3 class="results__title">Blog Posts ({{ $results['posts']->count() }})</h3>
                        @foreach($results['posts'] as $post)
                        <div class="result__item">
                            <div class="result__meta">
                                <span class="category">{{ $post->category->name ?? 'Blog' }}</span>
                                <span class="date">{{ $post->published_at->format('M d, Y') }}</span>
                                @if($post->author)
                                <span class="author">By {{ $post->author->name }}</span>
                                @endif
                            </div>
                            <h4><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h4>
                            <p>{{ Str::limit($post->excerpt, 200) }}</p>
                            <span class="result__type"><i class="fas fa-newspaper"></i> Blog Post</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="no-results text-center py-5">
                            <i class="fas fa-search" style="font-size: 64px; color: #ccc;"></i>
                            <h3 class="mt-3">No Results Found</h3>
                            <p>We couldn't find any results matching "{{ $query }}"</p>
                            <p class="mt-3">Suggestions:</p>
                            <ul class="suggestions">
                                <li>Try different keywords</li>
                                <li>Check your spelling</li>
                                <li>Try more general search terms</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="row">
                <div class="col-lg-12">
                    <div class="search__help text-center py-5">
                        <i class="fas fa-info-circle" style="font-size: 64px; color: #4caf50;"></i>
                        <h3 class="mt-3">Start Your Search</h3>
                        <p>Enter keywords above to search our products, services, blog posts, and pages.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- Search Results End -->
@endsection

@push('styles')
<style>
.search__form .input-group {
    display: flex;
    gap: 10px;
}

.search__form .form-control {
    flex: 1;
    padding: 15px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
}

.search__form .form-control:focus {
    border-color: #4caf50;
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
}

.search__query {
    font-size: 18px;
    color: #666;
}

.results__title {
    font-size: 24px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #4caf50;
    color: #333;
}

.result__item {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.result__item:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
}

.result__meta {
    display: flex;
    gap: 20px;
    margin-bottom: 10px;
    font-size: 14px;
}

.result__meta .category {
    background: #e8f5e9;
    color: #4caf50;
    padding: 4px 12px;
    border-radius: 4px;
    font-weight: 600;
}

.result__meta .date,
.result__meta .author {
    color: #999;
}

.result__item h4 {
    font-size: 22px;
    margin: 15px 0;
}

.result__item h4 a {
    color: #333;
    text-decoration: none;
}

.result__item h4 a:hover {
    color: #4caf50;
}

.result__item p {
    color: #666;
    line-height: 1.8;
    margin: 10px 0;
}

.result__type {
    display: inline-block;
    color: #999;
    font-size: 13px;
    margin-top: 10px;
}

.result__type i {
    margin-right: 5px;
}

.search__product-card,
.search__service-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.search__product-card:hover,
.search__service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
}

.search__product-card img,
.search__service-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.search__product-content,
.search__service-content {
    padding: 20px;
}

.search__product-content .category,
.search__service-content .category {
    display: inline-block;
    background: #e8f5e9;
    color: #4caf50;
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 10px;
}

.search__product-content h5,
.search__service-content h5 {
    font-size: 18px;
    margin: 10px 0;
}

.search__product-content h5 a,
.search__service-content h5 a {
    color: #333;
    text-decoration: none;
}

.search__product-content h5 a:hover,
.search__service-content h5 a:hover {
    color: #4caf50;
}

.search__product-content .price {
    display: block;
    color: #4caf50;
    font-size: 20px;
    font-weight: 700;
    margin: 10px 0;
}

.search__service-content p {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
}

.no-results,
.search__help {
    background: #f8f9fa;
    padding: 60px 20px;
    border-radius: 8px;
}

.suggestions {
    list-style: none;
    padding: 0;
    margin: 20px 0 0;
}

.suggestions li {
    color: #666;
    padding: 5px 0;
}
</style>
@endpush
