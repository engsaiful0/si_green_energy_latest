@extends('layouts.admin')

@section('title', 'Create Role')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create New Role</h1>
            <p class="text-muted mb-0">Add a new role with specific permissions</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Roles
        </a>
    </div>

    <!-- Create Role Form -->
    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

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
                                   value="{{ old('name') }}"
                                   placeholder="e.g., Content Manager"
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
                                   value="{{ old('slug') }}"
                                   placeholder="e.g., content-manager"
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
                                      rows="3"
                                      placeholder="Brief description of this role">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-2"></i>Create Role
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
                        @error('permissions')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

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
                                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
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
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('slug').value = slug;
});

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
</script>
@endsection
