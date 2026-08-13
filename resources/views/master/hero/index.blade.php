@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.hero.index') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Hero Section</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row g-3">
            <div class="col-12 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Hero Section</h5>
                        <p class="small text-secondary mb-0 mt-1">The hero is the first section visitors see on the landing page. Set the text and background video here.</p>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('master.hero.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Hero Title</label>
                                <input type="text" name="hero_title" class="form-control"
                                    value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                                    placeholder="Delivering Excellence in Valve & Actuator Solutions">
                                <div class="small text-secondary mt-1">Main headline text shown over the video.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hero Subtitle</label>
                                <textarea name="hero_subtitle" class="form-control" rows="2"
                                    placeholder="Your trusted partner for industrial valve distribution and after-sales service.">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                                <div class="small text-secondary mt-1">Supporting paragraph below the title.</div>
                            </div>

                            <hr class="my-4">
                            <h6 class="text-secondary mb-3">Background Video</h6>
                            <p class="small text-secondary mb-2">
                                Provide a direct URL <strong>or</strong> upload a local file. For smooth playback:
                                keep videos short (~5–8s), compressed (720p, H.264, &lt;5&nbsp;MB).
                            </p>

                            <div class="mb-3">
                                <label class="form-label">Video URL</label>
                                <input type="url" name="hero_video_url" class="form-control"
                                    value="{{ old('hero_video_url', ($settings['hero_video'] ?? '') && str_starts_with($settings['hero_video'] ?? '', 'http') ? $settings['hero_video'] : '') }}"
                                    placeholder="https://example.com/hero.mp4">
                                <div class="small text-secondary mt-1">Direct link to an MP4 file (CDN recommended).</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Video File</label>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <label class="btn btn-outline-primary btn-sm mb-0">
                                        <i class="bi bi-upload me-1"></i> Choose File
                                        <input type="file" name="hero_video_file" class="d-none"
                                            accept="video/mp4,video/webm" id="heroVideoFile">
                                    </label>
                                    <span class="small text-secondary" id="fileName">No file chosen</span>
                                </div>
                                <div class="small text-secondary mt-1">MP4 or WebM — max 50 MB.</div>
                                @if(($settings['hero_video'] ?? '') && !str_starts_with($settings['hero_video'], 'http'))
                                    <div class="small text-success mt-2"><i class="bi bi-check-circle"></i> Current file: {{ basename($settings['hero_video']) }}</div>
                                @endif
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="clear_hero_video" value="1" id="clearHeroVideo">
                                <label class="form-check-label small" for="clearHeroVideo">Remove current video (use gradient fallback)</label>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Live Preview</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="position-relative w-100 overflow-hidden rounded-top" style="aspect-ratio:16/9;">
                            @if($settings['hero_video'] ?? '')
                                <video class="w-100 h-100 object-cover" autoplay muted loop playsinline preload="metadata">
                                    <source src="{{ $settings['hero_video'] }}" type="video/mp4">
                                </video>
                            @else
                                <div class="w-100 h-100" style="background:linear-gradient(135deg,#263C92,#3a54b0,#1d2d6e);"></div>
                            @endif
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background:rgba(0,0,0,0.45);">
                                <div class="p-3 text-white">
                                    <span class="badge bg-warning text-dark mb-2">Industrial Valve & Actuator</span>
                                    <h5 class="fw-bold mb-1">{{ $settings['hero_title'] ?: 'Delivering Excellence in Valve & Actuator Solutions' }}</h5>
                                    <p class="small mb-0 opacity-75">{{ $settings['hero_subtitle'] ?: 'Your trusted partner...' }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="small text-secondary p-3 mb-0">This is how the hero will appear on the landing page (full screen on desktop, responsive on mobile).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('heroVideoFile')?.addEventListener('change', function (event) {
        const file = event.target.files?.[0];
        document.getElementById('fileName').textContent = file ? file.name : 'No file chosen';
    });
</script>
@endpush