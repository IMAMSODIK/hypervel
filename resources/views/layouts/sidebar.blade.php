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

        <div class="shop-profile">
            <p class="mb-1 fw-bold text-primary">Landing Page</p>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ $is('master.hero.index') }}">
                <a href="{{ route('master.hero.index') }}">
                    <i class="bi bi-camera-reels"></i>
                    <span class="menu-text">Hero Section</span>
                </a>
            </li>
            <li class="{{ $is('master.statistics.index') }}">
                <a href="{{ route('master.statistics.index') }}">
                    <i class="bi bi-bar-chart"></i>
                    <span class="menu-text">Statistics</span>
                </a>
            </li>
            <li class="{{ $is('master.auth.banner') }}">
                <a href="{{ route('master.auth.banner') }}">
                    <i class="bi bi-images"></i>
                    <span class="menu-text">Login Banners</span>
                </a>
            </li>
            <li class="{{ $is('master.settings.contact') }}">
                <a href="{{ route('master.settings.contact') }}">
                    <i class="bi bi-telephone"></i>
                    <span class="menu-text">Contact Info</span>
                </a>
            </li>
        </ul>

    </div>

</nav>
