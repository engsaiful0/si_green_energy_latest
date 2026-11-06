@extends('layouts.admin')

@section('title', 'View User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">User Details</h1>
            <p class="text-muted mb-0">View user information and permissions</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Information Card -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center">
                    <div class="avatar-circle-large mx-auto mb-3">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    @if($user->email_verified_at)
                        <span class="badge bg-success mb-3">
                            <i class="fas fa-check-circle me-1"></i>Email Verified
                        </span>
                    @else
                        <span class="badge bg-warning mb-3">
                            <i class="fas fa-exclamation-circle me-1"></i>Email Not Verified
                        </span>
                    @endif

                    <hr>

                    <div class="text-start">
                        <p class="mb-2"><strong>User ID:</strong> #{{ $user->id }}</p>
                        <p class="mb-2"><strong>Joined:</strong> {{ $user->created_at->format('M d, Y g:i A') }}</p>
                        <p class="mb-0"><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles and Permissions -->
        <div class="col-lg-8">
            <!-- Assigned Roles -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-tag me-2"></i>Assigned Roles
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->roles->count() > 0)
                        <div class="row">
                            @foreach($user->roles as $role)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 h-100">
                                        <h6 class="text-primary mb-2">
                                            <i class="fas fa-shield-alt me-2"></i>{{ $role->name }}
                                        </h6>
                                        @if($role->description)
                                            <p class="text-muted small mb-0">{{ $role->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No roles assigned</p>
                    @endif
                </div>
            </div>

            <!-- Permissions -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-key me-2"></i>All Permissions
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $allPermissions = $user->roles->flatMap->permissions->unique('id');
                        $groupedPermissions = $allPermissions->groupBy('module');
                    @endphp

                    @if($allPermissions->count() > 0)
                        <div class="row">
                            @foreach($groupedPermissions as $module => $permissions)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h6 class="text-success mb-3">
                                            <i class="fas fa-folder me-2"></i>{{ ucfirst($module) }} Module
                                        </h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($permissions as $permission)
                                                <span class="badge bg-light text-dark border">
                                                    <i class="fas fa-check text-success me-1"></i>{{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Total Permissions:</strong> {{ $allPermissions->count() }} permissions across {{ $groupedPermissions->count() }} modules
                        </div>
                    @else
                        <p class="text-muted mb-0">No permissions assigned (no roles)</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 48px;
}
</style>
@endsection
