@php
    $shortcuts = [
        ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'dashboard'],
        ['label' => 'Hero Section', 'icon' => 'bi-camera-reels', 'route' => 'master.hero.index'],
        ['label' => 'Statistics', 'icon' => 'bi-bar-chart', 'route' => 'master.statistics.index'],
        ['label' => 'About Us', 'icon' => 'bi-building', 'route' => 'master.about.index'],
        ['label' => 'Products', 'icon' => 'bi-box-seam', 'route' => 'master.products.index'],
        ['label' => 'Services', 'icon' => 'bi-grid-1x2', 'route' => 'master.services.index'],
        ['label' => 'Projects', 'icon' => 'bi-kanban', 'route' => 'master.projects.index'],
        ['label' => 'Clients', 'icon' => 'bi-people', 'route' => 'master.clients.index'],
        ['label' => 'Inquiries', 'icon' => 'bi-chat-left-text', 'route' => 'master.inquiries.index'],
        ['label' => 'Contact Info', 'icon' => 'bi-telephone', 'route' => 'master.settings.contact'],
        ['label' => 'Login Banners', 'icon' => 'bi-images', 'route' => 'master.auth.banner'],
    ];

    $unreadInquiries = \App\Models\Inquiry::where('is_read', false)->latest()->take(5)->get();
    $unreadCount = $unreadInquiries->count();
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
            <img src="{{ asset('auth_assets/logo/logo.png') }}" alt="{{ config('app.name') }}"
                style="height: 48px; width: auto;" class="me-3">
            <div class="d-flex flex-column">
                <span class="fw-bold text-primary fs-5">
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
            {{-- Shortcuts --}}
            <div class="dropdown">
                <a class="dropdown-toggle d-flex px-3 py-4 position-relative" href="#!" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-grid fs-4 lh-1 text-secondary"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-lg p-2" style="min-width: 360px;">
                    <h6 class="dropdown-header">Shortcut</h6>
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

            {{-- Notifications --}}
            <div class="dropdown border-start">
                <a class="dropdown-toggle d-flex px-3 py-4 position-relative" href="#!" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-4 lh-1 text-secondary"></i>
                    @if($unreadCount > 0)
                        <span class="count-label info">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-lg" style="min-width:340px;">
                    <h5 class="fw-semibold px-3 py-2 text-primary d-flex justify-content-between align-items-center">
                        Notifications
                        @if($unreadCount > 0)
                            <span class="badge bg-warning text-dark">{{ $unreadCount }} new</span>
                        @endif
                    </h5>
                    @if($unreadInquiries->isNotEmpty())
                        @foreach($unreadInquiries as $inquiry)
                            <div class="dropdown-item">
                                <a href="{{ route('master.inquiries.show', $inquiry) }}" class="d-flex py-2 border-bottom text-decoration-none">
                                    <div class="icon-box md bg-primary rounded-circle me-3">
                                        <span class="fw-bold text-white">{{ strtoupper(substr($inquiry->name, 0, 2)) }}</span>
                                    </div>
                                    <div class="m-0 text-dark">
                                        <h6 class="mb-1 fw-semibold">{{ $inquiry->name }}</h6>
                                        <p class="mb-1 text-secondary small text-truncate" style="max-width:240px;">{{ $inquiry->message }}</p>
                                        <p class="small m-0 text-secondary">{{ $inquiry->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="px-3 py-4 text-center text-secondary small">
                            <i class="bi bi-bell-slash fs-2 d-block mb-2 opacity-50"></i>
                            No new notifications
                        </div>
                    @endif
                    <div class="d-grid mx-3 my-1">
                        <a href="{{ route('master.inquiries.index') }}" class="btn btn-primary btn-sm">View all inquiries</a>
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
                {{-- <div class="header-action-links mx-3 gap-2">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person text-primary"></i> Profile</a>
                </div> --}}
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
