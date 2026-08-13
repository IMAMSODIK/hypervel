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
            <p class="mb-1 fw-bold text-primary">Inquiries</p>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ $is('master.inquiries.*') }}">
                <a href="{{ route('master.inquiries.index') }}">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="menu-text">Inquiries</span>
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
            <li class="{{ $is('master.about.index') }}">
                <a href="{{ route('master.about.index') }}">
                    <i class="bi bi-building"></i>
                    <span class="menu-text">About Us</span>
                </a>
            </li>
            <li class="{{ $is('master.products.*') }}">
                <a href="{{ route('master.products.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span class="menu-text">Products</span>
                </a>
            </li>
            <li class="{{ $is('master.projects.*') }}">
                <a href="{{ route('master.projects.index') }}">
                    <i class="bi bi-kanban"></i>
                    <span class="menu-text">Projects</span>
                </a>
            </li>
            <li class="{{ $is('master.clients.*') }}">
                <a href="{{ route('master.clients.index') }}">
                    <i class="bi bi-people"></i>
                    <span class="menu-text">Our Clients</span>
                </a>
            </li>
            <li class="{{ $is('master.services.*') }}">
                <a href="{{ route('master.services.index') }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span class="menu-text">Capabilities / Services</span>
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
