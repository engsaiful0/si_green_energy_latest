<footer class="admin-footer mt-5 py-3 border-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0 text-muted">
                    &copy; {{ date('Y') }} {{ config('app.name', 'SI Green Energy') }}. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-muted">
                    Version 1.0.0 | Powered by Laravel {{ app()->version() }}
                </p>
            </div>
        </div>
    </div>
</footer>
