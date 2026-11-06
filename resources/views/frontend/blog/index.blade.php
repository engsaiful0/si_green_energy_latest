@extends('layouts.frontend')

@section('content')
@include('frontend.partials.breadcrumb', [
    'title' => $title,
    'image' => $settings['breadcrumb_image'],
    'crumbs' => ($category || $tag || $search !== '') ? [['label' => $settings['title'], 'url' => route('blog.index')]] : [],
])

<!-- Blog Standard Area Start -->
<div class="blog__standard-arae section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 lg-mb-50">
                <div class="blog__standard dark_image">
                    @forelse($posts as $post)
                    <div class="blog__standard-item">
                        <div class="blog__standard-item-image">
                            <a href="{{ route('blog.show', $post->slug) }}"><img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"></a>
                        </div>
                        <div class="blog__standard-item-content">
                            <div class="blog__standard-item-content-meta">
                                <ul>
                                    @if($post->author)<li><span><i class="fal fa-user"></i>{{ $post->author->name }}</span></li>@endif
                                    <li><span><i class="fal fa-calendar-alt"></i>{{ $post->publish_date?->format('d, F Y') }}</span></li>
                                    @if($post->category)<li><a href="{{ route('blog.category', $post->category->slug) }}"><i class="fal fa-folder"></i>{{ $post->category->name }}</a></li>@endif
                                    <li><span><i class="fal fa-clock"></i>{{ $post->readingMinutes() }} min read</span></li>
                                </ul>
                            </div>
                            <h5><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h5>
                            <p>{{ \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->content), 220) }}</p>
                            <a class="btn-one" href="{{ route('blog.show', $post->slug) }}">{{ $listing['read_more'] }}</a>
                        </div>
                    </div>
                    @empty
                    <p>{{ $listing['empty_text'] }}</p>
                    @endforelse
                </div>
                {{ $posts->links('frontend.partials.pagination') }}
            </div>
            <div class="col-xl-4 col-lg-4">
                @include('frontend.blog.sidebar')
            </div>
        </div>
    </div>
</div>
<!-- Blog Standard Area End -->
@endsection
