<?php

namespace Tests\Feature;

use App\Models\AppSetting;
use App\Models\ContactMessage;
use App\Models\Release;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PocketSqlWebTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test all 10 public pages render successfully.
     */
    public function test_all_public_pages_render_successfully(): void
    {
        $pages = [
            '/' => 'Run a Full',
            '/about' => 'The Story Behind PocketSQL',
            '/features' => 'Full Technical Feature Matrix',
            '/docs' => 'HTTP & REST API Reference',
            '/download' => 'Downloads & Release Archive',
            '/contact' => 'Contact & Engineering Support',
            '/donate' => 'Sponsor PocketSQL Development',
            '/faq' => 'Frequently Asked Questions',
            '/privacy-policy' => 'Privacy Policy',
            '/terms' => 'Terms of Service',
        ];

        foreach ($pages as $url => $expectedText) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $response->assertSee($expectedText);
        }
    }

    /**
     * Test direct APK download route and server-side count tracking.
     */
    public function test_direct_apk_download(): void
    {
        $release = Release::create([
            'version' => 'v1.0.5',
            'version_code' => 11,
            'release_date' => 'October 2026',
            'apk_size' => '12.4 MB',
            'sha256_hash' => '9b8c73e4a2d109ef78b23c914e67f0821bcfa239d87130284ab9102ef108ca73',
            'changelog' => 'Initial build',
            'download_url' => '/download/apk',
            'downloads_count' => 10,
            'is_latest' => true,
        ]);

        $initialTotal = AppSetting::instance()->total_downloads_count;

        $response = $this->get('/download/apk');
        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=PocketSQL-v1.0.5.apk');

        // Verify release downloads count incremented by exactly 1
        $this->assertEquals(11, $release->fresh()->downloads_count);

        // Verify total downloads count incremented by exactly 1
        $this->assertEquals($initialTotal + 1, AppSetting::instance()->fresh()->total_downloads_count);

        // Verify server-side download log was created
        $this->assertDatabaseHas('download_logs', [
            'release_id' => $release->id,
            'version' => 'v1.0.5',
        ]);
    }

    /**
     * Test contact form submission creates database record.
     */
    public function test_contact_form_submission(): void
    {
        $payload = [
            'name' => 'Vikram Sharma',
            'email' => 'vikram@example.com',
            'subject' => 'Inquiry on Android 15 compatibility',
            'inquiry_type' => 'General Inquiry',
            'message' => 'Hello team, congratulations on v1.0.5! Testing this on Android 15.',
        ];

        $response = $this->post('/contact', $payload);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'vikram@example.com',
            'subject' => 'Inquiry on Android 15 compatibility',
        ]);
    }

    /**
     * Test contact form rejects spam honeypot.
     */
    public function test_contact_form_honeypot_blocking(): void
    {
        $payload = [
            'website_hp' => 'bot-link.com',
            'name' => 'Spam Bot',
            'email' => 'bot@spam.com',
            'subject' => 'Buy crypto',
            'inquiry_type' => 'General Inquiry',
            'message' => 'This is a spam message.',
        ];

        $response = $this->post('/contact', $payload);
        $response->assertRedirect();

        // Ensure database was NOT populated by bot
        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'bot@spam.com',
        ]);
    }

    /**
     * Test Admin authentication and dashboard.
     */
    public function test_admin_authentication_and_dashboard(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'testadmin@pocketsql.app'],
            ['name' => 'Test Admin', 'password' => Hash::make('secret123')]
        );

        // Guest redirected from admin
        $guestResponse = $this->get('/admin/dashboard');
        $guestResponse->assertRedirect('/admin/login');

        // Login
        $loginResponse = $this->post('/admin/login', [
            'email' => 'testadmin@pocketsql.app',
            'password' => 'secret123',
        ]);
        $loginResponse->assertRedirect('/admin/dashboard');

        // Authenticated dashboard access
        $authResponse = $this->actingAs($admin)->get('/admin/dashboard');
        $authResponse->assertStatus(200);
        $authResponse->assertSee('System Overview Dashboard');
    }

    /**
     * Test Admin settings update.
     */
    public function test_admin_settings_update(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_settings@pocketsql.app'],
            ['name' => 'Admin Settings', 'password' => Hash::make('password')]
        );

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'current_version' => 'v1.0.6',
            'version_code' => 12,
            'apk_download_url' => '/download/apk',
            'playstore_url' => 'https://play.google.com/store/apps/details?id=app.pocketsql.database',
            'github_repo_url' => 'https://github.com/pocketsql/pocketsql',
            'documentation_url' => '/docs',
            'contact_email' => 'lead@pocketsql.app',
            'release_notes' => 'Upcoming v1.0.6 update',
            'api_server_active' => '1',
        ]);

        $response->assertRedirect('/admin/settings');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('app_settings', [
            'current_version' => 'v1.0.6',
            'version_code' => 12,
            'contact_email' => 'lead@pocketsql.app',
        ]);
    }

    /**
     * Test Admin screenshot management (list, add, delete, toggle featured).
     */
    public function test_admin_screenshot_crud(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_screenshots@pocketsql.app'],
            ['name' => 'Admin Screenshots', 'password' => Hash::make('password')]
        );

        // 1. View screenshots list
        $response = $this->actingAs($admin)->get('/admin/screenshots');
        $response->assertStatus(200);
        $response->assertSee('Mobile Screenshots & Showcase Manager');

        // 2. Add new screenshot
        $postResponse = $this->actingAs($admin)->post('/admin/screenshots', [
            'title' => 'Admin Test Screenshot',
            'subtitle' => 'Testing dynamic screenshot addition from admin console',
            'image_path' => '/images/screenshots/terminal_welcome.png',
            'sort_order' => 10,
            'is_featured' => '1',
        ]);
        $postResponse->assertRedirect('/admin/screenshots');
        $postResponse->assertSessionHas('success');

        $this->assertDatabaseHas('screenshots', [
            'title' => 'Admin Test Screenshot',
            'sort_order' => 10,
        ]);

        $created = \App\Models\Screenshot::where('title', 'Admin Test Screenshot')->first();

        // 3. Toggle featured
        $toggleResponse = $this->actingAs($admin)->patch("/admin/screenshots/{$created->id}/toggle-featured");
        $toggleResponse->assertRedirect();
        $this->assertFalse($created->fresh()->is_featured);

        // 4. Delete screenshot
        $deleteResponse = $this->actingAs($admin)->delete("/admin/screenshots/{$created->id}");
        $deleteResponse->assertRedirect('/admin/screenshots');
        $this->assertDatabaseMissing('screenshots', [
            'id' => $created->id,
        ]);
    }

    /**
     * Test Admin Login Rate Limiter: strictly locks after 3 failed attempts.
     */
    public function test_admin_login_rate_limiter_locks_after_three_failed_attempts(): void
    {
        $testEmail = 'bruteforce_' . uniqid() . '@example.com';

        // Attempt 1: Failed
        $res1 = $this->post('/admin/login', [
            'email' => $testEmail,
            'password' => 'wrongpass1',
        ]);
        $res1->assertSessionHasErrors('email');
        $this->assertStringContainsString('2 of 3 attempt(s) remaining', session('errors')->first('email'));

        // Attempt 2: Failed
        $res2 = $this->post('/admin/login', [
            'email' => $testEmail,
            'password' => 'wrongpass2',
        ]);
        $res2->assertSessionHasErrors('email');
        $this->assertStringContainsString('1 of 3 attempt(s) remaining', session('errors')->first('email'));

        // Attempt 3: Failed (Lockout threshold reached!)
        $res3 = $this->post('/admin/login', [
            'email' => $testEmail,
            'password' => 'wrongpass3',
        ]);
        $res3->assertSessionHasErrors('email');
        $this->assertStringContainsString('Maximum 3 attempts reached', session('errors')->first('email'));

        // Attempt 4: Should be locked out immediately
        $res4 = $this->post('/admin/login', [
            'email' => $testEmail,
            'password' => 'wrongpass4',
        ]);
        $res4->assertSessionHasErrors('email');
        $this->assertStringContainsString('Security Alert: Too many failed login attempts', session('errors')->first('email'));
    }

    /**
     * Test Traffic Handler records logs and restricts blocked IPs.
     */
    public function test_traffic_handler_records_logs_and_blocks_restricted_ips(): void
    {
        // 1. Send public request
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertHeader('X-Traffic-Handler', 'Active');

        // Verify TrafficLog record created
        $this->assertDatabaseHas('traffic_logs', [
            'path' => '/',
            'status_code' => 200,
        ]);

        // 2. Block an IP and verify 403 Access Denied
        $blockedIp = '203.0.113.99';
        \App\Models\BlockedIp::create([
            'ip_address' => $blockedIp,
            'reason' => 'Test bot restriction',
        ]);

        $blockedResponse = $this->withServerVariables(['REMOTE_ADDR' => $blockedIp])->get('/');
        $blockedResponse->assertStatus(403);
    }

    /**
     * Test Admin session timeout middleware.
     */
    public function test_admin_session_inactivity_timeout(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'timeout_admin@pocketsql.app'],
            ['name' => 'Timeout Admin', 'password' => Hash::make('secret123')]
        );

        // Active session within 15 minutes
        $response = $this->actingAs($admin)
            ->withSession(['admin_last_activity' => time() - 300]) // 5 minutes ago
            ->get('/admin/dashboard');
        $response->assertStatus(200);

        // Expired session (> 15 minutes, e.g. 20 minutes ago)
        $expiredResponse = $this->actingAs($admin)
            ->withSession(['admin_last_activity' => time() - 1200]) // 20 minutes ago
            ->get('/admin/dashboard');

        $expiredResponse->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    /**
     * Test sitemap.xml returns valid XML format with proper content-type.
     */
    public function test_sitemap_xml_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $this->assertStringContainsString('application/xml', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('<urlset', $response->getContent());
        $this->assertStringContainsString('https://pocketsql.prahlix.com/features', $response->getContent());
    }

    /**
     * Test robots.txt returns search engine indexing directives.
     */
    public function test_robots_txt_returns_crawling_directives(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $this->assertStringContainsString('User-agent: *', $response->getContent());
        $this->assertStringContainsString('Disallow: /admin/', $response->getContent());
        $this->assertStringContainsString('Sitemap:', $response->getContent());
    }

    /**
     * Test homepage renders canonical tag, OpenGraph tags, and Schema.org JSON-LD.
     */
    public function test_homepage_renders_rich_seo_meta_and_schema(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $content = $response->getContent();
        
        $this->assertStringContainsString('<link rel="canonical"', $content);
        $this->assertStringContainsString('og:site_name', $content);
        $this->assertStringContainsString('application/ld+json', $content);
        $this->assertStringContainsString('SoftwareApplication', $content);
        $this->assertStringContainsString('Why Developers Choose PocketSQL', $content);
    }

    /**
     * Test Bot Shield blocks malicious bots, scrapers, and attack tools with 403.
     */
    public function test_bot_shield_blocks_malicious_crawlers_and_scanners(): void
    {
        // 1. sqlmap malicious scanner
        $resSqlmap = $this->withHeaders([
            'User-Agent' => 'sqlmap/1.6#stable (https://sqlmap.org)',
            'X-Test-Bot' => '1',
        ])->get('/');
        $resSqlmap->assertStatus(403);
        $this->assertStringContainsString('Bot Shield', $resSqlmap->getContent());

        // 2. bytespider aggressive scraper
        $resSpider = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (compatible; Bytespider; spider-feedback@bytedance.com)',
            'X-Test-Bot' => '1',
        ])->get('/');
        $resSpider->assertStatus(403);

        // 3. Googlebot legitimate search crawler allowed
        $resGoogle = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
            'X-Test-Bot' => '1',
        ])->get('/');
        $resGoogle->assertStatus(200);
        $resGoogle->assertHeader('X-Bot-Shield', 'Active');
        $resGoogle->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    /**
     * Test vulnerability exploit probes trigger 403 and auto IP blacklist.
     */
    public function test_exploit_probes_are_auto_banned_and_blocked(): void
    {
        $attackerIp = '198.51.100.77';

        $resProbe = $this->withServerVariables(['REMOTE_ADDR' => $attackerIp])
                         ->get('/.env');

        $resProbe->assertStatus(403);
        $this->assertStringContainsString('exploit scan probe detected', $resProbe->getContent());

        // Verify IP was auto-blacklisted
        $this->assertDatabaseHas('blocked_ips', [
            'ip_address' => $attackerIp,
        ]);
    }
}


