<!-- Page Text Area Start -->
<div class="legal__page section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                @if($c['updated'])
                <p class="text-muted mb-30"><em>Last updated: {{ $c['updated'] }}</em></p>
                @endif
                @include('frontend.partials.rich-text', ['text' => $c['body']])
            </div>
        </div>
    </div>
</div>
<!-- Page Text Area End -->
