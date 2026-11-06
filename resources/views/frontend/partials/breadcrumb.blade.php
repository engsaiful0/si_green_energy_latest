{{-- Slaze breadcrumb banner. Expects $title. --}}
<!-- Breadcrumb Area Start -->
<div class="breadcrumb__area" style="background-image: url('{{ asset('img/pages/breadcrumb.jpg') }}');">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb__area-content">
                    <h1>{{ $title }}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a><i class="fa-regular fa-angle-right"></i></li>
                        <li>{{ $title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->
