<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function privacyPolicy()
    {
        $settings = AppSetting::instance();
        return view('pages.privacy', compact('settings'));
    }

    public function termsOfService()
    {
        $settings = AppSetting::instance();
        return view('pages.terms', compact('settings'));
    }
}
