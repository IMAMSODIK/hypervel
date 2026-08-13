@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Inquiries</li>
        </ol>
    </div>

    <div class="app-body">
        @if (session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
                <div class="card text-center">
                    <div class="card-body py-3">
                        <h2 class="mb-0 text-primary">{{ $inquiries->count() }}</h2>
                        <p class="text-secondary small mb-0">Total</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center">
                    <div class="card-body py-3">
                        <h2 class="mb-0 text-warning">{{ $inquiries->where('is_read', false)->count() }}</h2>
                        <p class="text-secondary small mb-0">Unread</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center">
                    <div class="card-body py-3">
                        <h2 class="mb-0 text-success">{{ $inquiries->where('is_read', true)->count() }}</h2>
                        <p class="text-secondary small mb-0">Read</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center">
                    <div class="card-body py-3">
                        <h2 class="mb-0 text-info">{{ $inquiries->where('created_at', '>=', now()->subDays(7))->count() }}</h2>
                        <p class="text-secondary small mb-0">This Week</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-chat-left-text me-1"></i> Inquiries</h5>
                <span class="text-secondary small">{{ $inquiries->count() }} message(s)</span>
            </div>
            <div class="card-body">
                @if ($inquiries->isEmpty())
                    <div class="alert alert-info mb-0">No inquiries yet.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="inquiriesTable">
                            <thead>
                                <tr>
                                    <th style="width:50px"></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Message</th>
                                    <th style="width:140px">Date</th>
                                    <th class="text-end" style="width:100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquiries as $inquiry)
                                    <tr class="{{ $inquiry->is_read ? '' : 'fw-semibold' }}">
                                        <td>
                                            @if(!$inquiry->is_read)
                                                <span class="badge rounded-pill bg-warning" title="Unread"><i class="bi bi-circle-fill" style="font-size:0.5rem;"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('master.inquiries.show', $inquiry) }}" class="text-decoration-none text-primary">{{ $inquiry->name }}</a>
                                            @if($inquiry->phone)
                                                <div class="small text-secondary"><i class="bi bi-telephone"></i> {{ $inquiry->phone }}</div>
                                            @endif
                                        </td>
                                        <td><a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">{{ $inquiry->email }}</a></td>
                                        <td>{{ $inquiry->company ?: '&mdash;' }}</td>
                                        <td class="text-secondary" style="max-width:300px;">
                                            <span class="d-inline-block text-truncate" style="max-width:280px;">{{ $inquiry->message }}</span>
                                        </td>
                                        <td class="text-secondary small">{{ $inquiry->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('master.inquiries.show', $inquiry) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('master.inquiries.destroy', $inquiry) }}" class="d-inline delete-form">
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
                title: 'Delete this inquiry?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
            }).then(function (r) { if (r.isConfirmed) form.submit(); });
        });
    });
    $('#inquiriesTable').DataTable({
        order: [[5, 'desc']],
        pageLength: 10,
        language: { search: 'Search:', lengthMenu: 'Show _MENU_', info: 'Showing _START_ - _END_ of _TOTAL_' }
    });
</script>
@endpush