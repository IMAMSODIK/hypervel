@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.products.index') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Products</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Products</h4>
            <a href="{{ route('master.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add Product
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                @if ($products->isEmpty())
                    <div class="alert alert-info mb-0">No products yet. Click "Add Product" to create one.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width:80px">Image</th>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th style="width:60px">Order</th>
                                    <th style="width:80px">Active</th>
                                    <th class="text-end" style="width:120px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            @if($product->featured_image)
                                                <img src="{{ $product->featured_image_url }}" alt="{{ $product->title }}" class="rounded" style="width:60px;height:60px;object-fit:cover;">
                                            @elseif($product->icon)
                                                <div class="d-flex align-items-center justify-content-center rounded bg-primary text-white" style="width:60px;height:60px;">
                                                    <i class="bi {{ $product->icon }} fs-5"></i>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center justify-content-center rounded bg-light text-secondary" style="width:60px;height:60px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('master.products.edit', $product) }}" class="text-decoration-none fw-semibold text-primary">{{ $product->title }}</a>
                                            <div class="small text-secondary">{{ $product->short_description }}</div>
                                        </td>
                                        <td><code>{{ $product->slug }}</code></td>
                                        <td>{{ $product->sort_order }}</td>
                                        <td>
                                            @if($product->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Hidden</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('master.products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('products.show', $product) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('master.products.destroy', $product) }}" class="d-inline delete-form">
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
                title: 'Delete this product?',
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