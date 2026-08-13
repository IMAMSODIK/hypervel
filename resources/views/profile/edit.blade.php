@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Profile</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profil Pengguna</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row align-items-center g-4">
                                <div class="col-md-4 text-center">
                                    <img id="avatarPreview" src="{{ $user->avatar_url }}" alt="Avatar {{ $user->name }}"
                                        class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                                    <div class="mt-3">
                                        <label for="avatar" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-camera me-1"></i> Ganti Foto
                                        </label>
                                        <input type="file" id="avatar" name="avatar" class="d-none"
                                            accept=".jpg,.jpeg,.png,.webp">
                                        <div class="small text-secondary mt-2">Maksimal 2 MB.</div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control text-capitalize" value="{{ $user->role }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('avatar')?.addEventListener('change', function (event) {
        const file = event.target.files?.[0];
        if (file) document.getElementById('avatarPreview').src = URL.createObjectURL(file);
    });
</script>
@endpush
