<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Mail\InvitationEmail;
use Illuminate\Support\Facades\Mail; 

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function test()
    {
           Mail::to('surajrawat321998@gmail.com')->send(new InvitationEmail(1));
    }

    public function index()
    {
        $user = auth()->user();
        $dashboardData = $this->dashboardService->getDashboardData($user);
        $projects = $user->projects;
        return view('dashboard', compact('dashboardData', 'projects'));
    }
}
