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
                    <p class="mb-1 opacity-75">Dashboard Administrator</p>
                    <h3 class="mb-2">Welcome, {{ $user->name }}</h3>
                    <p class="mb-0 opacity-75">Manage your landing page content and track inquiries.</p>
                </div>
                @if($unreadInquiries > 0)
                    <div class="text-md-end">
                        <a href="{{ route('master.inquiries.index') }}" class="badge bg-warning text-dark text-decoration-none fs-6">
                            <i class="bi bi-bell-fill me-1"></i> {{ $unreadInquiries }} unread inquiry@if($unreadInquiries > 1)ies@else y@endif
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Stat cards --}}
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

        {{-- Recent inquiries --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-chat-left-text me-1"></i> Recent Inquiries</h5>
                @if($unreadInquiries > 0)
                    <span class="badge bg-warning">{{ $unreadInquiries }} unread</span>
                @endif
            </div>
            <div class="card-body">
                @if ($recentInquiries->isEmpty())
                    <div class="alert alert-info mb-0">No inquiries yet.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th style="width:140px">Date</th>
                                    <th style="width:80px" class="text-end">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentInquiries as $inquiry)
                                    <tr class="{{ $inquiry->is_read ? '' : 'fw-semibold' }}">
                                        <td>{{ $inquiry->name }}</td>
                                        <td><a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">{{ $inquiry->email }}</a></td>
                                        <td class="text-secondary">
                                            <span class="d-inline-block text-truncate" style="max-width:250px;">{{ $inquiry->message }}</span>
                                            @if(!$inquiry->is_read)
                                                <span class="badge bg-warning ms-1" style="font-size:0.65rem;">NEW</span>
                                            @endif
                                        </td>
                                        <td class="text-secondary small">{{ $inquiry->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('master.inquiries.show', $inquiry) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-2">
                        <a href="{{ route('master.inquiries.index') }}" class="btn btn-sm btn-outline-secondary">View All Inquiries <i class="bi bi-arrow-right"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection