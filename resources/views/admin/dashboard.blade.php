@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Dashboard</h2>
        <div>
            <span class="text-muted">Welcome back, {{ auth()->user()->name }}!</span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Users</p>
                            <h3 class="mb-0">{{ $stats['users'] }}</h3>
                            <small class="text-muted">System users</small>
                        </div>
                        <div class="icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pages -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Pages</p>
                            <h3 class="mb-0">{{ $stats['pages'] }}</h3>
                            <small class="text-muted">Website pages</small>
                        </div>
                        <div class="icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-file"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Products</p>
                            <h3 class="mb-0">{{ $stats['products'] }}</h3>
                            <small class="text-muted">Product catalog</small>
                        </div>
                        <div class="icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Services</p>
                            <h3 class="mb-0">{{ $stats['services'] }}</h3>
                            <small class="text-muted">Service offerings</small>
                        </div>
                        <div class="icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-cogs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Business Statistics -->
    <div class="row g-3 mb-4">
        <!-- Projects -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Projects</p>
                            <h3 class="mb-0">{{ $stats['projects'] }}</h3>
                            <small class="text-muted">Portfolio items</small>
                        </div>
                        <div class="icon bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Posts -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Blog Posts</p>
                            <h3 class="mb-0">{{ $stats['blog_posts'] }}</h3>
                            <small class="text-muted">Published articles</small>
                        </div>
                        <div class="icon bg-purple bg-opacity-10 text-purple">
                            <i class="fas fa-blog"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Messages -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Contact Messages</p>
                            <h3 class="mb-0">{{ $stats['contact_messages'] }}</h3>
                            <small class="text-muted">Total enquiries</small>
                        </div>
                        <div class="icon bg-secondary bg-opacity-10 text-secondary">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quote Requests -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Quote Requests</p>
                            <h3 class="mb-0">{{ $stats['quote_requests'] }}</h3>
                            <small class="text-muted">Total requests</small>
                        </div>
                        <div class="icon bg-dark bg-opacity-10 text-dark">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Tables Row -->
    <div class="row g-3">
        <!-- Monthly Enquiries Chart -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Monthly Enquiries</h5>
                </div>
                <div class="card-body">
                    <canvas id="enquiriesChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Content Distribution -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Content Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="contentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-3 mt-0">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Quote Requests</h5>
                    <a href="{{ route('admin.quotes.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>Solar Installation</td>
                                    <td>Nov 2, 2026</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>Wind Energy</td>
                                    <td>Nov 1, 2026</td>
                                    <td><span class="badge bg-primary">Processing</span></td>
                                </tr>
                                <tr>
                                    <td>Mike Johnson</td>
                                    <td>Solar Panels</td>
                                    <td>Oct 30, 2026</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Blog Posts</h5>
                    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Benefits of Solar Energy</td>
                                    <td>Nov 1, 2026</td>
                                    <td>1,245</td>
                                    <td><span class="badge bg-success">Published</span></td>
                                </tr>
                                <tr>
                                    <td>Wind Power Solutions</td>
                                    <td>Oct 28, 2026</td>
                                    <td>892</td>
                                    <td><span class="badge bg-success">Published</span></td>
                                </tr>
                                <tr>
                                    <td>Green Energy Future</td>
                                    <td>Oct 25, 2026</td>
                                    <td>2,156</td>
                                    <td><span class="badge bg-success">Published</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Monthly Enquiries Chart
    const enquiriesCtx = document.getElementById('enquiriesChart').getContext('2d');
    new Chart(enquiriesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Quote Requests',
                data: [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 45],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Contact Messages',
                data: [8, 12, 10, 15, 18, 20, 17, 22, 25, 28, 26, 30],
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Content Distribution Chart
    const contentCtx = document.getElementById('contentChart').getContext('2d');
    new Chart(contentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Products', 'Services', 'Projects', 'Blog Posts'],
            datasets: [{
                data: [24, 12, 48, 86],
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#0dcaf0',
                    '#ffc107'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
