@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.inquiries.index') }}" class="text-decoration-none">Inquiries</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Detail</li>
        </ol>
    </div>

    <div class="app-body">
        @if (session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="bi bi-envelope-open me-1"></i> Inquiry from {{ $inquiry->name }}</h5>
                        <span class="badge {{ $inquiry->is_read ? 'bg-success' : 'bg-warning' }}">{{ $inquiry->is_read ? 'Read' : 'Unread' }}</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="text-secondary small text-uppercase mb-2">Message</div>
                            <div class="p-4 bg-light rounded border">{!! nl2br(e($inquiry->message)) !!}</div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="mailto:{{ $inquiry->email }}?subject=Re: Your inquiry to {{ config('app.name') }}" class="btn btn-primary">
                                <i class="bi bi-reply me-1"></i> Reply via Email
                            </a>
                            @if(!$inquiry->is_read)
                                <form method="POST" action="{{ route('master.inquiries.read', $inquiry) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-secondary">
                                        <i class="bi bi-check2 me-1"></i> Mark as Read
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('master.inquiries.index') }}" class="btn btn-outline-secondary ms-auto">Back</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contact Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-secondary" style="width:90px;"><i class="bi bi-person me-2"></i>Name</td>
                                <td class="fw-semibold">{{ $inquiry->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary"><i class="bi bi-envelope me-2"></i>Email</td>
                                <td><a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">{{ $inquiry->email }}</a></td>
                            </tr>
                            @if($inquiry->phone)
                            <tr>
                                <td class="text-secondary"><i class="bi bi-telephone me-2"></i>Phone</td>
                                <td><a href="tel:{{ $inquiry->phone }}" class="text-decoration-none">{{ $inquiry->phone }}</a></td>
                            </tr>
                            @endif
                            @if($inquiry->company)
                            <tr>
                                <td class="text-secondary"><i class="bi bi-building me-2"></i>Company</td>
                                <td>{{ $inquiry->company }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-secondary"><i class="bi bi-clock me-2"></i>Received</td>
                                <td class="small">{{ $inquiry->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>

                        <hr>

                        <form method="POST" action="{{ route('master.inquiries.destroy', $inquiry) }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-1"></i> Delete Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelector('.delete-form')?.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Delete this inquiry?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
        }).then(function (r) { if (r.isConfirmed) e.target.submit(); });
    });
</script>
@endpush