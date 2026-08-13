@php
    // Helper untuk menandai menu aktif berdasarkan nama route.
    $is = fn(...$patterns) => request()->routeIs($patterns) ? 'active current-page' : '';
@endphp

<nav id="sidebar" class="sidebar-wrapper">

    <div class="sidebarMenuScroll">
        <ul class="sidebar-menu">
            <li class="{{ $is('dashboard') }}">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-pie-chart"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
        </ul>

        @if(auth()->user()->role === 'admin')
        <div class="shop-profile">
            <p class="mb-1 fw-bold text-primary">Master</p>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ $is('master.users.*') }}">
                <a href="{{ route('master.users.index') }}">
                    <i class="bi bi-people"></i>
                    <span class="menu-text">Manajemen User</span>
                </a>
            </li>
            <li class="{{ $is('master.unit-kerja.*') }}">
                <a href="{{ route('master.unit-kerja.index') }}">
                    <i class="bi bi-building"></i>
                    <span class="menu-text">Unit Kerja</span>
                </a>
            </li>
            <li class="{{ $is('master.jenis-layanan.*') }}">
                <a href="{{ route('master.jenis-layanan.index') }}">
                    <i class="bi bi-list-ul"></i>
                    <span class="menu-text">Jenis Kinerja Layanan</span>
                </a>
            </li>
            <li class="{{ $is('master.kategori-layanan.*') }}">
                <a href="{{ route('master.kategori-layanan.index') }}">
                    <i class="bi bi-diagram-3"></i>
                    <span class="menu-text">Kategori Kinerja Layanan</span>
                </a>
            </li>
            <li class="{{ $is('master.tujuan-rsb.*') }}">
                <a href="{{ route('master.tujuan-rsb.index') }}">
                    <i class="bi bi-bullseye"></i>
                    <span class="menu-text">Tujuan RSB</span>
                </a>
            </li>
            <li class="{{ $is('master.sasaran-program.*') }}">
                <a href="{{ route('master.sasaran-program.index') }}">
                    <i class="bi bi-signpost-2"></i>
                    <span class="menu-text">Sasaran Program</span>
                </a>
            </li>
            <li class="{{ $is('master.sasaran-strategis.*') }}">
                <a href="{{ route('master.sasaran-strategis.index') }}">
                    <i class="bi bi-flag"></i>
                    <span class="menu-text">Sasaran Strategis</span>
                </a>
            </li>
            <li class="{{ $is('master.iku-layanan.*') }}">
                <a href="{{ route('master.iku-layanan.index') }}">
                    <i class="bi bi-graph-up"></i>
                    <span class="menu-text">IKU Kinerja Layanan</span>
                </a>
            </li>
            <li class="{{ $is('master.periode-rsb.*') }}">
                <a href="{{ route('master.periode-rsb.index') }}">
                    <i class="bi bi-calendar3"></i>
                    <span class="menu-text">Periode RSB</span>
                </a>
            </li>
        </ul>
        @endif

        <div class="shop-profile mt-3">
            <p class="mb-1 fw-bold text-primary">Monitoring</p>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ $is('monitoring.target-kinerja-layanan') }}">
                <a href="{{ route('monitoring.target-kinerja-layanan') }}">
                    <i class="bi bi-bullseye"></i>
                    <span class="menu-text">Target Kinerja Layanan</span>
                </a>
            </li>
            <li class="{{ $is('monitoring.realisasi-kinerja-layanan') }}">
                <a href="{{ route('monitoring.realisasi-kinerja-layanan') }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span class="menu-text">Realisasi Kinerja Layanan</span>
                </a>
            </li>
            <li class="{{ $is('monitoring.target-kinerja-iku-rsb') }}">
                <a href="{{ route('monitoring.target-kinerja-iku-rsb') }}">
                    <i class="bi bi-bar-chart-line"></i>
                    <span class="menu-text">Target Kinerja IKU RSB</span>
                </a>
            </li>
            <li class="{{ $is('monitoring.realisasi-kinerja-iku-rsb') }}">
                <a href="{{ route('monitoring.realisasi-kinerja-iku-rsb') }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span class="menu-text">Realisasi Kinerja IKU RSB</span>
                </a>
            </li>
        </ul>

        <div class="shop-profile mt-3">
            <p class="mb-1 fw-bold text-primary">Report</p>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ $is('monitoring.laporan-capaian-kinerja-layanan*') }}">
                <a href="{{ route('monitoring.laporan-capaian-kinerja-layanan') }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span class="menu-text">Capaian Kinerja Layanan</span>
                </a>
            </li>
            <li class="{{ $is('monitoring.laporan-capaian-kinerja-iku*') }}">
                <a href="{{ route('monitoring.laporan-capaian-kinerja-iku') }}">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                    <span class="menu-text">Capaian Kinerja IKU RSB</span>
                </a>
            </li>
        </ul>

        @if(auth()->user()->role === 'admin')
        <ul class="sidebar-menu">
            <hr>
            <li class="{{ $is('master.settings.*') }}">
                <a href="{{ route('master.settings.index') }}">
                    <i class="bi bi-gear"></i>
                    <span class="menu-text">Pengaturan</span>
                </a>
            </li>
        </ul>
        @endif
    </div>

</nav>
