@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.projects.index') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Projects</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Projects</h4>
            <a href="{{ route('master.projects.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add Project
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                @if ($projects->isEmpty())
                    <div class="alert alert-info mb-0">No projects yet. Click "Add Project" to create one.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width:80px">Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Year</th>
                                    <th style="width:70px">Featured</th>
                                    <th style="width:70px">Order</th>
                                    <th style="width:70px">Active</th>
                                    <th class="text-end" style="width:130px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>
                                            @if($project->featured_image)
                                                <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" class="rounded" style="width:60px;height:60px;object-fit:cover;">
                                            @elseif($project->icon)
                                                <div class="d-flex align-items-center justify-content-center rounded bg-primary text-white" style="width:60px;height:60px;">
                                                    <i class="bi {{ $project->icon }} fs-5"></i>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center justify-content-center rounded bg-light text-secondary" style="width:60px;height:60px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('master.projects.edit', $project) }}" class="text-decoration-none fw-semibold text-primary">{{ $project->title }}</a>
                                            <div class="small text-secondary">{{ $project->short_description }}</div>
                                        </td>
                                        <td>{{ $project->category ?: '&mdash;' }}</td>
                                        <td>{{ $project->year ?: '&mdash;' }}</td>
                                        <td>
                                            @if($project->is_featured)
                                                <span class="badge bg-gold text-primary"><i class="bi bi-star-fill"></i></span>
                                            @else
                                                <span class="text-secondary">&mdash;</span>
                                            @endif
                                        </td>
                                        <td>{{ $project->sort_order }}</td>
                                        <td>
                                            @if($project->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Hidden</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('master.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('master.projects.destroy', $project) }}" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Delete this project?',
                text: 'This will also remove all gallery images. This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>
@endpush