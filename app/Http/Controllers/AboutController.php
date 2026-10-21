<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();
        return view('pages.about', compact('settings'));
    }
}
