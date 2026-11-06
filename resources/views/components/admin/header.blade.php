<header class="admin-header">
    <!-- Left Side -->
    <div class="d-flex align-items-center">
        <!-- Mobile Menu Toggle -->
        <button class="btn btn-link d-md-none me-3" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @yield('breadcrumb')
            </ol>
        </nav>
    </div>

    <!-- Right Side -->
    <div class="d-flex align-items-center gap-3">
        <!-- View Site -->
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary" target="_blank">
            <i class="fas fa-external-link-alt"></i> View Site
        </a>

        <!-- Notifications -->
        <div class="dropdown">
            <button class="btn btn-link position-relative" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-bell fa-lg"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">Notifications</h6></li>
                <li><a class="dropdown-item" href="#">New contact message</a></li>
                <li><a class="dropdown-item" href="#">New quote request</a></li>
                <li><a class="dropdown-item" href="#">New newsletter subscriber</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
            </ul>
        </div>

        <!-- User Menu -->
        <div class="dropdown">
            <button class="btn btn-link user-menu" type="button" data-bs-toggle="dropdown">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                <i class="fas fa-chevron-down ms-1"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">{{ auth()->user()->email ?? 'admin@example.com' }}</h6></li>
                <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings.general') }}"><i class="fas fa-cog me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
