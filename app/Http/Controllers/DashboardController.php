<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        return view('dashboard.index', [
            'user' => $user,
            'isAdmin' => true,
            'periodeAktif' => null,
            'unit' => null,
            'stats' => [
                ['label' => 'Products', 'value' => 0, 'icon' => 'bi-box-seam', 'color' => 'primary'],
                ['label' => 'Inquiries', 'value' => 0, 'icon' => 'bi-chat-dots', 'color' => 'success'],
                ['label' => 'Brands', 'value' => 0, 'icon' => 'bi-award', 'color' => 'warning'],
                ['label' => 'Messages', 'value' => 0, 'icon' => 'bi-envelope', 'color' => 'info'],
            ],
            'summary' => [
                [
                    'label' => 'Content Overview',
                    'target' => ['filled' => 0, 'total' => 0, 'percentage' => 0],
                    'realisasi' => ['filled' => 0, 'total' => 0, 'percentage' => 0],
                ],
                [
                    'label' => 'Inquiries Overview',
                    'target' => ['filled' => 0, 'total' => 0, 'percentage' => 0],
                    'realisasi' => ['filled' => 0, 'total' => 0, 'percentage' => 0],
                ],
            ],
            'unitSummary' => [],
        ]);
    }
}