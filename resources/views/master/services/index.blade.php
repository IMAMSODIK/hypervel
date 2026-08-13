@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.services.index') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Capabilities / Services</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row g-3">
            {{-- Add / Edit form --}}
            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0" id="formTitle">Add Capability</h5>
                        <p class="small text-secondary mb-0 mt-1">Shown in the slider on the landing page.</p>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('master.services.store') }}" enctype="multipart/form-data" id="serviceForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title') }}" placeholder="e.g. After-Sales Service" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4"
                                    placeholder="Short description visible on the slider card.">{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Icon (Bootstrap Icon)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i id="iconPreview" class="bi bi-tools"></i></span>
                                    <input type="text" name="icon" class="form-control"
                                        value="{{ old('icon') }}" placeholder="bi-tools" id="iconInput">
                                </div>
                                <div class="small text-secondary mt-1">
                                    Optional. Browse at
                                    <a href="https://icons.getbootstrap.com" target="_blank">bootstrap-icons</a>.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image (optional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*" id="imageInput">
                                <div class="small text-secondary mt-1">Landscape works best. Max 2MB (jpg/png/webp).</div>
                                <img id="imagePreview" class="rounded border mt-2 d-none" style="width:100%;max-height:140px;object-fit:cover;">
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActiveInput" checked>
                                    <label class="form-check-label" for="isActiveInput">Active (show on landing page)</label>
                                </div>
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
                        <h5 class="card-title mb-0">Capabilities List</h5>
                        <span class="text-secondary small">{{ $services->count() }} item(s)</span>
                    </div>
                    <div class="card-body">
                        @if ($services->isEmpty())
                            <div class="alert alert-info mb-0">No capabilities yet. Add one to show on the landing page.</div>
                        @else
                            <div class="row g-3">
                                @foreach ($services as $service)
                                    <div class="col-12 col-md-6">
                                        <div class="card h-100 shadow-sm border">
                                            <div class="position-relative">
                                                @if($service->image)
                                                    <img src="{{ $service->image_url }}" class="card-img-top" style="height:140px;object-fit:cover;" alt="{{ $service->title }}">
                                                    <span class="position-absolute top-0 end-0 badge bg-primary rounded-start-0 rounded-top-0">#{{ $service->sort_order }}</span>
                                                @else
                                                    <div class="card-img-top d-flex align-items-center justify-content-center" style="height:140px;background:linear-gradient(135deg,#263C92,#1d2d6e);">
                                                        @if($service->icon)
                                                            <i class="bi {{ $service->icon }} text-white" style="font-size:2.5rem;"></i>
                                                        @else
                                                            <i class="bi bi-grid text-white/50" style="font-size:2.5rem;"></i>
                                                        @endif
                                                        <span class="position-absolute top-0 end-0 badge bg-primary rounded-start-0 rounded-top-0">#{{ $service->sort_order }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    @if($service->icon && !$service->image)
                                                        <i class="bi {{ $service->icon }} text-primary"></i>
                                                    @endif
                                                    <h6 class="card-title mb-0">{{ $service->title }}</h6>
                                                </div>
                                                <p class="card-text small text-secondary" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $service->description }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <form method="POST" action="{{ route('master.services.update', $service) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="title" value="{{ $service->title }}">
                                                        <input type="hidden" name="description" value="{{ $service->description }}">
                                                        <input type="hidden" name="icon" value="{{ $service->icon }}">
                                                        <input type="hidden" name="sort_order" value="{{ $service->sort_order }}">
                                                        <input type="hidden" name="is_active" value="0">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_active" value="1"
                                                                {{ $service->is_active ? 'checked' : '' }}
                                                                onchange="this.form.submit()">
                                                        </div>
                                                    </form>
                                                    <div class="d-flex gap-1">
                                                        <button class="btn btn-sm btn-outline-primary edit-btn"
                                                            data-id="{{ $service->id }}"
                                                            data-title="{{ $service->title }}"
                                                            data-description="{{ $service->description }}"
                                                            data-icon="{{ $service->icon ?? '' }}"
                                                            data-image="{{ $service->image ? $service->image_url : '' }}"
                                                            data-sort="{{ $service->sort_order }}"
                                                            data-active="{{ $service->is_active ? 1 : 0 }}">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <form method="POST" action="{{ route('master.services.destroy', $service) }}" class="d-inline delete-form">
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
                title: 'Delete this capability?',
                text: 'This action cannot be undone.',
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

    var iconInput = document.getElementById('iconInput');
    var iconPreview = document.getElementById('iconPreview');
    iconInput.addEventListener('input', function () {
        var cls = (iconInput.value || 'bi-tools').trim();
        if (cls.indexOf('bi-') !== 0) cls = 'bi-' + cls;
        iconPreview.className = 'bi ' + cls;
    });

    var imageInput = document.getElementById('imageInput');
    var imagePreview = document.getElementById('imagePreview');
    imageInput.addEventListener('change', function () {
        if (imageInput.files && imageInput.files[0]) {
            imagePreview.classList.remove('d-none');
            imagePreview.src = URL.createObjectURL(imageInput.files[0]);
        }
    });

    var form = document.getElementById('serviceForm');
    var formTitle = document.getElementById('formTitle');
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
        form.action = "{{ route('master.services.store') }}";
        ensureMethod(null);
        formTitle.textContent = 'Add Capability';
        submitLabel.textContent = 'Add';
        submitBtn.querySelector('i').className = 'bi bi-plus-lg me-1';
        form.querySelectorAll('input[name], textarea[name]').forEach(function (el) {
            if (el.name !== '_token' && el.type !== 'file') el.value = '';
        });
        imageInput.value = '';
        imagePreview.classList.add('d-none');
        imagePreview.src = '';
        document.getElementById('isActiveInput').checked = true;
        iconInput.dispatchEvent(new Event('input'));
        cancelBtn.classList.add('d-none');
    }

    document.querySelectorAll('.edit-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.dataset.id;
            form.action = "{{ route('master.services.update', '__ID__') }}".replace('__ID__', id);
            ensureMethod('PUT');

            form.querySelector('[name="title"]').value = btn.dataset.title;
            form.querySelector('[name="description"]').value = btn.dataset.description;
            form.querySelector('[name="icon"]').value = btn.dataset.icon;
            iconInput.dispatchEvent(new Event('input'));
            document.getElementById('isActiveInput').checked = btn.dataset.active === '1';

            formTitle.textContent = 'Edit Capability';
            submitLabel.textContent = 'Save';
            submitBtn.querySelector('i').className = 'bi bi-check-lg me-1';
            imageInput.value = '';
            var img = btn.dataset.image || '';
            imagePreview.classList.toggle('d-none', !img);
            if (img) imagePreview.src = img;

            cancelBtn.classList.remove('d-none');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    cancelBtn.addEventListener('click', function () { resetForm(); });
</script>
@endpush