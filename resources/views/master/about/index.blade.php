@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.about.index') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">About Us</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">About Us Section</h5>
                        <p class="small text-secondary mb-0 mt-1">Shown on the landing page (brief) and the full About page.</p>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('master.about.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Section Title</label>
                                <input type="text" name="about_title" class="form-control"
                                    value="{{ old('about_title', $settings['about_title'] ?? '') }}"
                                    placeholder="Excellence in Engineering Solutions">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Brief Subtitle (shown on landing page)</label>
                                <textarea name="about_subtitle" class="form-control" rows="3"
                                    placeholder="Brief description visible on the landing page.">{{ old('about_subtitle', $settings['about_subtitle'] ?? '') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Description (shown on About page)</label>
                                <textarea name="about_description" class="form-control" rows="6"
                                    placeholder="Full company description — visitors click 'More About Us' to read this.">{{ old('about_description', $settings['about_description'] ?? '') }}</textarea>
                            </div>

                            <h6 class="text-secondary mb-2 mt-4">Key Points</h6>
                            <div id="bullets-container">
                                @foreach($bullets as $index => $bullet)
                                    <div class="input-group mb-2 bullet-row">
                                        <input type="text" name="about_bullets[{{ $index }}]" class="form-control"
                                            value="{{ $bullet }}" placeholder="e.g. Certified Quality">
                                        <button type="button" class="btn btn-outline-danger remove-bullet"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="addBullet">
                                <i class="bi bi-plus-lg me-1"></i> Add Point
                            </button>

                            <hr class="my-4">
                            <h6 class="text-secondary mb-3">Overlap Images (right side of About section)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Main Image</label>
                                    <div class="mb-2">
                                        @if($settings['about_image1'] ?? '')
                                            <img src="{{ $settings['about_image1'] }}" class="rounded border" style="width:100%;max-height:120px;object-fit:cover;">
                                        @else
                                            <div class="rounded border d-flex align-items-center justify-center text-secondary small" style="height:80px;">No image</div>
                                        @endif
                                    </div>
                                    <input type="file" name="about_image1" class="form-control" accept="image/*">
                                    @if($settings['about_image1'] ?? '')
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="clear_image1" value="1" id="clear1">
                                            <label class="form-check-label small" for="clear1">Remove this image</label>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Overlay Image (front)</label>
                                    <div class="mb-2">
                                        @if($settings['about_image2'] ?? '')
                                            <img src="{{ $settings['about_image2'] }}" class="rounded border" style="width:100%;max-height:120px;object-fit:cover;">
                                        @else
                                            <div class="rounded border d-flex align-items-center justify-center text-secondary small" style="height:80px;">No image</div>
                                        @endif
                                    </div>
                                    <input type="file" name="about_image2" class="form-control" accept="image/*">
                                    @if($settings['about_image2'] ?? '')
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="clear_image2" value="1" id="clear2">
                                            <label class="form-check-label small" for="clear2">Remove this image</label>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Preview</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold text-primary">{{ $settings['about_title'] ?: 'About Us Title' }}</h6>
                        <p class="small text-secondary">{{ $settings['about_subtitle'] ?: 'Brief subtitle...' }}</p>
                        @if(!empty($bullets))
                            <ul class="small ps-3">
                                @foreach($bullets as $b)
                                    <li>{{ $b }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="position-relative mt-3 overflow-hidden" style="height:130px;">
                            @if($settings['about_image1'] ?? '')
                                <div class="position-absolute rounded bg-gold" style="width:72%;height:82%;top:-6px;left:-6px;z-index:1;"></div>
                                <div class="position-absolute rounded overflow-hidden shadow z-10" style="width:72%;height:82%;top:0;left:0;">
                                    <img src="{{ $settings['about_image1'] }}" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                            @endif
                            @if($settings['about_image2'] ?? '')
                                <div class="position-absolute rounded overflow-hidden shadow-lg border border-2 border-white z-20" style="width:48%;height:64%;bottom:0;right:0;">
                                    <img src="{{ $settings['about_image2'] }}" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                            @endif
                        </div>
                        <p class="small text-secondary mt-2">Images overlap on the landing page.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('addBullet')?.addEventListener('click', function () {
        const container = document.getElementById('bullets-container');
        const count = container.querySelectorAll('.bullet-row').length;
        const div = document.createElement('div');
        div.className = 'input-group mb-2 bullet-row';
        div.innerHTML = '<input type="text" name="about_bullets[' + count + ']" class="form-control" placeholder="e.g. Certified Quality"><button type="button" class="btn btn-outline-danger remove-bullet"><i class="bi bi-x-lg"></i></button>';
        container.appendChild(div);
    });

    document.getElementById('bullets-container').addEventListener('click', function (e) {
        if (e.target.closest('.remove-bullet')) {
            e.target.closest('.bullet-row').remove();
        }
    });
</script>
@endpush