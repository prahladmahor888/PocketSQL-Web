<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Screenshot;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();
        $screenshots = Screenshot::orderBy('sort_order')->get();
        return view('pages.features', compact('settings', 'screenshots'));
    }
}
