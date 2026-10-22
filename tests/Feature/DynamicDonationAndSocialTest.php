<?php

namespace Tests\Feature;

use App\Models\AppSetting;
use App\Models\DonationTier;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DynamicDonationAndSocialTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdminUser(): User
    {
        return User::first() ?: User::factory()->create([
            'email' => 'admin@pocketsql.app',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_donation_page_renders_dynamic_tiers(): void
    {
        $response = $this->get('/donate');
        $response->assertStatus(200);
        $response->assertSee('Sponsor PocketSQL');
    }

    public function test_contact_page_renders_successfully(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Communication Channels');
    }

    public function test_admin_can_manage_donation_tiers(): void
    {
        $admin = $this->getAdminUser();

        // 1. List
        $res = $this->actingAs($admin)->get('/admin/donation-tiers');
        $res->assertStatus(200);
        $res->assertSee('Donation Amount Cards');

        // 2. Create
        $resCreate = $this->actingAs($admin)->post('/admin/donation-tiers', [
            'amount' => 750,
            'name' => 'Elite Backer',
            'badge' => 'Special',
            'impact_heading' => 'Elite Hardware Testing',
            'impact_text' => 'Covers customized testing on Android devices.',
            'sort_order' => 10,
            'is_popular' => '1',
            'is_active' => '1',
        ]);
        $resCreate->assertRedirect('/admin/donation-tiers');

        $tier = DonationTier::where('amount', 750)->first();
        $this->assertNotNull($tier);
        $this->assertEquals('Elite Backer', $tier->name);
        $this->assertTrue($tier->is_popular);

        // 3. Update
        $resUpdate = $this->actingAs($admin)->put('/admin/donation-tiers/' . $tier->id, [
            'amount' => 800,
            'name' => 'Elite Backer Pro',
            'badge' => 'Top Pick',
            'impact_heading' => 'Updated Impact',
            'impact_text' => 'Updated text description.',
            'sort_order' => 5,
            'is_active' => '1',
        ]);
        $resUpdate->assertRedirect('/admin/donation-tiers');

        $tier->refresh();
        $this->assertEquals(800, $tier->amount);
        $this->assertEquals('Elite Backer Pro', $tier->name);

        // 4. Delete
        $resDelete = $this->actingAs($admin)->delete('/admin/donation-tiers/' . $tier->id);
        $resDelete->assertRedirect('/admin/donation-tiers');
        $this->assertNull(DonationTier::find($tier->id));
    }

    public function test_admin_can_manage_social_links(): void
    {
        $admin = $this->getAdminUser();

        // 1. List
        $res = $this->actingAs($admin)->get('/admin/social-links');
        $res->assertStatus(200);
        $res->assertSee('Social Media Channels');

        // 2. Create
        $resCreate = $this->actingAs($admin)->post('/admin/social-links', [
            'platform' => 'youtube',
            'label' => 'PocketSQL YouTube',
            'url' => 'https://youtube.com/@pocketsql',
            'icon_svg' => 'fa-brands fa-youtube',
            'sort_order' => 10,
            'is_active' => '1',
        ]);
        $resCreate->assertRedirect('/admin/social-links');

        $link = SocialLink::where('platform', 'youtube')->first();
        $this->assertNotNull($link);
        $this->assertEquals('https://youtube.com/@pocketsql', $link->url);

        // 3. Update
        $resUpdate = $this->actingAs($admin)->put('/admin/social-links/' . $link->id, [
            'platform' => 'youtube',
            'label' => 'PocketSQL Official Videos',
            'url' => 'https://youtube.com/@pocketsql_hq',
            'icon_svg' => 'fa-brands fa-youtube',
            'sort_order' => 12,
            'is_active' => '1',
        ]);
        $resUpdate->assertRedirect('/admin/social-links');

        $link->refresh();
        $this->assertEquals('PocketSQL Official Videos', $link->label);
        $this->assertEquals('https://youtube.com/@pocketsql_hq', $link->url);

        // 4. Delete
        $resDelete = $this->actingAs($admin)->delete('/admin/social-links/' . $link->id);
        $resDelete->assertRedirect('/admin/social-links');
        $this->assertNull(SocialLink::find($link->id));
    }

    public function test_admin_can_update_contact_settings(): void
    {
        $admin = $this->getAdminUser();
        $settings = AppSetting::instance();

        $res = $this->actingAs($admin)->post('/admin/settings', [
            'current_version' => $settings->current_version,
            'version_code' => $settings->version_code,
            'apk_download_url' => $settings->apk_download_url,
            'github_repo_url' => $settings->github_repo_url,
            'documentation_url' => $settings->documentation_url,
            'contact_email' => 'contact@testpocketsql.app',
            'contact_phone' => '+91 99999 88888',
            'contact_address' => 'Test Tech Park, Bangalore, India',
            'support_hours' => 'Mon-Fri 10am-5pm',
            'discord_url' => 'https://discord.gg/testpocketsql',
            'telegram_url' => 'https://t.me/testpocketsql',
            'min_donation_amount' => 150,
        ]);

        $res->assertRedirect('/admin/settings');
        $settings->refresh();

        $this->assertEquals('contact@testpocketsql.app', $settings->contact_email);
        $this->assertEquals('+91 99999 88888', $settings->contact_phone);
        $this->assertEquals('Test Tech Park, Bangalore, India', $settings->contact_address);
        $this->assertEquals('Mon-Fri 10am-5pm', $settings->support_hours);
        $this->assertEquals('https://discord.gg/testpocketsql', $settings->discord_url);
        $this->assertEquals('https://t.me/testpocketsql', $settings->telegram_url);
        $this->assertEquals(150, $settings->min_donation_amount);
    }
}
