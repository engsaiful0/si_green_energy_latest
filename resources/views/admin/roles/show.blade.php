@extends('layouts.admin')

@section('title', 'View Role')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Role Details</h1>
            <p class="text-muted mb-0">View role information and assigned permissions</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Role
            </a>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Role Information Card -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="role-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>

                    <h4 class="text-center mb-1">{{ $role->name }}</h4>
                    <p class="text-center">
                        <span class="badge bg-primary">{{ $role->slug }}</span>
                    </p>

                    @if($role->description)
                        <p class="text-muted text-center mb-3">{{ $role->description }}</p>
                    @endif

                    <hr>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-key text-primary me-2"></i>Permissions</span>
                            <strong>{{ $role->permissions->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-users text-success me-2"></i>Assigned Users</span>
                            <strong>{{ $role->users()->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-folder text-info me-2"></i>Modules</span>
                            <strong>{{ $groupedPermissions->count() }}</strong>
                        </div>
                    </div>

                    <hr>

                    <p class="small mb-2"><strong>Created:</strong> {{ $role->created_at->format('M d, Y g:i A') }}</p>
                    <p class="small mb-0"><strong>Last Updated:</strong> {{ $role->updated_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-key me-2"></i>Assigned Permissions
                    </h5>
                </div>
                <div class="card-body">
                    @if($groupedPermissions->count() > 0)
                        @foreach($groupedPermissions as $module => $permissions)
                            <div class="border rounded p-3 mb-3 bg-light">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-folder me-2"></i>{{ ucfirst($module) }} Module
                                    <span class="badge bg-primary float-end">{{ $permissions->count() }}</span>
                                </h6>

                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                                <div>
                                                    <strong>{{ $permission->name }}</strong>
                                                    @if($permission->description)
                                                        <br><small class="text-muted">{{ $permission->description }}</small>
                                                    @endif
                                                    <br><code class="small">{{ $permission->slug }}</code>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Total:</strong> {{ $role->permissions->count() }} permissions across {{ $groupedPermissions->count() }} modules
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-key fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No permissions assigned to this role</p>
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>Assign Permissions
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.role-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    margin: 0 auto;
}
</style>
@endsection
