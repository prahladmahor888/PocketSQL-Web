<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\CodeSnippet;
use App\Models\Faq;
use App\Models\Release;
use App\Models\Screenshot;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();

        $pageData = cache()->remember('home_page_data_v1', 300, function () use ($settings) {
            $latestRelease = Release::where('is_latest', true)->first() ?? Release::orderBy('id', 'desc')->first();
            $screenshots = Screenshot::where('is_featured', true)->orderBy('sort_order')->get();
            $codeSnippets = CodeSnippet::orderBy('sort_order')->get();
            $topFaqs = Faq::orderBy('sort_order')->take(4)->get();
            $totalDownloads = Release::sum('downloads_count');
            if ($totalDownloads < ($settings->total_downloads_count ?? 0)) {
                $totalDownloads = $settings->total_downloads_count;
            }

            return compact('latestRelease', 'screenshots', 'codeSnippets', 'topFaqs', 'totalDownloads');
        });

        return view('pages.home', array_merge(['settings' => $settings], $pageData));
    }

    public function sitemap()
    {
        $xmlPath = public_path('sitemap.xml');
        if (file_exists($xmlPath)) {
            return response(file_get_contents($xmlPath), 200, [
                'Content-Type' => 'application/xml; charset=utf-8',
            ]);
        }
        return abort(404);
    }

    public function robots()
    {
        $path = public_path('robots.txt');
        if (file_exists($path)) {
            return response(file_get_contents($path), 200, [
                'Content-Type' => 'text/plain; charset=utf-8',
            ]);
        }
        return response("User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /login\nSitemap: " . url('/sitemap.xml'), 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }
}
