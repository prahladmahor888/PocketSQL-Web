<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();

        $pageData = cache()->remember('faq_page_data_v1', 600, function () {
            $faqs = Faq::orderBy('sort_order')->get();
            $categories = Faq::select('category')->distinct()->pluck('category');

            return compact('faqs', 'categories');
        });

        return view('pages.faq', array_merge(['settings' => $settings], $pageData));
    }
}
