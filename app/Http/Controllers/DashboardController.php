<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Inquiry;
use App\Models\PageView;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // --- Core counts ---
        $productCount = Product::count();
        $projectCount = Project::count();
        $clientCount = Client::count();
        $inquiryCount = Inquiry::count();
        $unreadInquiries = Inquiry::where('is_read', false)->count();

        // --- Traffic stats ---
        $totalViews = PageView::count();
        $uniqueVisitors = PageView::distinct('session_id')->count('session_id');

        // Per page type views (last 30 days)
        $viewsByType = PageView::select('type', DB::raw('COUNT(*) as total'), DB::raw('COUNT(DISTINCT session_id) as unique_visitors'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        // Daily traffic last 14 days for chart
        $dailyTraffic = PageView::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT session_id) as unique_visitors')
            )
            ->where('created_at', '>=', now()->subDays(13))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top products by views (all time)
        $topProducts = PageView::select('reference_id', DB::raw('COUNT(*) as views'))
            ->where('type', 'product')
            ->whereNotNull('reference_id')
            ->groupBy('reference_id')
            ->orderByDesc('views')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                $product = Product::find($row->reference_id);
                $row->title = $product?->title ?? 'Unknown (deleted)';
                $row->slug = $product?->slug;
                return $row;
            });

        // Top projects by views (all time)
        $topProjects = PageView::select('reference_id', DB::raw('COUNT(*) as views'))
            ->where('type', 'project')
            ->whereNotNull('reference_id')
            ->groupBy('reference_id')
            ->orderByDesc('views')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                $project = Project::find($row->reference_id);
                $row->title = $project?->title ?? 'Unknown (deleted)';
                $row->slug = $project?->slug;
                return $row;
            });

        // Recent inquiries (5 latest)
        $recentInquiries = Inquiry::latest()->take(5)->get();

        // Views breakdown (last 7 days vs previous 7 days) for trend
        $thisWeekViews = PageView::where('created_at', '>=', now()->subDays(7))->count();
        $prevWeekViews = PageView::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();

        return view('dashboard.index', [
            'user' => $user,
            'isAdmin' => true,

            'productCount' => $productCount,
            'projectCount' => $projectCount,
            'clientCount' => $clientCount,
            'inquiryCount' => $inquiryCount,
            'unreadInquiries' => $unreadInquiries,

            'totalViews' => $totalViews,
            'uniqueVisitors' => $uniqueVisitors,
            'thisWeekViews' => $thisWeekViews,
            'prevWeekViews' => $prevWeekViews,
            'viewsByType' => $viewsByType,

            'dailyTraffic' => $dailyTraffic,
            'topProducts' => $topProducts,
            'topProjects' => $topProjects,
            'recentInquiries' => $recentInquiries,

            'stats' => [
                ['label' => 'Total Page Views', 'value' => $totalViews, 'icon' => 'bi-eye', 'color' => 'primary'],
                ['label' => 'Unique Visitors', 'value' => $uniqueVisitors, 'icon' => 'bi-person-check', 'color' => 'info'],
                ['label' => 'Products', 'value' => $productCount, 'icon' => 'bi-box-seam', 'color' => 'success'],
                ['label' => 'Projects', 'value' => $projectCount, 'icon' => 'bi-kanban', 'color' => 'warning'],
            ],
        ]);
    }
}