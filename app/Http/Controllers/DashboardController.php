<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService; 

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $user = auth()->user();
        $dashboardData = $this->dashboardService->getDashboardData($user);
        $projects = $user->projects;
        return view('dashboard', compact('dashboardData', 'projects'));
    }
}
