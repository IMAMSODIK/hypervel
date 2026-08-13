@extends('layouts.template')

@section('content')
    <style>
        .dashboard-welcome {
            background: linear-gradient(135deg, #173b67 0%, #286a8f 100%);
            color: #fff;
        }

        .dashboard-stat .stat-icon {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.35rem;
        }

        .dashboard-stat .stat-value { font-size: 1.75rem; }
        .dashboard-progress { height: 8px; }
        .dashboard-table th { white-space: nowrap; }
    </style>

    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item text-secondary" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="card dashboard-welcome mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <p class="mb-1 opacity-75">{{ $isAdmin ? 'Dashboard Administrator' : 'Dashboard Operator' }}</p>
                    <h3 class="mb-2">Selamat datang, {{ $user->name }}</h3>
                    <p class="mb-0 opacity-75">
                        {{ $isAdmin ? 'Pantau ringkasan kinerja seluruh unit kerja.' : 'Pantau pengisian kinerja unit kerja Anda.' }}
                    </p>
                </div>
                <div class="text-md-end">
                    <small class="d-block opacity-75">Periode aktif</small>
                    <strong>
                        @if ($periodeAktif)
                            {{ $periodeAktif->tahun_awal }} - {{ $periodeAktif->tahun_akhir }}
                        @else
                            Belum ditentukan
                        @endif
                    </strong>
                </div>
            </div>
        </div>

        @if (!$isAdmin && !$unit)
            <div class="alert alert-warning">
                Unit kerja untuk akun operator ini belum ditentukan oleh administrator.
            </div>
        @endif

        <div class="row gx-3">
            @foreach ($stats as $stat)
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card dashboard-stat mb-3 h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <span class="stat-icon bg-{{ $stat['color'] }} bg-opacity-10 text-{{ $stat['color'] }}">
                                <i class="bi {{ $stat['icon'] }}"></i>
                            </span>
                            <div>
                                <p class="text-secondary mb-1">{{ $stat['label'] }}</p>
                                <h3 class="stat-value mb-0">{{ number_format($stat['value']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row gx-3">
            @foreach ($summary as $item)
                <div class="col-xl-6 col-12">
                    <div class="card mb-3 h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ $item['label'] }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Target terisi</span>
                                    <strong>{{ $item['target']['filled'] }}/{{ $item['target']['total'] }} ({{ $item['target']['percentage'] }}%)</strong>
                                </div>
                                <div class="progress dashboard-progress">
                                    <div class="progress-bar bg-primary" style="width: {{ $item['target']['percentage'] }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Realisasi terisi</span>
                                    <strong>{{ $item['realisasi']['filled'] }}/{{ $item['realisasi']['total'] }} ({{ $item['realisasi']['percentage'] }}%)</strong>
                                </div>
                                <div class="progress dashboard-progress">
                                    <div class="progress-bar bg-success" style="width: {{ $item['realisasi']['percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($isAdmin)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Ringkasan per Unit Kerja</h5>
                    <span class="text-secondary small">Periode aktif</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dashboardUnitTable" class="table table-hover align-middle dashboard-table w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja</th>
                                    <th>Operator</th>
                                    <th>Kategori</th>
                                    <th>IKU</th>
                                    <th>Target Layanan</th>
                                    <th>Realisasi Layanan</th>
                                    <th>Target IKU</th>
                                    <th>Realisasi IKU</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unitSummary as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row['unit'] }}</td>
                                        <td>{{ $row['operator'] }}</td>
                                        <td>{{ $row['kategori'] }}</td>
                                        <td>{{ $row['iku'] }}</td>
                                        <td>{{ $row['target_layanan']['filled'] }}/{{ $row['target_layanan']['total'] }} ({{ $row['target_layanan']['percentage'] }}%)</td>
                                        <td>{{ $row['realisasi_layanan']['filled'] }}/{{ $row['realisasi_layanan']['total'] }} ({{ $row['realisasi_layanan']['percentage'] }}%)</td>
                                        <td>{{ $row['target_iku']['filled'] }}/{{ $row['target_iku']['total'] }} ({{ $row['target_iku']['percentage'] }}%)</td>
                                        <td>{{ $row['realisasi_iku']['filled'] }}/{{ $row['realisasi_iku']['total'] }} ({{ $row['realisasi_iku']['percentage'] }}%)</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
        const language = {
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data',
            zeroRecords: 'Data tidak ditemukan',
            emptyTable: 'Belum ada data',
            paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
        };

        @if ($isAdmin)
            $('#dashboardUnitTable').DataTable({ order: [[1, 'asc']], language });
        @endif
    });
</script>
@endpush
