{{--
    Slaze breadcrumb banner.
    $title   heading
    $image   optional background (path/URL), defaults to the theme banner
    $crumbs  optional [['label' => ..., 'url' => ...], ...] between Home and the current page
--}}
<!-- Breadcrumb Area Start -->
<div class="breadcrumb__area" style="background-image: url('{{ \App\Support\Media::url($image ?? null, 'img/pages/breadcrumb.jpg') }}');">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb__area-content">
                    <h1>{{ $title }}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a><i class="fa-regular fa-angle-right"></i></li>
                        @foreach($crumbs ?? [] as $crumb)
                        <li><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a><i class="fa-regular fa-angle-right"></i></li>
                        @endforeach
                        <li>{{ \Illuminate\Support\Str::limit($title, 60) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->
