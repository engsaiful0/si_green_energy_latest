<!-- Hamburger Start -->
<div class="header__area-menubar-right-sidebar-popup">
    <div class="sidebar-close-btn"><i class="fal fa-times"></i></div>
    <div class="header__area-menubar-right-sidebar-popup-logo">
        <a href="{{ route('home') }}"><img src="{{ \App\Support\Media::url($site['logo_light']) }}" alt="{{ $site['site_name'] }}"></a>
    </div>
    @if($site['sidebar_text'])
    <p>{{ $site['sidebar_text'] }}</p>
    @endif
    <div class="header__area-menubar-right-sidebar-popup-contact">
        <h4 class="mb-30">Get In Touch</h4>
        @if($site['phone'])
        <div class="header__area-menubar-right-sidebar-popup-contact-item">
            <div class="header__area-menubar-right-sidebar-popup-contact-item-icon">
                <i class="fal fa-phone-alt icon-animation"></i>
            </div>
            <div class="header__area-menubar-right-sidebar-popup-contact-item-content">
                <span>Call Now</span>
                <h6><a href="{{ \App\Support\Link::tel($site['phone']) }}">{{ $site['phone'] }}</a></h6>
            </div>
        </div>
        @endif
        @if($site['support_email'])
        <div class="header__area-menubar-right-sidebar-popup-contact-item">
            <div class="header__area-menubar-right-sidebar-popup-contact-item-icon">
                <i class="fal fa-envelope"></i>
            </div>
            <div class="header__area-menubar-right-sidebar-popup-contact-item-content">
                <span>Quick Email</span>
                <h6><a href="mailto:{{ $site['support_email'] }}">{{ $site['support_email'] }}</a></h6>
            </div>
        </div>
        @endif
        @if($site['address'])
        <div class="header__area-menubar-right-sidebar-popup-contact-item">
            <div class="header__area-menubar-right-sidebar-popup-contact-item-icon">
                <i class="fal fa-map-marker-alt"></i>
            </div>
            <div class="header__area-menubar-right-sidebar-popup-contact-item-content">
                <span>Office Address</span>
                <h6><a href="{{ $site['address_link'] ?: '#' }}" target="_blank" rel="noopener">{{ $site['address'] }}</a></h6>
            </div>
        </div>
        @endif
    </div>
    @if(count($socialLinks))
    <div class="header__area-menubar-right-sidebar-popup-social social__icon">
        <ul>
            @include('components.frontend.social-links')
        </ul>
    </div>
    @endif
</div>
<div class="sidebar-overlay"></div>
<!-- Hamburger End -->
