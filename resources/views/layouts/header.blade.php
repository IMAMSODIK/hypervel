@php
    $shortcuts = [
        ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'dashboard'],
        ['label' => 'Target Layanan', 'icon' => 'bi-bullseye', 'route' => 'monitoring.target-kinerja-layanan'],
        ['label' => 'Realisasi Layanan', 'icon' => 'bi-graph-up-arrow', 'route' => 'monitoring.realisasi-kinerja-layanan'],
        ['label' => 'Target IKU RSB', 'icon' => 'bi-bar-chart-line', 'route' => 'monitoring.target-kinerja-iku-rsb'],
        ['label' => 'Realisasi IKU RSB', 'icon' => 'bi-clipboard-data', 'route' => 'monitoring.realisasi-kinerja-iku-rsb'],
        ['label' => 'Report Layanan', 'icon' => 'bi-file-earmark-bar-graph', 'route' => 'monitoring.laporan-capaian-kinerja-layanan'],
        ['label' => 'Report IKU', 'icon' => 'bi-file-earmark-spreadsheet', 'route' => 'monitoring.laporan-capaian-kinerja-iku'],
    ];

    if (auth()->user()?->role === 'admin') {
        $shortcuts = array_merge($shortcuts, [
            ['label' => 'Manajemen User', 'icon' => 'bi-people', 'route' => 'master.users.index'],
            ['label' => 'Unit Kerja', 'icon' => 'bi-building', 'route' => 'master.unit-kerja.index'],
            ['label' => 'Periode RSB', 'icon' => 'bi-calendar3', 'route' => 'master.periode-rsb.index'],
        ]);
    }
@endphp

<div class="app-header d-flex align-items-center">
    <div class="d-flex">
        <button class="toggle-sidebar" id="toggle-sidebar">
            <i class="bi bi-list lh-1"></i>
        </button>
        <button class="pin-sidebar" id="pin-sidebar">
            <i class="bi bi-list lh-1"></i>
        </button>
    </div>

    <div class="app-brand py-3 ms-3">
        <a href="{{ url('/dashboard') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('auth_assets/logo/uinsu.png') }}" alt="{{ config('app.name') }}"
                style="height: 80px; width: auto;" class="me-3">
            <div class="d-flex flex-column">
                <span class="fw-bold text-primary fs-4">
                    {{ config('app.name') }}
                </span>

                <span class="text-muted small">
                    {{ config('app.description') }}
                </span>
            </div>

        </a>
    </div>

    <div class="header-actions col">
        <div class="d-lg-flex d-none">
            <div class="dropdown">
                <a class="dropdown-toggle d-flex px-3 py-4 position-relative" href="#!" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-grid fs-4 lh-1 text-secondary"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-lg p-2" style="min-width: 360px;">
                    <h6 class="dropdown-header">Shortcut Aplikasi</h6>
                    <div class="row g-2">
                        @foreach ($shortcuts as $shortcut)
                            <div class="col-4">
                                <a href="{{ route($shortcut['route']) }}"
                                    class="dropdown-item rounded-2 text-center p-2 h-100">
                                    <i class="bi {{ $shortcut['icon'] }} d-block fs-4 text-primary mb-1"></i>
                                    <span class="small text-wrap">{{ $shortcut['label'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="dropdown border-start">
                <a class="dropdown-toggle d-flex px-3 py-4 position-relative" href="#!" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-4 lh-1 text-secondary"></i>
                    <span class="count-label info"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-lg">
                    <h5 class="fw-semibold px-3 py-2 text-primary">Notifications</h5>
                    {{-- <div class="dropdown-item">
                        <div class="d-flex py-2 border-bottom">
                            <div class="icon-box md bg-success rounded-circle me-3">
                                <span class="fw-bold text-white">DS</span>
                            </div>
                            <div class="m-0">
                                <h6 class="mb-1 fw-semibold">Douglass Shaw</h6>
                                <p class="mb-1">
                                    Membership has been ended.
                                </p>
                                <p class="small m-0 text-secondary">Today, 07:30pm</p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <div class="d-flex py-2 border-bottom">
                            <div class="icon-box md bg-danger rounded-circle me-3">
                                <span class="fw-bold text-white">WG</span>
                            </div>
                            <div class="m-0">
                                <h6 class="mb-1 fw-semibold">Willie Garrison</h6>
                                <p class="mb-1">
                                    Congratulate, James for new job.
                                </p>
                                <p class="small m-0 text-secondary">Today, 08:00pm</p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <div class="d-flex py-2">
                            <div class="icon-box md bg-warning rounded-circle me-3">
                                <span class="fw-bold text-white">TJ</span>
                            </div>
                            <div class="m-0">
                                <h6 class="mb-1 fw-semibold">Terry Jenkins</h6>
                                <p class="mb-1">
                                    Lewis added new schedule release.
                                </p>
                                <p class="small m-0 text-secondary">Today, 09:30pm</p>
                            </div>
                        </div>
                    </div> --}}
                    <div class="d-grid mx-3 my-1">
                        <a href="javascript:void(0)" class="btn btn-primary">View all</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown ms-2">
            <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
                href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->avatar_url }}" class="rounded-2 img-3x"
                    alt="{{ config('app.name') }}" />
                <span class="ms-2 text-truncate d-lg-block d-none">{{ Auth::user()->name ?? 'Guest' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-lg">
                <div class="header-action-links mx-3 gap-2">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person text-primary"></i>Profile</a>
                    @if (auth()->user()?->role === 'admin')
                        <a class="dropdown-item" href="{{ route('master.settings.index') }}"><i class="bi bi-gear text-danger"></i>Settings</a>
                    @endif
                </div>
                <div class="mx-3 mt-2 d-grid">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm w-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
