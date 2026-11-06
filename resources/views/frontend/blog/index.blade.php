@extends('layouts.frontend')

@section('title', 'Blog - SI Green Energy')
@section('meta_description', 'Read our latest articles about solar energy, renewable power, and sustainable living')

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>Our Blog</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Blog</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Blog Area Start -->
<div class="blog__area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <!-- Blog Posts -->
            <div class="col-lg-8">
                <!-- Featured Posts -->
                @if($featuredPosts && $featuredPosts->count() > 0)
                <div class="featured__posts mb-50">
                    <h3 class="mb-30">Featured Posts</h3>
                    <div class="row">
                        @foreach($featuredPosts as $featured)
                        <div class="col-md-4 mb-20">
                            <div class="featured__post-card">
                                @if($featured->featured_image)
                                <img src="{{ asset($featured->featured_image) }}" alt="{{ $featured->title }}">
                                @endif
                                <div class="featured__post-content">
                                    <h5><a href="{{ route('blog.show', $featured->slug) }}">{{ Str::limit($featured->title, 50) }}</a></h5>
                                    <span class="post-date"><i class="far fa-calendar"></i> {{ $featured->published_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Blog Posts Grid -->
                @if($posts->count() > 0)
                @foreach($posts as $post)
                <div class="blog__item mb-40">
                    @if($post->featured_image)
                    <div class="blog__item-image">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                        </a>
                        @if($post->is_featured)
                        <span class="badge-featured">Featured</span>
                        @endif
                    </div>
                    @endif

                    <div class="blog__item-content">
                        <div class="blog__item-meta">
                            @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="category">
                                <i class="fas fa-folder"></i> {{ $post->category->name }}
                            </a>
                            @endif
                            <span class="date"><i class="far fa-calendar"></i> {{ $post->published_at->format('M d, Y') }}</span>
                            @if($post->author)
                            <span class="author"><i class="far fa-user"></i> {{ $post->author->name }}</span>
                            @endif
                        </div>

                        <h3><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h3>

                        @if($post->excerpt)
                        <p>{{ Str::limit($post->excerpt, 200) }}</p>
                        @endif

                        @if($post->tags && $post->tags->count() > 0)
                        <div class="blog__item-tags">
                            @foreach($post->tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}" class="tag">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                        @endif

                        <a href="{{ route('blog.show', $post->slug) }}" class="btn-two">Read More</a>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                <div class="pagination__area">
                    {{ $posts->links() }}
                </div>
                @else
                <div class="no-posts text-center py-5">
                    <i class="far fa-newspaper" style="font-size: 64px; color: #ccc;"></i>
                    <h4 class="mt-3">No Posts Found</h4>
                    <p>Check back soon for new articles!</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                @if($categories && $categories->count() > 0)
                <div class="sidebar__widget mb-30">
                    <h4>Categories</h4>
                    <ul class="category-list">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blog.category', $category->slug) }}">
                                {{ $category->name }}
                                <span class="count">({{ $category->posts_count }})</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Tags -->
                @if($tags && $tags->count() > 0)
                <div class="sidebar__widget mb-30">
                    <h4>Tags</h4>
                    <div class="tag-cloud">
                        @foreach($tags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}" class="tag">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Blog Area End -->
@endsection

@push('styles')
<style>
.blog__item {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.blog__item:hover {
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
}

.blog__item-image {
    position: relative;
    overflow: hidden;
}

.blog__item-image img {
    width: 100%;
    height: 350px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog__item:hover .blog__item-image img {
    transform: scale(1.05);
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

.blog__item-content {
    padding: 30px;
}

.blog__item-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 15px;
    font-size: 14px;
}

.blog__item-meta .category {
    color: #4caf50;
    text-decoration: none;
    font-weight: 600;
}

.blog__item-meta .date,
.blog__item-meta .author {
    color: #999;
}

.blog__item-content h3 {
    margin: 15px 0;
    font-size: 24px;
}

.blog__item-content h3 a {
    color: #333;
    text-decoration: none;
}

.blog__item-content h3 a:hover {
    color: #4caf50;
}

.blog__item-content p {
    color: #666;
    line-height: 1.8;
    margin: 15px 0;
}

.blog__item-tags {
    margin: 20px 0;
}

.blog__item-tags .tag {
    display: inline-block;
    background: #f0f0f0;
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 12px;
    color: #666;
    text-decoration: none;
    margin: 3px;
    transition: all 0.3s ease;
}

.blog__item-tags .tag:hover {
    background: #4caf50;
    color: #fff;
}

.featured__post-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.featured__post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
}

.featured__post-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.featured__post-content {
    padding: 15px;
}

.featured__post-content h5 {
    font-size: 14px;
    margin-bottom: 8px;
}

.featured__post-content h5 a {
    color: #333;
    text-decoration: none;
}

.featured__post-content .post-date {
    font-size: 12px;
    color: #999;
}

.sidebar__widget {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.sidebar__widget h4 {
    font-size: 20px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li {
    border-bottom: 1px solid #f0f0f0;
}

.category-list li:last-child {
    border-bottom: none;
}

.category-list a {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.category-list a:hover {
    color: #4caf50;
}

.category-list .count {
    color: #999;
    font-size: 14px;
}

.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.tag-cloud .tag {
    display: inline-block;
    background: #f0f0f0;
    padding: 6px 15px;
    border-radius: 4px;
    font-size: 13px;
    color: #666;
    text-decoration: none;
    transition: all 0.3s ease;
}

.tag-cloud .tag:hover {
    background: #4caf50;
    color: #fff;
}

.pagination__area {
    text-align: center;
    margin-top: 20px;
}
</style>
@endpush
