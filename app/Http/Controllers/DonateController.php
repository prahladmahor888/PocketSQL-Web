<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\DonationMethod;
use Illuminate\Http\Request;

class DonateController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();
        $donationMethods = DonationMethod::where('is_active', true)->orderBy('sort_order')->get();
        return view('pages.donate', compact('settings', 'donationMethods'));
    }
}
