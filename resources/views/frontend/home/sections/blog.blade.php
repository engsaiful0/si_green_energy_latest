@use('App\Support\Link')
@if($items->isNotEmpty())
<!-- Blog Area Start -->
<div class="blog__one section-padding">
    <div class="container">
        <div class="row al-end mb-35">
            <div class="col-lg-8 lg-mb-25">
                <div class="blog__one-title lg-t-center">
                    @if($c['subtitle'])<span class="subtitle-one">{{ $c['subtitle'] }}</span>@endif
                    <h2>{!! nl2br(e($c['title'])) !!}</h2>
                </div>
            </div>
            @if($c['button_text'])
            <div class="col-lg-4">
                <div class="blog__one-btn t-right lg-t-center">
                    <a class="btn-one" href="{{ Link::to($c['button_link']) }}">{{ $c['button_text'] }}</a>
                </div>
            </div>
            @endif
        </div>
        <div class="row dark_image">
            @foreach($items as $post)
            <div class="col-lg-4 col-md-6">
                <div class="blog__one-item">
                    <div class="blog__one-item-image">
                        <a href="{{ route('blog.show', $post->slug) }}"><img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"></a>
                    </div>
                    <div class="blog__one-item-content">
                        <h6><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h6>
                        <div class="blog__one-item-content-meta">
                            <span>{{ str_pad($post->readingMinutes(), 2, '0', STR_PAD_LEFT) }} Minutes</span>
                            <h6>{{ $post->publish_date?->format('F d, Y') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Blog Area End -->
@endif
