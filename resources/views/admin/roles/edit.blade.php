@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Role</h1>
            <p class="text-muted mb-0">Update role information and permissions</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Roles
        </a>
    </div>

    <!-- Edit Role Form -->
    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-4">
                <!-- Role Basic Info -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Role Information</h5>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $role->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   id="slug"
                                   name="slug"
                                   value="{{ old('slug', $role->slug) }}"
                                   required>
                            <small class="text-muted">Lowercase letters, numbers, and hyphens only</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-0">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Role Stats -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Role Statistics</h6>
                        <hr>
                        <p class="mb-2"><strong>Users:</strong> {{ $role->users()->count() }}</p>
                        <p class="mb-2"><strong>Permissions:</strong> {{ $role->permissions->count() }}</p>
                        <p class="mb-0"><strong>Created:</strong> {{ $role->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-2"></i>Update Role
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-light w-100">Cancel</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Permissions -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-key me-2"></i>Assign Permissions
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($permissions->count() > 0)
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">
                                    <i class="fas fa-check-square me-1"></i>Select All
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                                    <i class="fas fa-square me-1"></i>Deselect All
                                </button>
                            </div>

                            @foreach($permissions as $module => $modulePermissions)
                                <div class="border rounded p-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 text-primary">
                                            <i class="fas fa-folder me-2"></i>{{ ucfirst($module) }} Module
                                        </h6>
                                        <div class="form-check">
                                            <input class="form-check-input module-checkbox"
                                                   type="checkbox"
                                                   id="module_{{ $module }}"
                                                   onchange="toggleModule('{{ $module }}', this.checked)">
                                            <label class="form-check-label small" for="module_{{ $module }}">
                                                Select All
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @foreach($modulePermissions as $permission)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox module-{{ $module }}"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $permission->id }}"
                                                           id="permission{{ $permission->id }}"
                                                           {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                        @if($permission->description)
                                                            <br><small class="text-muted">{{ $permission->description }}</small>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">No permissions available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Select all permissions
function selectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
    document.querySelectorAll('.module-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
}

// Deselect all permissions
function deselectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.querySelectorAll('.module-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
}

// Toggle all permissions in a module
function toggleModule(module, checked) {
    document.querySelectorAll(`.module-${module}`).forEach(checkbox => {
        checkbox.checked = checked;
    });
}

// Update module checkboxes on page load
document.addEventListener('DOMContentLoaded', function() {
    @foreach($permissions as $module => $modulePermissions)
        const moduleCheckboxes = document.querySelectorAll('.module-{{ $module }}');
        const moduleCheckbox = document.getElementById('module_{{ $module }}');
        const allChecked = Array.from(moduleCheckboxes).every(cb => cb.checked);
        if (allChecked && moduleCheckboxes.length > 0) {
            moduleCheckbox.checked = true;
        }
    @endforeach
});
</script>
@endsection
