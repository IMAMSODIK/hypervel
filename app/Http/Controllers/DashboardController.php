<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $productCount = Product::count();
        $projectCount = Project::count();
        $clientCount = Client::count();
        $inquiryCount = Inquiry::count();
        $unreadInquiries = Inquiry::where('is_read', false)->count();
        $recentInquiries = Inquiry::latest()->take(5)->get();

        return view('dashboard.index', [
            'user' => $user,
            'isAdmin' => true,
            'stats' => [
                ['label' => 'Products', 'value' => $productCount, 'icon' => 'bi-box-seam', 'color' => 'primary'],
                ['label' => 'Projects', 'value' => $projectCount, 'icon' => 'bi-kanban', 'color' => 'success'],
                ['label' => 'Clients', 'value' => $clientCount, 'icon' => 'bi-people', 'color' => 'warning'],
                ['label' => 'Inquiries', 'value' => $inquiryCount, 'icon' => 'bi-chat-dots', 'color' => 'info'],
            ],
            'unreadInquiries' => $unreadInquiries,
            'recentInquiries' => $recentInquiries,
        ]);
    }
}