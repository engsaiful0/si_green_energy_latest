@extends('layouts.admin')

@section('title', 'SEO Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">SEO Management</h1>
            <p class="text-muted mb-0">Banner, title and meta description of every CMS page. Individual posts, projects, services, solutions, products and team members have their own SEO fields.</p>
        </div>
        <a href="{{ route('admin.settings.general') }}" class="btn btn-outline-secondary">
            <i class="fas fa-cog me-2"></i>Site-wide Defaults
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Page</th>
                            <th>SEO Title</th>
                            <th>Meta Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                            @php $pageSection = \App\Models\PageSection::forPage($page['key'])->where('section_key', 'page')->first(); @endphp
                            <tr>
                                <td>
                                    <strong>{{ $page['label'] }}</strong>
                                    <div class="small"><a href="{{ route($page['route']) }}" target="_blank">{{ route($page['route']) }}</a></div>
                                </td>
                                <td class="small">
                                    {{ $page['settings']['meta_title'] ?: ($page['settings']['title'] ?? '') }}
                                    @if(!$page['settings']['meta_title'])<span class="text-muted">(page title)</span>@endif
                                </td>
                                <td class="small">
                                    @if($page['settings']['meta_description'])
                                        {{ \Illuminate\Support\Str::limit($page['settings']['meta_description'], 90) }}
                                    @else
                                        <span class="badge bg-warning text-dark">Missing</span>
                                    @endif
                                </td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('admin.content.edit', [$page['key'], $pageSection]) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-search me-1"></i>Edit SEO
                                    </a>
                                    <a href="{{ route('admin.content.index', $page['key']) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-th-large me-1"></i>Sections
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
