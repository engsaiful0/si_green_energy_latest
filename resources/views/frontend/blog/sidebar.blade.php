{{-- Blog sidebar (Slaze all__sidebar). Expects $listing, $sidebarCategories, $recentPosts, $popularTags. --}}
<div class="all__sidebar ml-25">
    <div class="all__sidebar-item">
        <h6>{{ $listing['search_title'] }}</h6>
        <div class="all__sidebar-item-search">
            <form action="{{ route('blog.index') }}" method="GET" role="search">
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Search....." aria-label="Search the blog">
                <button type="submit" aria-label="Search"><i class="fal fa-search"></i></button>
            </form>
        </div>
    </div>

    @include('frontend.partials.sidebar-links', ['title' => $listing['categories_title'], 'links' => $sidebarCategories])

    @if($recentPosts->isNotEmpty())
    <div class="all__sidebar-item">
        <h6>{{ $listing['recent_title'] }}</h6>
        <div class="all__sidebar-item-post dark_image">
            @foreach($recentPosts as $recent)
            <div class="post__item">
                <div class="post__item-image">
                    <a href="{{ route('blog.show', $recent->slug) }}"><img src="{{ $recent->imageUrl() }}" alt="{{ $recent->title }}"></a>
                </div>
                <div class="post__item-title">
                    <h6><a href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a></h6>
                    <span><i class="far fa-calendar-alt"></i>{{ $recent->publish_date?->format('M d, Y') }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($popularTags->isNotEmpty())
    <div class="all__sidebar-item">
        <h6>{{ $listing['tags_title'] }}</h6>
        <div class="all__sidebar-item-tag">
            <ul>
                @foreach($popularTags as $popularTag)
                <li><a href="{{ route('blog.tag', $popularTag->slug) }}">{{ $popularTag->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
