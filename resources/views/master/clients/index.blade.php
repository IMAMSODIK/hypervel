@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.clients.index') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Our Clients</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row g-3">
            {{-- Add form --}}
            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add Client</h5>
                        <p class="small text-secondary mb-0 mt-1">Logos shown on the landing page; name appears on hover.</p>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('master.clients.store') }}" enctype="multipart/form-data" id="clientForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" id="nameInput"
                                    value="{{ old('name') }}" placeholder="e.g. Petronas" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Logo</label>
                                <input type="file" name="logo" class="form-control" accept="image/*" id="logoInput">
                                <div class="small text-secondary mt-1">PNG with transparency works best. Max 1MB.</div>
                                <div class="mt-2 rounded border d-flex align-items-center justify-content-center bg-light" style="height:100px;" id="logoPreviewWrap">
                                    <span class="text-secondary small">No logo</span>
                                </div>
                                <img id="logoPreview" class="rounded border mt-2 d-none" style="width:100%;max-height:100px;object-fit:contain;background:#fff;padding:8px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Website (optional)</label>
                                <input type="text" name="website" class="form-control"
                                    value="{{ old('website') }}" placeholder="https://example.com">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order') }}" min="0" placeholder="0">
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary d-none" id="cancelEdit">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-plus-lg me-1"></i> <span id="submitLabel">Add</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- List --}}
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Client List</h5>
                        <span class="text-secondary small">{{ $clients->count() }} item(s)</span>
                    </div>
                    <div class="card-body">
                        @if ($clients->isEmpty())
                            <div class="alert alert-info mb-0">No clients yet. Add one to show on the landing page.</div>
                        @else
                            <div class="row g-3">
                                @foreach ($clients as $client)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="card h-100 shadow-sm border text-center">
                                            <div class="card-body d-flex flex-column align-items-center justify-content-center" style="min-height:120px;">
                                                @if($client->logo)
                                                    <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" style="max-height:60px;max-width:100%;object-fit:contain;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center rounded bg-primary text-white" style="width:48px;height:48px;">
                                                        <i class="bi bi-building fs-5"></i>
                                                    </div>
                                                @endif
                                                <div class="small fw-semibold mt-2 text-truncate w-100">{{ $client->name }}</div>
                                                <div class="badge {{ $client->is_active ? 'bg-success' : 'bg-secondary' }} mt-1">{{ $client->is_active ? 'Active' : 'Hidden' }}</div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center py-2">
                                                <span class="text-secondary small">#{{ $client->sort_order }}</span>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-sm btn-outline-primary edit-btn"
                                                        data-id="{{ $client->id }}"
                                                        data-name="{{ $client->name }}"
                                                        data-logo="{{ $client->logo ? $client->logo_url : '' }}"
                                                        data-website="{{ $client->website }}"
                                                        data-sort="{{ $client->sort_order }}"
                                                        data-active="{{ $client->is_active ? 1 : 0 }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('master.clients.destroy', $client) }}" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Delete this client?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
            }).then(function (r) { if (r.isConfirmed) form.submit(); });
        });
    });

    var logoInput = document.getElementById('logoInput');
    var logoPreview = document.getElementById('logoPreview');
    var logoPreviewWrap = document.getElementById('logoPreviewWrap');
    logoInput.addEventListener('change', function () {
        if (logoInput.files && logoInput.files[0]) {
            logoPreview.classList.remove('d-none');
            logoPreviewWrap.classList.add('d-none');
            logoPreview.src = URL.createObjectURL(logoInput.files[0]);
        }
    });

    var form = document.getElementById('clientForm');
    var formTitle = document.querySelector('.card-title');
    var submitLabel = document.getElementById('submitLabel');
    var submitBtn = document.getElementById('submitBtn');
    var cancelBtn = document.getElementById('cancelBtn');

    function ensureMethod(method) {
        var m = form.querySelector('input[name="_method"]');
        if (method === 'PUT') {
            if (!m) { m = document.createElement('input'); m.type = 'hidden'; m.name = '_method'; form.appendChild(m); }
            m.value = 'PUT';
        } else if (m) { m.remove(); }
    }

    function resetForm() {
        form.action = "{{ route('master.clients.store') }}";
        ensureMethod(null);
        formTitle.textContent = 'Add Client';
        submitLabel.textContent = 'Add';
        submitBtn.querySelector('i').className = 'bi bi-plus-lg me-1';
        form.querySelectorAll('input[name]:not([type=file])').forEach(function (el) { if (el.name !== '_token') el.value = ''; });
        logoInput.value = '';
        logoPreview.classList.add('d-none');
        logoPreviewWrap.classList.remove('d-none');
        cancelBtn.classList.add('d-none');
    }

    document.querySelectorAll('.edit-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.dataset.id;
            form.action = "{{ route('master.clients.update', '__ID__') }}".replace('__ID__', id);
            ensureMethod('PUT');

            document.getElementById('nameInput').value = btn.dataset.name;
            form.querySelector('[name="website"]').value = btn.dataset.website;
            form.querySelector('[name="sort_order"]').value = btn.dataset.sort;
            logoInput.value = '';
            var img = btn.dataset.logo || '';
            if (img) {
                logoPreview.classList.remove('d-none');
                logoPreviewWrap.classList.add('d-none');
                logoPreview.src = img;
            } else {
                logoPreview.classList.add('d-none');
                logoPreviewWrap.classList.remove('d-none');
            }

            formTitle.textContent = 'Edit Client';
            submitLabel.textContent = 'Save';
            submitBtn.querySelector('i').className = 'bi bi-check-lg me-1';
            cancelBtn.classList.remove('d-none');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    cancelBtn.addEventListener('click', function () { resetForm(); });
</script>
@endpush