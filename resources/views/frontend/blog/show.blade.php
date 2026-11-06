@extends('layouts.frontend')

@section('title', $blogPost->meta_title ?? $blogPost->title . ' - SI Green Energy Blog')
@section('meta_description', $blogPost->meta_description ?? $blogPost->excerpt)

@section('content')
<!-- Page Banner Start -->
<div class="page__banner" data-background="{{ asset('img/banner/page-banner.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__banner-content">
                    <h1>{{ $blogPost->title }}</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        @if($blogPost->category)
                        <li><a href="{{ route('blog.category', $blogPost->category->slug) }}">{{ $blogPost->category->name }}</a></li>
                        @endif
                        <li>{{ Str::limit($blogPost->title, 50) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Banner End -->

<!-- Blog Post Start -->
<div class="blog__post pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="post__content">
                    @if($blogPost->featured_image)
                    <div class="post__image mb-30">
                        <img src="{{ asset($blogPost->featured_image) }}" alt="{{ $blogPost->title }}">
                    </div>
                    @endif

                    <div class="post__meta mb-20">
                        @if($blogPost->category)
                        <a href="{{ route('blog.category', $blogPost->category->slug) }}" class="category">
                            <i class="fas fa-folder"></i> {{ $blogPost->category->name }}
                        </a>
                        @endif
                        <span class="date"><i class="far fa-calendar"></i> {{ $blogPost->published_at->format('F d, Y') }}</span>
                        @if($blogPost->author)
                        <span class="author"><i class="far fa-user"></i> By {{ $blogPost->author->name }}</span>
                        @endif
                    </div>

                    <h2 class="post__title">{{ $blogPost->title }}</h2>

                    @if($blogPost->excerpt)
                    <div class="post__excerpt">
                        <p class="lead">{{ $blogPost->excerpt }}</p>
                    </div>
                    @endif

                    <div class="post__body">
                        {!! nl2br(e($blogPost->content)) !!}
                    </div>

                    @if($blogPost->tags && $blogPost->tags->count() > 0)
                    <div class="post__tags mt-40">
                        <strong>Tags:</strong>
                        @foreach($blogPost->tags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}" class="tag">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    @endif
                </article>

                @if($relatedPosts && $relatedPosts->count() > 0)
                <div class="related__posts mt-50">
                    <h3 class="mb-30">Related Posts</h3>
                    <div class="row">
                        @foreach($relatedPosts as $related)
                        <div class="col-md-6 mb-30">
                            <div class="related__post-card">
                                @if($related->featured_image)
                                <img src="{{ asset($related->featured_image) }}" alt="{{ $related->title }}">
                                @endif
                                <div class="related__post-content">
                                    <span class="date">{{ $related->published_at->format('M d, Y') }}</span>
                                    <h4><a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a></h4>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                @if($blogPost->author)
                <div class="sidebar__widget mb-30">
                    <h4>About the Author</h4>
                    <div class="author__card">
                        <h5>{{ $blogPost->author->name }}</h5>
                        <p>{{ $blogPost->author->email }}</p>
                    </div>
                </div>
                @endif

                <div class="sidebar__widget">
                    <h4>More Articles</h4>
                    <p><a href="{{ route('blog.index') }}" class="btn-two">View All Posts</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.post__content {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.post__image img {
    width: 100%;
    border-radius: 8px;
}

.post__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    font-size: 14px;
}

.post__meta .category {
    color: #4caf50;
    font-weight: 600;
    text-decoration: none;
}

.post__meta .date,
.post__meta .author {
    color: #999;
}

.post__title {
    font-size: 32px;
    margin: 20px 0;
    color: #333;
}

.post__excerpt {
    margin: 20px 0;
    padding: 20px;
    background: #f8f9fa;
    border-left: 4px solid #4caf50;
}

.post__excerpt .lead {
    font-size: 18px;
    line-height: 1.8;
    color: #666;
    margin: 0;
}

.post__body {
    font-size: 16px;
    line-height: 1.9;
    color: #666;
    margin: 30px 0;
}

.post__tags {
    padding-top: 30px;
    border-top: 2px solid #f0f0f0;
}

.post__tags .tag {
    display: inline-block;
    background: #f0f0f0;
    padding: 6px 15px;
    border-radius: 4px;
    font-size: 13px;
    color: #666;
    text-decoration: none;
    margin: 5px;
    transition: all 0.3s ease;
}

.post__tags .tag:hover {
    background: #4caf50;
    color: #fff;
}

.related__post-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.related__post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
}

.related__post-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.related__post-content {
    padding: 20px;
}

.related__post-content .date {
    font-size: 13px;
    color: #999;
}

.related__post-content h4 {
    font-size: 18px;
    margin: 10px 0 0;
}

.related__post-content h4 a {
    color: #333;
    text-decoration: none;
}

.related__post-content h4 a:hover {
    color: #4caf50;
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

.author__card h5 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #333;
}

.author__card p {
    color: #666;
    font-size: 14px;
}
</style>
@endpush
