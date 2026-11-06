<!-- Top Bar Area Start -->
<div class="topBar__one">
    <div class="custom__container">
        <div class="row al-center">
            <div class="col-lg-8">
                <div class="topBar__one-left lg-t-center">
                    <ul>
                        @if($site['phone'])
                        <li><a href="{{ \App\Support\Link::tel($site['phone']) }}"><i class="flaticon-phone-call"></i>{{ $site['phone'] }}</a></li>
                        @endif
                        @if($site['email'])
                        <li><a href="mailto:{{ $site['email'] }}"><i class="flaticon-envelope"></i>{{ $site['email'] }}</a></li>
                        @endif
                        @if($site['address'])
                        <li><a href="{{ $site['address_link'] ?: '#' }}" target="_blank" rel="noopener"><i class="flaticon-placeholder"></i>{{ $site['address'] }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="topBar__one-right t-right lg-t-center">
                    @if(count($socialLinks))
                    <div class="topBar__one-right-social">
                        <h6>Follow Us</h6>
                        <ul>
                            @include('components.frontend.social-links')
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Bar Area End -->
