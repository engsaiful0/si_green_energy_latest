@php
    $contentPage = request()->routeIs('admin.content.*') ? request()->route('page') : null;
    $isContent = fn (string $page) => $contentPage === $page;
    $newMessages = \App\Models\ContactMessage::where('status', 'new')->count();

    // Collapsible management groups: [id, label, icon, links, active]
    $groups = [
        ['testimonials', 'Testimonial Management', 'fa-star', [
            ['Testimonials', route('admin.testimonials.index'), request()->routeIs('admin.testimonials.*')],
            ['Testimonials Page', route('admin.content.index', 'testimonials'), $isContent('testimonials')],
        ]],
        ['team', 'Solar Design Engineers', 'fa-hard-hat', [
            ['Team Members', route('admin.team.index'), request()->routeIs('admin.team.*')],
            ['Team Page', route('admin.content.index', 'team'), $isContent('team')],
        ]],
        ['gallery', 'Gallery Management', 'fa-images', [
            ['Gallery Images', route('admin.gallery.index'), request()->routeIs('admin.gallery.index', 'admin.gallery.create', 'admin.gallery.edit')],
            ['Gallery Categories', route('admin.gallery-categories.index'), request()->routeIs('admin.gallery-categories.*')],
            ['Homepage Carousel', route('admin.gallery.home'), request()->routeIs('admin.gallery.home')],
            ['Gallery Page', route('admin.content.index', 'gallery'), $isContent('gallery')],
        ]],
        ['products', 'Product Management', 'fa-box', [
            ['Product Categories', route('admin.product-categories.index'), request()->routeIs('admin.product-categories.*')],
            ['Products', route('admin.products.index'), request()->routeIs('admin.products.*')],
            ['Products Page', route('admin.content.index', 'products'), $isContent('products')],
        ]],
        ['solutions', 'Solution Management', 'fa-lightbulb', [
            ['Solution Categories', route('admin.solution-categories.index'), request()->routeIs('admin.solution-categories.*')],
            ['Solutions', route('admin.solutions.index'), request()->routeIs('admin.solutions.*')],
            ['Solutions Page', route('admin.content.index', 'solutions'), $isContent('solutions')],
        ]],
        ['services', 'Service Management', 'fa-cogs', [
            ['Service Categories', route('admin.service-categories.index'), request()->routeIs('admin.service-categories.*')],
            ['Services', route('admin.services.index'), request()->routeIs('admin.services.*')],
            ['Services Page', route('admin.content.index', 'services'), $isContent('services')],
        ]],
        ['projects', 'Project Management', 'fa-project-diagram', [
            ['Projects', route('admin.projects.index'), request()->routeIs('admin.projects.*')],
            ['Project Categories', route('admin.project-categories.index'), request()->routeIs('admin.project-categories.*')],
            ['Projects Page', route('admin.content.index', 'projects'), $isContent('projects')],
        ]],
        ['blog', 'Blog Management', 'fa-blog', [
            ['Blog Posts', route('admin.blog-posts.index'), request()->routeIs('admin.blog-posts.*')],
            ['Blog Categories', route('admin.blog-categories.index'), request()->routeIs('admin.blog-categories.*')],
            ['Blog Page', route('admin.content.index', 'blog'), $isContent('blog')],
        ]],
    ];
@endphp
<aside class="admin-sidebar">
    <!-- Logo -->
    <div class="logo">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('img/brand-si/logo-light.svg') }}" alt="{{ config('app.name') }}">
        </a>
    </div>

    <nav class="mt-3 pb-4">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
        </ul>

        <div class="menu-section">Website Pages</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ $isContent('home') ? 'active' : '' }}" href="{{ route('admin.content.index', 'home') }}">
                    <i class="fas fa-home"></i> Home Page CMS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">
                    <i class="fas fa-images"></i> Home Sliders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}" href="{{ route('admin.partners.index') }}">
                    <i class="fas fa-handshake"></i> Partner Logos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $isContent('company-profile') ? 'active' : '' }}" href="{{ route('admin.content.index', 'company-profile') }}">
                    <i class="fas fa-building"></i> Company Profile CMS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $isContent('privacy') ? 'active' : '' }}" href="{{ route('admin.content.index', 'privacy') }}">
                    <i class="fas fa-user-shield"></i> Privacy Policy
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $isContent('terms') ? 'active' : '' }}" href="{{ route('admin.content.index', 'terms') }}">
                    <i class="fas fa-file-contract"></i> Terms & Conditions
                </a>
            </li>
        </ul>

        <div class="menu-section">Content Management</div>
        <ul class="nav flex-column">
            @foreach($groups as [$id, $label, $icon, $links])
                @php $open = collect($links)->contains(fn ($link) => $link[2]); @endphp
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ $open ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#nav-{{ $id }}"
                       role="button" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="nav-{{ $id }}">
                        <i class="fas {{ $icon }}"></i> <span class="flex-grow-1">{{ $label }}</span>
                        <i class="fas fa-chevron-down small ms-1" style="width: auto;"></i>
                    </a>
                    <div class="collapse {{ $open ? 'show' : '' }}" id="nav-{{ $id }}">
                        <ul class="nav flex-column ms-3">
                            @foreach($links as [$text, $url, $active])
                            <li class="nav-item">
                                <a class="nav-link py-2 {{ $active ? 'active' : '' }}" href="{{ $url }}"><i class="fas fa-angle-right"></i> {{ $text }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="menu-section">Contact</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ $isContent('contact') ? 'active' : '' }}" href="{{ route('admin.content.index', 'contact') }}">
                    <i class="fas fa-address-card"></i> Contact Page CMS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                    <i class="fas fa-envelope"></i> <span class="flex-grow-1">Contact Messages</span>
                    @if($newMessages)<span class="badge bg-danger rounded-pill">{{ $newMessages }}</span>@endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}" href="{{ route('admin.quotes.index') }}">
                    <i class="fas fa-file-invoice"></i> Quote Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}" href="{{ route('admin.newsletter.index') }}">
                    <i class="fas fa-paper-plane"></i> Newsletter
                </a>
            </li>
        </ul>

        <div class="menu-section">SEO & Settings</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}" href="{{ route('admin.seo.index') }}">
                    <i class="fas fa-search"></i> SEO Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.content.references') ? 'active' : '' }}" href="{{ route('admin.content.references') }}">
                    <i class="fas fa-book"></i> Content References
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.general*') ? 'active' : '' }}" href="{{ route('admin.settings.general') }}">
                    <i class="fas fa-cog"></i> General Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                    <i class="fas fa-file-alt"></i> Custom Pages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" href="{{ route('admin.media.index') }}">
                    <i class="fas fa-photo-video"></i> Media Library
                </a>
            </li>
        </ul>

        <div class="menu-section">User Management</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                    <i class="fas fa-shield-alt"></i> Roles & Permissions
                </a>
            </li>
        </ul>
    </nav>
</aside>
