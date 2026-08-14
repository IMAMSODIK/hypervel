@extends('layouts.template')

@section('content')
    <style>
        .dashboard-welcome { background: linear-gradient(135deg, #173b67 0%, #286a8f 100%); color: #fff; }
        .dashboard-stat .stat-icon { width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.35rem; }
        .dashboard-stat .stat-value { font-size: 1.75rem; }
        .rank-bar { height: 8px; border-radius: 999px; background: #f1f5f9; overflow: hidden; }
        .rank-bar > span { display: block; height: 100%; border-radius: 999px; }
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
        {{-- Welcome --}}
        <div class="card dashboard-welcome mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <p class="mb-1 opacity-75">Dashboard Administrator</p>
                    <h3 class="mb-2">Welcome, {{ $user->name }}</h3>
                    <p class="mb-0 opacity-75">Monitor traffic, engagement, and inquiries for {{ config('app.name') }}.</p>
                </div>
                @if($unreadInquiries > 0)
                    <div>
                        <a href="{{ route('master.inquiries.index') }}" class="badge bg-warning text-dark text-decoration-none fs-6">
                            <i class="bi bi-bell-fill me-1"></i> {{ $unreadInquiries }} unread inquiry{{ $unreadInquiries > 1 ? 'ies' : 'y' }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Dashboard Info --}}
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-start gap-3 flex-wrap">
                    <div class="flex-grow-1">
                        <p class="mb-2 text-dark small">
                            <strong>About this Dashboard</strong> &mdash; This dashboard provides a real-time overview of your website's marketing performance and visitor engagement. Use it to track how visitors interact with your content and to respond to potential clients quickly.
                        </p>
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light h-100">
                                    <i class="bi bi-graph-up-arrow text-primary"></i>
                                    <span class="small text-secondary"><strong>Traffic Overview</strong> &mdash; Monitor daily page views and unique visitors for the last 14 days.</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light h-100">
                                    <i class="bi bi-pie-chart text-info"></i>
                                    <span class="small text-secondary"><strong>Views by Page</strong> &mdash; See which pages (landing, products, projects) attract the most attention.</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light h-100">
                                    <i class="bi bi-box-seam text-success"></i>
                                    <span class="small text-secondary"><strong>Top Products &amp; Projects</strong> &mdash; Identify your most viewed content to guide marketing focus.</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light h-100">
                                    <i class="bi bi-chat-left-text text-warning"></i>
                                    <span class="small text-secondary"><strong>Recent Inquiries</strong> &mdash; Respond promptly to messages from potential clients via the contact form.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="row gx-3 mb-3">
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

        {{-- Secondary stat row --}}
        <div class="row gx-3 mb-3">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-secondary small">
                            <i class="bi bi-chat-dots text-info"></i> Inquiries
                            @php
                                $prevInq = App\Models\Inquiry::whereBetween('created_at',[now()->subDays(14), now()->subDays(7)])->count();
                                $diff = $prevInq ? (($inquiryCount - $prevInq) / $prevInq * 100) : ($inquiryCount > 0 ? 100 : 0);
                            @endphp
                            @if($diff > 0)<span class="badge bg-success-subtle text-success"><i class="bi bi-arrow-up"></i> {{ round($diff) }}%</span>@elseif($diff < 0)<span class="badge bg-danger-subtle text-danger"><i class="bi bi-arrow-down"></i> {{ round(abs($diff)) }}%</span>@endif
                        </div>
                        <h3 class="mb-0 mt-1">{{ number_format($inquiryCount) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-secondary small">
                            <i class="bi bi-people text-warning"></i> Clients
                        </div>
                        <h3 class="mb-0 mt-1">{{ number_format($clientCount) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-secondary small">
                            <i class="bi bi-graph-up-arrow text-primary"></i> Views (this week)
                            @php
                                $trend = $prevWeekViews ? (($thisWeekViews - $prevWeekViews) / $prevWeekViews * 100) : ($thisWeekViews > 0 ? 100 : 0);
                            @endphp
                            @if($trend > 0)<span class="badge bg-success-subtle text-success"><i class="bi bi-arrow-up"></i> {{ round($trend) }}%</span>@elseif($trend < 0)<span class="badge bg-danger-subtle text-danger"><i class="bi bi-arrow-down"></i> {{ round(abs($trend)) }}%</span>@endif
                        </div>
                        <h3 class="mb-0 mt-1">{{ number_format($thisWeekViews) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-secondary small">
                            <i class="bi bi-calendar-week text-info"></i> Views (prev week)
                        </div>
                        <h3 class="mb-0 mt-1">{{ number_format($prevWeekViews) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            {{-- Traffic Chart --}}
            <div class="col-12 col-xl-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="bi bi-graph-up me-1"></i> Traffic Overview (Last 14 Days)</h5>
                    </div>
                    <div class="card-body">
                        <div id="trafficChart" style="height:300px;"></div>
                    </div>
                </div>
            </div>

            {{-- Page type breakdown --}}
            <div class="col-12 col-xl-4">
                <div class="card mb-3 h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="bi bi-pie-chart me-1"></i> Views by Page (30 days)</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $typeLabels = ['landing' => 'Landing', 'about' => 'About', 'projects' => 'Projects List', 'product' => 'Product Detail', 'project' => 'Project Detail'];
                        @endphp
                        @if($viewsByType->isEmpty())
                            <p class="text-secondary small mb-0">No page views recorded yet.</p>
                        @else
                            @php
                                $maxType = $viewsByType->max('total');
                            @endphp
                            @foreach($viewsByType as $type => $row)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-semibold">{{ $typeLabels[$type] ?? ucfirst($type) }}</span>
                                        <span class="small text-secondary">{{ $row->total }} views / {{ $row->unique_visitors }} unique</span>
                                    </div>
                                    <div class="rank-bar">
                                        <span style="width: {{ ($maxType ? ($row->total / $maxType * 100) : 0) }}%; background: {{ ['landing' => '#263C92', 'about' => '#3a54b0', 'projects' => '#DFB624', 'product' => '#10b981', 'project' => '#f59e0b'][$type] ?? '#6366f1' }};"></span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary small">Total (all time):</span>
                            <strong>{{ number_format($totalViews) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary small">Unique visitors:</span>
                            <strong>{{ number_format($uniqueVisitors) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Top Products by Views --}}
            <div class="col-12 col-xl-6">
                <div class="card mb-3 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="bi bi-box-seam me-1"></i> Top Products by Views</h5>
                        <a href="{{ route('master.products.index') }}" class="btn btn-sm btn-outline-secondary">Manage</a>
                    </div>
                    <div class="card-body">
                        @if($topProducts->isEmpty())
                            <p class="text-secondary small mb-0">No product views yet.</p>
                        @else
                            @php $maxProd = $topProducts->first()->views; @endphp
                            @foreach($topProducts as $i => $item)
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="badge {{ $i === 0 ? 'bg-gold text-primary' : 'bg-light text-secondary' }} rounded-pill" style="min-width:28px;">{{ $i + 1 }}</span>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between mb-1">
                                            @if($item->slug)
                                                <a href="{{ route('products.show', $item->slug) }}" target="_blank" class="small text-decoration-none text-truncate" style="max-width:200px;">{{ $item->title }}</a>
                                            @else
                                                <span class="small text-secondary">{{ $item->title }}</span>
                                            @endif
                                            <span class="small text-secondary">{{ number_format($item->views) }} views</span>
                                        </div>
                                        <div class="rank-bar">
                                            <span style="width: {{ ($maxProd ? ($item->views / $maxProd * 100) : 0) }}%; background: #10b981;"></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- Top Projects by Views --}}
            <div class="col-12 col-xl-6">
                <div class="card mb-3 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="bi bi-kanban me-1"></i> Top Projects by Views</h5>
                        <a href="{{ route('master.projects.index') }}" class="btn btn-sm btn-outline-secondary">Manage</a>
                    </div>
                    <div class="card-body">
                        @if($topProjects->isEmpty())
                            <p class="text-secondary small mb-0">No project views yet.</p>
                        @else
                            @php $maxProj = $topProjects->first()->views; @endphp
                            @foreach($topProjects as $i => $item)
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="badge {{ $i === 0 ? 'bg-gold text-primary' : 'bg-light text-secondary' }} rounded-pill" style="min-width:28px;">{{ $i + 1 }}</span>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between mb-1">
                                            @if($item->slug)
                                                <a href="{{ route('projects.show', $item->slug) }}" target="_blank" class="small text-decoration-none text-truncate" style="max-width:200px;">{{ $item->title }}</a>
                                            @else
                                                <span class="small text-secondary">{{ $item->title }}</span>
                                            @endif
                                            <span class="small text-secondary">{{ number_format($item->views) }} views</span>
                                        </div>
                                        <div class="rank-bar">
                                            <span style="width: {{ ($maxProj ? ($item->views / $maxProj * 100) : 0) }}%; background: #f59e0b;"></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- Recent Inquiries --}}
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="bi bi-chat-left-text me-1"></i> Recent Inquiries</h5>
                        <div>
                            @if($unreadInquiries > 0)<span class="badge bg-warning me-2">{{ $unreadInquiries }} unread</span>@endif
                            <a href="{{ route('master.inquiries.index') }}" class="btn btn-sm btn-outline-secondary">View All <i class="bi bi-arrow-right"></i></a>
                        </div>
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
                                            <th>Company</th>
                                            <th>Message</th>
                                            <th style="width:140px">Date</th>
                                            <th class="text-end" style="width:80px">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentInquiries as $inquiry)
                                            <tr class="{{ $inquiry->is_read ? '' : 'fw-semibold' }}">
                                                <td>{{ $inquiry->name }}</td>
                                                <td><a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">{{ $inquiry->email }}</a></td>
                                                <td>{{ $inquiry->company ?: '&mdash;' }}</td>
                                                <td class="text-secondary">
                                                    <span class="d-inline-block text-truncate" style="max-width:250px;">{{ $inquiry->message }}</span>
                                                    @if(!$inquiry->is_read)<span class="badge bg-warning ms-1" style="font-size:0.65rem;">NEW</span>@endif
                                                </td>
                                                <td class="text-secondary small">{{ $inquiry->created_at->format('d M Y, H:i') }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('master.inquiries.show', $inquiry) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.2"></script>
<script>
    var trafficData = @json($dailyTraffic->map(fn($d) => ['date' => $d->date, 'views' => (int)$d->views, 'unique' => (int)$d->unique_visitors]));

    var dates = trafficData.map(function(d){ return d.date; });
    var views = trafficData.map(function(d){ return d.views; });
    var uniques = trafficData.map(function(d){ return d.unique; });

    var options = {
        chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
        series: [
            { name: 'Page Views', data: views, color: '#263C92' },
            { name: 'Unique Visitors', data: uniques, color: '#DFB624' }
        ],
        labels: dates,
        xaxis: { type: 'datetime' },
        yaxis: { min: 0, forceNiceScale: true },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 } },
        legend: { position: 'top' },
        markers: { size: 0, hover: { size: 5 } },
        grid: { borderColor: '#e2e8f0', strokeDashArray: 4 },
    };

    var chart = new ApexCharts(document.querySelector('#trafficChart'), options);
    chart.render();
</script>
@endpush