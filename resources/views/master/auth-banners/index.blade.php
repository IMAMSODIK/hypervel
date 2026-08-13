@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.auth.banner') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Login Banners</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row g-3">
            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add Banner</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('master.auth.banner.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Title (optional)</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ old('title') }}" maxlength="255"
                                    placeholder="e.g. Industrial Valve Solutions">
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Banner Image</label>
                                <input type="file" id="image" name="image" class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp" required>
                                <div class="small text-secondary mt-1">JPG, JPEG, PNG, WEBP — max 2 MB. Recommended landscape ratio.</div>
                            </div>

                            <div class="mb-3 text-center">
                                <img id="preview" src="{{ asset('auth_assets/logo/logo.png') }}" alt="Preview"
                                    class="img-fluid rounded border" style="max-height: 200px; object-fit: cover;">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload me-1"></i> Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Banner List</h5>
                        <span class="text-secondary small">{{ $banners->count() }} banner(s)</span>
                    </div>
                    <div class="card-body">
                        @if ($banners->isEmpty())
                            <div class="alert alert-info mb-0">No banners yet. Upload one to show on login pages.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width:70px">Order</th>
                                            <th style="width:120px">Preview</th>
                                            <th>Title</th>
                                            <th style="width:90px">Active</th>
                                            <th class="text-end" style="width:100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banners as $banner)
                                            <tr>
                                                <td>
                                                    <form method="POST" action="{{ route('master.auth.banner.update', $banner) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="number" name="sort_order"
                                                            value="{{ old('sort_order', $banner->sort_order) }}"
                                                            class="form-control form-control-sm" style="width:70px"
                                                            onchange="this.form.submit()">
                                                    </form>
                                                </td>
                                                <td>
                                                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                                                        class="rounded border" style="width:100px; height:56px; object-fit:cover;">
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('master.auth.banner.update', $banner) }}" class="d-flex gap-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="text" name="title" value="{{ $banner->title }}"
                                                            class="form-control form-control-sm" maxlength="255"
                                                            style="max-width:240px">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Save title">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                    <div class="small text-secondary mt-1">{{ basename($banner->image) }}</div>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('master.auth.banner.update', $banner) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="is_active" value="0">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_active" value="1"
                                                                {{ $banner->is_active ? 'checked' : '' }}
                                                                onchange="this.form.submit()">
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-end">
                                                    <form method="POST" action="{{ route('master.auth.banner.destroy', $banner) }}" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete"
                                                            data-title="{{ $banner->title ?? basename($banner->image) }}">
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
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('image')?.addEventListener('change', function (event) {
        const file = event.target.files?.[0];
        if (file) document.getElementById('preview').src = URL.createObjectURL(file);
    });

    document.querySelectorAll('.delete-form').forEach(function (form) {
        const btn = form.querySelector('.btn-delete');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Delete this banner?',
                text: '"' + (btn.dataset.title || '') + '" will be removed.',
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