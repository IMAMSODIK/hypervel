@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.projects.index') }}" class="text-decoration-none">Projects</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">{{ $project->id ? 'Edit' : 'Create' }}</li>
        </ol>
    </div>

    <div class="app-body">
        @if (session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ $project->id ? route('master.projects.update', $project) : route('master.projects.store') }}" enctype="multipart/form-data" id="projectForm">
            @csrf
            @method($project->id ? 'PUT' : 'POST')

            <div class="row g-3">
                {{-- Main column --}}
                <div class="col-12 col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ $project->id ? 'Edit Project' : 'New Project' }}</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" id="titleInput"
                                    value="{{ old('title', $project->title) }}" placeholder="e.g. Valve Replacement at Plant X" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" id="slugInput"
                                    value="{{ old('slug', $project->slug) }}" placeholder="auto-generated from title">
                                <div class="small text-secondary mt-1">Leave blank to auto-generate. Used in URL: /projects/<code>slug</code></div>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Category</label>
                                    <input type="text" name="category" class="form-control"
                                        value="{{ old('category', $project->category) }}" placeholder="Maintenance">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Client</label>
                                    <input type="text" name="client" class="form-control"
                                        value="{{ old('client', $project->client) }}" placeholder="Company name">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Year</label>
                                    <input type="text" name="year" class="form-control"
                                        value="{{ old('year', $project->year) }}" placeholder="2025">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control"
                                        value="{{ old('location', $project->location) }}" placeholder="Malaysia">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="2"
                                    placeholder="Brief text shown on project cards.">{{ old('short_description', $project->short_description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Content (Rich Text)</label>
                                <textarea name="content" id="contentEditor" class="form-control" rows="20">{!! old('content', $project->content) !!}</textarea>
                            </div>

                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-search me-1"></i> SEO</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2"
                                    placeholder="Brief description for search engines.">{{ old('meta_description', $project->meta_description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control"
                                    value="{{ old('meta_keywords', $project->meta_keywords) }}" placeholder="project, valve, maintenance">
                            </div>
                        </div>
                    </div>

                    {{-- Gallery --}}
                    @if($project->id && $project->images->isNotEmpty())
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><i class="bi bi-images me-1"></i> Gallery</h5>
                            <span class="text-secondary small">{{ $project->images->count() }} image(s)</span>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                @foreach($project->images as $img)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="position-relative rounded overflow-hidden border" style="aspect-ratio:1/1;">
                                            <img src="{{ $img->image_url }}" alt="Gallery" class="w-100 h-100" style="object-fit:cover;">
                                            <form method="POST" action="{{ route('master.projects.images.destroy', [$project, $img]) }}" class="position-absolute top-0 end-0 m-1 del-img-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger py-0 px-1" title="Remove">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar column --}}
                <div class="col-12 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Publish</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                                    {{ old('is_active', $project->exists ? $project->is_active : true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Active (visible on site)</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured"
                                    {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isFeatured"><i class="bi bi-star-fill text-warning"></i> Featured (show on landing page)</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order', $project->sort_order) }}" min="0" placeholder="0">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-check-lg me-1"></i> Save
                                </button>
                                <a href="{{ route('master.projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Featured Image</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                @if($project->featured_image)
                                    <img src="{{ $project->featured_image_url }}" alt="Featured" class="rounded border w-100" style="max-height:160px;object-fit:cover;">
                                @else
                                    <div class="rounded border d-flex align-items-center justify-center text-secondary small" style="height:120px;">No image</div>
                                @endif
                            </div>
                            <input type="file" name="featured_image" class="form-control" accept="image/*">
                            @if($project->featured_image)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="clear_featured" value="1" id="clearFeat">
                                    <label class="form-check-label small" for="clearFeat">Remove featured image</label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Icon (fallback)</h5>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <span class="input-group-text"><i id="iconPreview" class="bi {{ old('icon', $project->icon) ?: 'bi-kanban' }}"></i></span>
                                <input type="text" name="icon" class="form-control" id="iconInput"
                                    value="{{ old('icon', $project->icon) }}" placeholder="bi-kanban">
                            </div>
                            <div class="small text-secondary mt-1">
                                Shown when no featured image. Browse at
                                <a href="https://icons.getbootstrap.com" target="_blank">bootstrap-icons</a>.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Gallery Upload</h5>
                        </div>
                        <div class="card-body">
                            <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                            <div class="small text-secondary mt-1">Select multiple images. Added to existing gallery.</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#contentEditor',
        height: 500,
        menubar: true,
        plugins: [
            'advlist','autolink','lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
            'code','fullscreen','insertdatetime','media','table','code','wordcount','pagebreak','help'
        ],
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | code fullscreen preview | pagebreak removeformat help',
        toolbar_mode: 'sliding',
        content_style: 'body{font-family:Inter,sans-serif;font-size:15px;line-height:1.6;color:#1e293b;}',
        branding: false,
        promotion: false,
        file_picker_types: 'image',
        relative_urls: false,
        automatic_uploads: false
    });

    var titleInput = document.getElementById('titleInput');
    var slugInput = document.getElementById('slugInput');
    var slugTouched = slugInput.value !== '';
    slugInput.addEventListener('input', function () { slugTouched = true; });
    titleInput.addEventListener('input', function () {
        if (!slugTouched) {
            slugInput.value = titleInput.value.toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            @if(!$project->id)
            slugTouched = false;
            @endif
        }
    });

    var iconInput = document.getElementById('iconInput');
    var iconPreview = document.getElementById('iconPreview');
    iconInput.addEventListener('input', function () {
        var cls = (iconInput.value || 'bi-kanban').trim();
        if (cls.indexOf('bi-') !== 0) cls = 'bi-' + cls;
        iconPreview.className = 'bi ' + cls;
    });

    document.querySelectorAll('.del-img-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Remove this image?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
            }).then(function (r) { if (r.isConfirmed) form.submit(); });
        });
    });
</script>
@endpush