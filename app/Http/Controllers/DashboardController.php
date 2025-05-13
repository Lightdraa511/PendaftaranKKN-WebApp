<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // User Dashboard
    public function index()
    {
        $user = Auth::user();
        $pengaturan = Pengaturan::getCurrent();
        $locations = Lokasi::where('status', '!=', 'penuh')
            ->orderBy('status', 'asc')
            ->limit(3)
            ->get();

        return view('user.dashboard', compact('user', 'pengaturan', 'locations'));
    }

    // Landing Page
    public function landing()
    {
        $pengaturan = Pengaturan::getCurrent();
        $locations = Lokasi::where('status', '!=', 'penuh')
            ->orderBy('status', 'asc')
            ->limit(3)
            ->get();

        return view('landing', compact('pengaturan', 'locations'));
    }

    // Bantuan
    public function help()
    {
        return view('user.help');
    }
}