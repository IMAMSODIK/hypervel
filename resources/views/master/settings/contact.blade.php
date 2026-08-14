@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.settings.contact') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Contact Info</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contact Information</h5>
                        <p class="small text-secondary mb-0 mt-1">These details appear on the top bar and footer of the landing page.</p>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('master.settings.contact.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Phone (Primary)</label>
                                    <input type="text" name="contact_phone" class="form-control"
                                        value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                                        placeholder="+62 21 1234 5678">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone (Secondary)</label>
                                    <input type="text" name="contact_phone2" class="form-control"
                                        value="{{ old('contact_phone2', $settings['contact_phone2'] ?? '') }}"
                                        placeholder="+62 811 1234 5678">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="contact_email" class="form-control"
                                        value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                        placeholder="info@company.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Operating Hours</label>
                                    <input type="text" name="contact_hours" class="form-control"
                                        value="{{ old('contact_hours', $settings['contact_hours'] ?? '') }}"
                                        placeholder="Mon–Fri, 8:30am – 6:00pm">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <textarea name="contact_address" class="form-control" rows="2"
                                        placeholder="No. 102, Jl Biduk Petisah Tengah, Medan">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h6 class="text-secondary mb-3"><i class="bi bi-map me-1"></i> Google Maps Embed</h6>
                            <div class="mb-3">
                                <label class="form-label">Map Embed Code (iframe)</label>
                                <textarea name="contact_map_embed" class="form-control" rows="4"
                                    placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." ...></iframe>'>{{ old('contact_map_embed', $settings['contact_map_embed'] ?? '') }}</textarea>
                                <div class="small text-secondary mt-1">
                                    Go to <a href="https://www.google.com/maps" target="_blank">Google Maps</a>, search your address, click <strong>Share &rsaquo; Embed a map &rsaquo; Copy HTML</strong>, then paste the <code>&lt;iframe&gt;...</code&gt;</code> here. Shown in the landing page footer.
                                </div>
                            </div>

                            <hr class="my-4">
                            <h6 class="text-secondary mb-3">Social Media Links</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-facebook me-1"></i> Facebook URL</label>
                                    <input type="url" name="contact_facebook" class="form-control"
                                        value="{{ old('contact_facebook', $settings['contact_facebook'] ?? '') }}"
                                        placeholder="https://facebook.com/company">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-linkedin me-1"></i> LinkedIn URL</label>
                                    <input type="url" name="contact_linkedin" class="form-control"
                                        value="{{ old('contact_linkedin', $settings['contact_linkedin'] ?? '') }}"
                                        placeholder="https://linkedin.com/company">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-instagram me-1"></i> Instagram URL</label>
                                    <input type="url" name="contact_instagram" class="form-control"
                                        value="{{ old('contact_instagram', $settings['contact_instagram'] ?? '') }}"
                                        placeholder="https://instagram.com/company">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-youtube me-1"></i> YouTube URL</label>
                                    <input type="url" name="contact_youtube" class="form-control"
                                        value="{{ old('contact_youtube', $settings['contact_youtube'] ?? '') }}"
                                        placeholder="https://youtube.com/@company">
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
                        <div class="mb-3 p-3 rounded text-white" style="background:#263C92;">
                            <div class="d-flex justify-content-between flex-wrap gap-2" style="font-size:0.8rem;">
                                <span><i class="bi bi-telephone me-1"></i>{{ $settings['contact_phone'] ?? '—' }}</span>
                                <span><i class="bi bi-envelope me-1"></i>{{ $settings['contact_email'] ?? '—' }}</span>
                                <span><i class="bi bi-clock me-1"></i>{{ $settings['contact_hours'] ?? '—' }}</span>
                            </div>
                        </div>
                        <p class="small text-secondary">This is how the top contact bar will appear on the landing page.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection