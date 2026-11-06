@extends('layouts.frontend')

@section('title', $product->meta_title ?? $product->name . ' - SI Green Energy')
@section('meta_description', $product->meta_description ?? $product->short_description)

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>{{ $product->name }}</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                        @if($product->category)
                        <li><a href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                        @endif
                        <li>{{ $product->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Product Details Start -->
<div class="product__details pt-100 pb-70">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-30">
                <div class="product__details-image">
                    @if($product->featured_image)
                    <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="main-image">
                    @else
                    <img src="{{ asset('img/placeholder-product.jpg') }}" alt="{{ $product->name }}" class="main-image">
                    @endif

                    @if($product->images && $product->images->count() > 0)
                    <div class="product__details-thumbnails mt-3">
                        @foreach($product->images as $image)
                        <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="thumbnail-image">
                        @endforeach
                    </div>
                    @endif

                    @if($product->is_featured)
                    <span class="badge-featured">Featured</span>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6 mb-30">
                <div class="product__details-content">
                    @if($product->category)
                    <span class="product-category">{{ $product->category->name }}</span>
                    @endif

                    <h2>{{ $product->name }}</h2>

                    @if($product->sku)
                    <p class="product-sku">SKU: <strong>{{ $product->sku }}</strong></p>
                    @endif

                    <!-- Price -->
                    <div class="product-price">
                        @if($product->sale_price)
                        <span class="old-price">${{ number_format($product->price, 2) }}</span>
                        <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="save-badge">Save ${{ number_format($product->price - $product->sale_price, 2) }}</span>
                        @elseif($product->price)
                        <span class="new-price">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    @if($product->stock_quantity !== null)
                    <div class="product-stock mt-3">
                        @if($product->stock_quantity > 0)
                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> In Stock ({{ $product->stock_quantity }} available)</span>
                        @else
                        <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Out of Stock</span>
                        @endif
                    </div>
                    @endif

                    <!-- Short Description -->
                    @if($product->short_description)
                    <div class="product-short-desc mt-4">
                        <p>{{ $product->short_description }}</p>
                    </div>
                    @endif

                    <!-- Specifications -->
                    @if($product->specifications)
                    <div class="product-specs mt-4">
                        <h5>Specifications:</h5>
                        <div class="specs-content">
                            {!! nl2br(e($product->specifications)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="product-actions mt-4">
                        <a href="{{ route('quote') }}" class="btn-one">Request Quote</a>
                        <a href="{{ route('contact') }}" class="btn-two ms-2">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        @if($product->description)
        <div class="row mt-50">
            <div class="col-lg-12">
                <div class="product__description">
                    <h3>Product Description</h3>
                    <div class="description-content">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="row mt-70">
            <div class="col-lg-12">
                <div class="section__title text-center mb-40">
                    <h3>Related Products</h3>
                    <p>You might also be interested in these products</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($relatedProducts as $related)
            <div class="col-lg-3 col-md-6 mb-30">
                <div class="product__item">
                    @if($related->featured_image)
                    <div class="product__item-image">
                        <a href="{{ route('products.show', $related->slug) }}">
                            <img src="{{ asset($related->featured_image) }}" alt="{{ $related->name }}">
                        </a>
                    </div>
                    @endif

                    <div class="product__item-content">
                        <h4><a href="{{ route('products.show', $related->slug) }}">{{ $related->name }}</a></h4>
                        @if($related->sale_price)
                        <div class="product__item-price">
                            <span class="old-price">${{ number_format($related->price, 2) }}</span>
                            <span class="new-price">${{ number_format($related->sale_price, 2) }}</span>
                        </div>
                        @elseif($related->price)
                        <div class="product__item-price">
                            <span class="new-price">${{ number_format($related->price, 2) }}</span>
                        </div>
                        @endif
                        <a href="{{ route('products.show', $related->slug) }}" class="btn-two mt-2">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- Product Details End -->
@endsection

@push('styles')
<style>
.product__details-image {
    position: relative;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    padding: 20px;
}

.product__details-image .main-image {
    width: 100%;
    border-radius: 8px;
}

.badge-featured {
    position: absolute;
    top: 30px;
    right: 30px;
    background: #ff6b35;
    color: #fff;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
}

.product__details-thumbnails {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.thumbnail-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-image:hover {
    border-color: #4caf50;
}

.product__details-content {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.product-category {
    display: inline-block;
    background: #e8f5e9;
    color: #4caf50;
    padding: 6px 15px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 15px;
}

.product__details-content h2 {
    font-size: 32px;
    margin: 15px 0;
    color: #333;
}

.product-sku {
    color: #666;
    font-size: 14px;
    margin: 10px 0;
}

.product-price {
    margin: 25px 0;
}

.product-price .old-price {
    text-decoration: line-through;
    color: #999;
    font-size: 20px;
    margin-right: 15px;
}

.product-price .new-price {
    color: #4caf50;
    font-size: 36px;
    font-weight: 700;
}

.save-badge {
    display: inline-block;
    background: #ff6b35;
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    margin-left: 15px;
}

.product-stock {
    margin: 15px 0;
}

.product-stock .badge {
    font-size: 14px;
    padding: 8px 15px;
}

.product-short-desc p {
    font-size: 16px;
    line-height: 1.8;
    color: #666;
}

.product-specs {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.product-specs h5 {
    margin-bottom: 15px;
    color: #333;
}

.specs-content {
    color: #666;
    line-height: 1.8;
}

.product-actions {
    display: flex;
    gap: 15px;
}

.product__description {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.product__description h3 {
    margin-bottom: 25px;
    color: #333;
}

.description-content {
    font-size: 16px;
    line-height: 1.8;
    color: #666;
}

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

.product__item-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product__item-content {
    padding: 20px;
}

.product__item-content h4 {
    font-size: 18px;
    margin: 10px 0;
}

.product__item-content h4 a {
    color: #333;
    text-decoration: none;
}

.product__item-content h4 a:hover {
    color: #4caf50;
}

.product__item-price .old-price {
    text-decoration: line-through;
    color: #999;
    margin-right: 10px;
    font-size: 14px;
}

.product__item-price .new-price {
    color: #4caf50;
    font-size: 18px;
    font-weight: 700;
}
</style>
@endpush
