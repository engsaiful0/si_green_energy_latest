@extends('layouts.frontend')

@section('title', 'Products - SI Green Energy')
@section('meta_description', 'Browse our range of solar and renewable energy products')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>Our Products</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Products</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Products Area Start -->
<div class="product__area pt-100 pb-100">
    <div class="container">
        <div class="row mb-40">
            <div class="col-lg-12">
                <div class="section__title text-center">
                    <h2>Browse Our Products</h2>
                    <p>Explore our comprehensive range of solar and renewable energy solutions</p>
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        @if($categories->count() > 0)
        <div class="row mb-40">
            <div class="col-lg-12">
                <div class="product__filter text-center">
                    <a href="{{ route('products.index') }}" class="btn-filter {{ request()->is('products') ? 'active' : '' }}">All Products</a>
                    @foreach($categories as $category)
                        <a href="{{ route('products.category', $category->slug) }}" class="btn-filter">
                            {{ $category->name }} ({{ $category->products_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-4 col-md-6 mb-30">
                <div class="product__item">
                    @if($product->featured_image)
                    <div class="product__item-image">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}">
                        </a>
                        @if($product->is_featured)
                        <span class="badge-featured">Featured</span>
                        @endif
                    </div>
                    @endif

                    <div class="product__item-content">
                        @if($product->category)
                        <span class="product__item-category">{{ $product->category->name }}</span>
                        @endif

                        <h4><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h4>

                        @if($product->short_description)
                        <p>{{ Str::limit($product->short_description, 100) }}</p>
                        @endif

                        <div class="product__item-bottom">
                            @if($product->sale_price)
                            <div class="product__item-price">
                                <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                            </div>
                            @elseif($product->price)
                            <div class="product__item-price">
                                <span class="new-price">${{ number_format($product->price, 2) }}</span>
                            </div>
                            @endif

                            <a href="{{ route('products.show', $product->slug) }}" class="btn-two">View Details</a>
                        </div>

                        @if($product->stock_quantity !== null)
                        <div class="product__item-stock mt-3">
                            @if($product->stock_quantity > 0)
                            <span class="badge bg-success">In Stock ({{ $product->stock_quantity }})</span>
                            @else
                            <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-40">
            <div class="col-lg-12">
                <div class="pagination__area">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-12">
                <div class="no-products text-center py-5">
                    <i class="flaticon-solar-panel" style="font-size: 64px; color: #ccc;"></i>
                    <h4 class="mt-3">No Products Found</h4>
                    <p>There are currently no products available in this category.</p>
                    <a href="{{ route('products.index') }}" class="btn-one mt-3">View All Products</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Products Area End -->

<!-- Call to Action -->
<div class="cta__area pt-70 pb-70" style="background: #f8f9fa;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Need help choosing the right product?</h3>
                <p>Our experts are here to help you find the perfect solution for your energy needs.</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('contact') }}" class="btn-one">Contact Us</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.product__item {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.product__item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
}

.product__item-image {
    position: relative;
    overflow: hidden;
}

.product__item-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product__item:hover .product__item-image img {
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

.product__item-content {
    padding: 25px;
}

.product__item-category {
    display: inline-block;
    background: #e8f5e9;
    color: #4caf50;
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 10px;
}

.product__item-content h4 {
    margin: 10px 0;
    font-size: 20px;
}

.product__item-content h4 a {
    color: #333;
    text-decoration: none;
}

.product__item-content h4 a:hover {
    color: #4caf50;
}

.product__item-content p {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
    margin: 10px 0;
}

.product__item-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.product__item-price .old-price {
    text-decoration: line-through;
    color: #999;
    margin-right: 10px;
    font-size: 14px;
}

.product__item-price .new-price {
    color: #4caf50;
    font-size: 20px;
    font-weight: 700;
}

.product__filter {
    margin-bottom: 30px;
}

.btn-filter {
    display: inline-block;
    padding: 10px 25px;
    margin: 5px;
    border: 2px solid #4caf50;
    border-radius: 25px;
    color: #4caf50;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 600;
}

.btn-filter:hover,
.btn-filter.active {
    background: #4caf50;
    color: #fff;
}

.pagination__area {
    text-align: center;
}

.no-products {
    background: #f8f9fa;
    padding: 60px 20px;
    border-radius: 8px;
}
</style>
@endpush
