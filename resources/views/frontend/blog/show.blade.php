@extends('layouts.frontend')

@section('content')
@include('frontend.partials.breadcrumb', [
    'title' => $post->title,
    'image' => $settings['breadcrumb_image'],
    'crumbs' => array_values(array_filter([
        ['label' => $settings['title'], 'url' => route('blog.index')],
        $post->category ? ['label' => $post->category->name, 'url' => route('blog.category', $post->category->slug)] : null,
    ])),
])

<!-- Blog Details Area Start -->
<div class="blog__details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 lg-mb-50">
                <div class="blog__details-left dark_image">
                    <img class="img__full" src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
                    <div class="blog__details-left-meta">
                        @if($post->author)
                        <div class="blog__details-left-meta-left">
                            <div class="author">
                                <div class="author-avatar">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                                          style="width: 50px; height: 50px; background: var(--primary-color-1);">{{ strtoupper(substr($post->author->name, 0, 1)) }}</span>
                                </div>
                                <div class="author-info">
                                    <span>Author</span>
                                    <h6>{{ $post->author->name }}</h6>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="blog__details-left-meta-content">
                            <span>Date :</span>
                            <h6>{{ $post->publish_date?->format('F d, Y') }}</h6>
                        </div>
                        @if($post->category)
                        <div class="blog__details-left-meta-content">
                            <span>Category</span>
                            <h6><a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->name }}</a></h6>
                        </div>
                        @endif
                    </div>
                    <h3 class="mb-20">{{ $post->title }}</h3>
                    @if($post->excerpt)
                    <div class="blog__details-left-box">
                        <i class="flaticon-straight-quotes"></i>
                        <div><h5>{{ $post->excerpt }}</h5></div>
                    </div>
                    @endif
                    @include('frontend.partials.rich-text', ['text' => $post->content])

                    @if($post->tags->isNotEmpty())
                    <div class="blog__details-left-tag">
                        <h6>Related Tags :</h6>
                        <div class="all__sidebar-item-tag">
                            <ul>
                                @foreach($post->tags as $postTag)
                                <li><a href="{{ route('blog.tag', $postTag->slug) }}">{{ $postTag->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($previous || $next)
                    <div class="d-flex justify-content-between gap-3 mt-40">
                        <div>@if($previous)<a class="simple-btn" href="{{ route('blog.show', $previous->slug) }}"><i class="fa-regular fa-arrow-left me-2"></i>{{ \Illuminate\Support\Str::limit($previous->title, 40) }}</a>@endif</div>
                        <div class="text-end">@if($next)<a class="simple-btn" href="{{ route('blog.show', $next->slug) }}">{{ \Illuminate\Support\Str::limit($next->title, 40) }}<i class="fa-regular fa-arrow-right ms-2"></i></a>@endif</div>
                    </div>
                    @endif

                    @if($relatedPosts->isNotEmpty())
                    <div class="mt-60">
                        <h5 class="mb-30">Related Posts</h5>
                        <div class="row">
                            @foreach($relatedPosts as $related)
                            <div class="col-md-4 mb-25">
                                <div class="blog__one-item">
                                    <div class="blog__one-item-image">
                                        <a href="{{ route('blog.show', $related->slug) }}"><img src="{{ $related->imageUrl() }}" alt="{{ $related->title }}"></a>
                                    </div>
                                    <div class="blog__one-item-content">
                                        <h6><a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a></h6>
                                        <div class="blog__one-item-content-meta"><h6>{{ $related->publish_date?->format('M d, Y') }}</h6></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                @include('frontend.blog.sidebar')
            </div>
        </div>
    </div>
</div>
<!-- Blog Details Area End -->

@include('frontend.partials.page-cta', ['page' => 'blog'])
@endsection
