<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\CodeSnippet;
use Illuminate\Http\Request;

class DocController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();
        $codeSnippets = CodeSnippet::orderBy('sort_order')->get();
        return view('pages.docs', compact('settings', 'codeSnippets'));
    }
}
