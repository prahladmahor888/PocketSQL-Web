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

        $pageData = cache()->remember('home_page_data_v2', 300, function () use ($settings) {
            $latestRelease = Release::where('is_latest', true)->first() ?? Release::orderBy('id', 'desc')->first();
            $screenshots = Screenshot::where('is_featured', true)->orderBy('sort_order')->get();
            $codeSnippets = CodeSnippet::orderBy('sort_order')->get();
            $topFaqs = Faq::orderBy('sort_order')->take(8)->get();
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
        $baseUrl = rtrim(url('/'), '/');
        $today = date('Y-m-d');

        $pages = [
            ['url' => $baseUrl . '/', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['url' => $baseUrl . '/download', 'changefreq' => 'daily', 'priority' => '0.95'],
            ['url' => $baseUrl . '/features', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['url' => $baseUrl . '/docs', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['url' => $baseUrl . '/faq', 'changefreq' => 'weekly', 'priority' => '0.85'],
            ['url' => $baseUrl . '/about', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => $baseUrl . '/contact', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => $baseUrl . '/donate', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => $baseUrl . '/privacy-policy', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['url' => $baseUrl . '/terms', 'changefreq' => 'monthly', 'priority' => '0.6'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $page) {
            $xml .= "    <url>\n";
            $xml .= "        <loc>" . htmlspecialchars($page['url']) . "</loc>\n";
            $xml .= "        <lastmod>" . $today . "</lastmod>\n";
            $xml .= "        <changefreq>" . $page['changefreq'] . "</changefreq>\n";
            $xml .= "        <priority>" . $page['priority'] . "</priority>\n";
            $xml .= "    </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    public function robots()
    {
        $baseUrl = rtrim(url('/'), '/');
        $content = "User-agent: *\n"
            . "Allow: /\n"
            . "Allow: /download\n"
            . "Allow: /download/apk\n"
            . "Allow: /features\n"
            . "Allow: /docs\n"
            . "Allow: /faq\n"
            . "Allow: /about\n"
            . "Allow: /contact\n"
            . "Allow: /donate\n"
            . "Allow: /privacy-policy\n"
            . "Allow: /terms\n"
            . "Disallow: /admin/\n"
            . "Disallow: /login\n\n"
            . "Sitemap: " . $baseUrl . "/sitemap.xml\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }
}
