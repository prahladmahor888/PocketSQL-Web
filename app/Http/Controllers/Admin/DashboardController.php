<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\ContactMessage;
use App\Models\DonationMethod;
use App\Models\Release;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();
        $totalMessages = ContactMessage::count();
        $unreadMessages = ContactMessage::where('status', 'unread')->count();
        $totalReleases = Release::count();
        $activeDonations = DonationMethod::where('is_active', true)->count();
        $recentMessages = ContactMessage::orderBy('id', 'desc')->take(6)->get();
        $totalDownloads = Release::sum('downloads_count');
        if ($totalDownloads < ($settings->total_downloads_count ?? 0)) {
            $totalDownloads = $settings->total_downloads_count;
        }

        return view('admin.dashboard', compact(
            'settings',
            'totalMessages',
            'unreadMessages',
            'totalReleases',
            'activeDonations',
            'recentMessages',
            'totalDownloads'
        ));
    }
}
