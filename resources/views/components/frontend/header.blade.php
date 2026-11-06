<!-- Header Area Start -->
<div class="header__area">
    <div class="custom__container">
        <div class="header__area-menubar">
            <div class="header__area-menubar-left one">
                <div class="header__area-menubar-left-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ \App\Support\Media::url($site['logo']) }}" alt="{{ $site['site_name'] }}">
                    </a>
                </div>
            </div>
            <div class="header__area-menubar-center">
                <div class="header__area-menubar-center-menu">
                    <ul id="mobilemenu">
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                        <li class="menu-item-has-children {{ request()->routeIs('company-profile', 'testimonials', 'team.*', 'gallery') ? 'active' : '' }}"><a href="{{ route('company-profile') }}">About</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('company-profile') }}">Company Profile</a></li>
                                <li><a href="{{ route('testimonials') }}">Testimonial</a></li>
                                <li><a href="{{ route('team.index') }}">Solar Design Engineer</a></li>
                                <li><a href="{{ route('gallery') }}">Gallery</a></li>
                            </ul>
                        </li>
                        @foreach($navCatalogs as $catalog)
                        <li class="{{ $catalog['categories']->isNotEmpty() ? 'menu-item-has-children' : '' }} {{ request()->routeIs($catalog['prefix'] . '.*') ? 'active' : '' }}"><a href="{{ route($catalog['prefix'] . '.index') }}">{{ $catalog['label'] }}</a>
                            @if($catalog['categories']->isNotEmpty())
                            <ul class="sub-menu">
                                <li><a href="{{ route($catalog['prefix'] . '.index') }}">All {{ $catalog['label'] }}</a></li>
                                @foreach($catalog['categories'] as $category)
                                <li><a href="{{ route($catalog['prefix'] . '.category', $category->slug) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                        <li class="{{ request()->routeIs('projects.*') ? 'active' : '' }}"><a href="{{ route('projects.index') }}">Projects</a></li>
                        <li class="{{ request()->routeIs('blog.*') ? 'active' : '' }}"><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="header__area-menubar-right">
                <div class="header__area-menubar-right-sidebar">
                    <div class="header__area-menubar-right-sidebar-popup-icon" role="button" aria-label="Open contact panel"><i class="flaticon-menu-2"></i></div>
                </div>
                @if($site['header_button_text'])
                <div class="header__area-menubar-right-btn">
                    <a class="btn-one" href="{{ \App\Support\Link::to($site['header_button_link']) }}">{{ $site['header_button_text'] }}</a>
                </div>
                @endif
                <div class="header__area-menubar-right-responsive-menu menu__bar" role="button" aria-label="Open menu">
                    <i class="flaticon-menu-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header Area End -->
