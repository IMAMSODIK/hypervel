@extends('layouts.template')

@section('content')
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('master.statistics.index') }}" class="text-decoration-none">Landing Page</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Statistics</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row g-3">
            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add Statistic</h5>
                        <p class="small text-secondary mb-0 mt-1">Shown below the hero section on the landing page.</p>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('master.statistics.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Label</label>
                                <input type="text" name="label" class="form-control"
                                    value="{{ old('label') }}" placeholder="Years Experience" required>
                            </div>

                            <div class="row g-2">
                                <div class="col-7">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="value" class="form-control"
                                        value="{{ old('value') }}" placeholder="27" required>
                                </div>
                                <div class="col-5">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="suffix" class="form-control"
                                        value="{{ old('suffix') }}" placeholder="+" maxlength="10">
                                </div>
                            </div>
                            <div class="small text-secondary mt-1">Suffix appears right after the value (e.g. <code>+</code>, <code>%</code>).</div>

                            <div class="mb-3 mt-2">
                                <label class="form-label">Icon (Bootstrap Icon)</label>
                                <input type="text" name="icon" class="form-control"
                                    value="{{ old('icon') }}" placeholder="bi-clock-history">
                                <div class="small text-secondary mt-1">
                                    Optional. Browse icons at
                                    <a href="https://icons.getbootstrap.com" target="_blank">bootstrap-icons</a>.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order') }}" min="0" placeholder="0">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i> Add
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Statistic List</h5>
                        <span class="text-secondary small">{{ $stats->count() }} item(s)</span>
                    </div>
                    <div class="card-body">
                        @if ($stats->isEmpty())
                            <div class="alert alert-info mb-0">No statistics yet. Add one to show on the landing page.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width:50px">Order</th>
                                            <th style="width:40px">Icon</th>
                                            <th>Value</th>
                                            <th>Label</th>
                                            <th style="width:80px">Active</th>
                                            <th class="text-end" style="width:80px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stats as $stat)
                                            <tr>
                                                <td>
                                                    <form method="POST" action="{{ route('master.statistics.update', $stat) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="label" value="{{ $stat->label }}">
                                                        <input type="hidden" name="value" value="{{ $stat->value }}">
                                                        <input type="hidden" name="suffix" value="{{ $stat->suffix }}">
                                                        <input type="hidden" name="icon" value="{{ $stat->icon }}">
                                                        <input type="number" name="sort_order"
                                                            value="{{ old('sort_order', $stat->sort_order) }}"
                                                            class="form-control form-control-sm" style="width:60px"
                                                            onchange="this.form.submit()">
                                                    </form>
                                                </td>
                                                <td>
                                                    @if($stat->icon)<i class="bi {{ $stat->icon }} text-primary fs-5"></i>@else &mdash;@endif
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('master.statistics.update', $stat) }}" class="d-flex gap-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="label" value="{{ $stat->label }}">
                                                        <input type="hidden" name="icon" value="{{ $stat->icon }}">
                                                        <input type="hidden" name="sort_order" value="{{ $stat->sort_order }}">
                                                        <input type="text" name="value" value="{{ $stat->value }}"
                                                            class="form-control form-control-sm" style="width:80px">
                                                        <input type="text" name="suffix" value="{{ $stat->suffix }}"
                                                            class="form-control form-control-sm" style="width:50px"
                                                            maxlength="10">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Save value">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('master.statistics.update', $stat) }}" class="d-flex gap-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="value" value="{{ $stat->value }}">
                                                        <input type="hidden" name="suffix" value="{{ $stat->suffix }}">
                                                        <input type="hidden" name="icon" value="{{ $stat->icon }}">
                                                        <input type="hidden" name="sort_order" value="{{ $stat->sort_order }}">
                                                        <input type="text" name="label" value="{{ $stat->label }}"
                                                            class="form-control form-control-sm" style="max-width:180px">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Save label">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('master.statistics.update', $stat) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="label" value="{{ $stat->label }}">
                                                        <input type="hidden" name="value" value="{{ $stat->value }}">
                                                        <input type="hidden" name="suffix" value="{{ $stat->suffix }}">
                                                        <input type="hidden" name="icon" value="{{ $stat->icon }}">
                                                        <input type="hidden" name="sort_order" value="{{ $stat->sort_order }}">
                                                        <input type="hidden" name="is_active" value="0">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_active" value="1"
                                                                {{ $stat->is_active ? 'checked' : '' }}
                                                                onchange="this.form.submit()">
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-end">
                                                    <form method="POST" action="{{ route('master.statistics.destroy', $stat) }}" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
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
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Delete this statistic?',
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
</script>
@endpush