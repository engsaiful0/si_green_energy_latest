<!-- Mobile Menu Start -->
<div class="menu__bar-popup">
    <div class="menu__bar-popup-top">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ \App\Support\Media::url($site['logo_light']) }}" alt="{{ $site['site_name'] }}">
            </a>
        </div>
        <div class="close"><i class="fal fa-times"></i></div>
    </div>
    <div class="vertical-menu">
        <div class="vertical_menu">
            <!-- Here Menu Will Come Automatically Via Javascript / Same Menu as in Header -->
        </div>
    </div>
</div>
<div class="menu__bar-popup-overlay"></div>
<!-- Mobile Menu End -->
