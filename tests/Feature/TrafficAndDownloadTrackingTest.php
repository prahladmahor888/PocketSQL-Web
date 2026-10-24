<?php

namespace Tests\Feature;

use App\Models\AppSetting;
use App\Models\DownloadLog;
use App\Models\Release;
use App\Models\TrafficLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrafficAndDownloadTrackingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test web traffic handler logs location (e.g., Gwalior, MP, India) and device details
     */
    public function test_traffic_handler_records_location_and_device(): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 14; SM-S918B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
        ])->get('/');

        $response->assertStatus(200);

        // Verify TrafficLog was created with location and device fields
        $log = TrafficLog::orderBy('id', 'desc')->first();
        $this->assertNotNull($log);
        $this->assertNotNull($log->city);
        $this->assertNotNull($log->state);
        $this->assertNotNull($log->country);
        $this->assertEquals('Mobile', $log->device_type);
        $this->assertStringContainsString('Android', $log->os);
        $this->assertEquals('Chrome', $log->browser);

        // Verify formatted location accessor
        $this->assertStringContainsString($log->city, $log->formatted_location);
        $this->assertStringContainsString($log->country, $log->formatted_location);

        // Verify flag url accessor
        $this->assertNotNull($log->flag_url);
    }

    /**
     * Test APK download records IP, location (City, State, Country + Flag) and device
     */
    public function test_apk_download_records_location_ip_and_device(): void
    {
        $release = Release::create([
            'version' => 'v1.0.5',
            'version_code' => 12,
            'release_date' => 'October 2026',
            'apk_size' => '12.4 MB',
            'sha256_hash' => 'hash123456789',
            'changelog' => 'New release build',
            'download_url' => '/download/apk',
            'downloads_count' => 5,
            'is_latest' => true,
        ]);

        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
        ])->get('/download/apk');

        $response->assertStatus(200);

        // Verify DownloadLog entry exists with IP, location and device
        $dlLog = DownloadLog::where('release_id', $release->id)->orderBy('id', 'desc')->first();
        $this->assertNotNull($dlLog);
        $this->assertNotNull($dlLog->ip_address);
        $this->assertNotNull($dlLog->city);
        $this->assertNotNull($dlLog->state);
        $this->assertNotNull($dlLog->country);
        $this->assertEquals('Desktop', $dlLog->device_type);
        $this->assertStringContainsString('Windows', $dlLog->os);
        $this->assertEquals('Chrome', $dlLog->browser);

        // Verify formatted location contains expected format
        $this->assertStringContainsString('India', $dlLog->formatted_location);
        $this->assertNotNull($dlLog->flag_url);
    }

    /**
     * Test Admin Traffic Dashboard renders Web Traffic and APK Downloads tabs
     */
    public function test_admin_traffic_dashboard_renders_location_and_device_tabs(): void
    {
        $admin = User::first() ?? User::create([
            'name' => 'Admin User',
            'email' => 'admin@pocketsql.net',
            'password' => bcrypt('AdminPassword123!'),
        ]);

        // Seed sample download log
        DownloadLog::create([
            'release_id' => null,
            'version' => 'v1.0.5',
            'ip_address' => '103.21.244.2',
            'city' => 'Gwalior',
            'state' => 'MP',
            'country' => 'India',
            'country_code' => 'IN',
            'device_type' => 'Mobile',
            'os' => 'Android 14',
            'browser' => 'Chrome',
            'user_agent' => 'Mozilla/5.0 (Linux; Android 14) Chrome/120.0 Mobile',
        ]);

        $response = $this->actingAs($admin)->get('/admin/traffic');
        $response->assertStatus(200);
        $response->assertSee('Web Traffic Stream');
        $response->assertSee('APK Download Logs &amp; Locations', false);
        $response->assertSee('Gwalior, MP, India');

        // Test downloads tab specifically
        $downloadsTabResponse = $this->actingAs($admin)->get('/admin/traffic?tab=downloads');
        $downloadsTabResponse->assertStatus(200);
        $downloadsTabResponse->assertSee('Top APK Download Locations');
        $downloadsTabResponse->assertSee('Gwalior, MP, India');
        $downloadsTabResponse->assertSee('103.21.244.2');

        // Test Country-wise totals & chart presence
        $downloadsTabResponse->assertSee('Requests by Country (Total Summary)');
        $downloadsTabResponse->assertSee('Traffic Share by Country');
        $downloadsTabResponse->assertSee('Date Filter:');

        // Test Date Filter
        $dateFilterResponse = $this->actingAs($admin)->get('/admin/traffic?date_range=today');
        $dateFilterResponse->assertStatus(200);
        $dateFilterResponse->assertSee('Today');
    }

    /**
     * Test downloads count is purely dynamic and not hardcoded to 1248 or 842
     */
    public function test_downloads_count_is_not_hardcoded(): void
    {
        $settings = AppSetting::instance();
        // Assert setting baseline is 0
        $this->assertEquals(0, $settings->fresh()->total_downloads_count);

        $response = $this->get('/download');
        $response->assertStatus(200);
        // Verify 842 hardcoded fallback is NOT present
        $response->assertDontSee('842 downloads');
    }

    /**
     * Test admin dashboard renders traffic and download charts
     */
    public function test_admin_dashboard_renders_traffic_and_download_charts(): void
    {
        $admin = User::first() ?? User::create([
            'name' => 'Admin User',
            'email' => 'admin@pocketsql.net',
            'password' => bcrypt('AdminPassword123!'),
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Web Traffic Activity Trends');
        $response->assertSee('APK Downloaders Trajectory');
        $response->assertSee('dashboardTrafficChart');
        $response->assertSee('dashboardDownloadsChart');
    }
}
