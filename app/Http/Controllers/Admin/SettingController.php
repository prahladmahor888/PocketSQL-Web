<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = AppSetting::instance();

        $validated = $request->validate([
            'current_version' => 'required|string|max:50',
            'version_code' => 'required|integer|min:1',
            'apk_download_url' => 'required|string',
            'playstore_url' => 'nullable|url',
            'github_repo_url' => 'required|url',
            'documentation_url' => 'required|string',
            'contact_email' => 'required|email|max:150',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:255',
            'support_hours' => 'nullable|string|max:100',
            'discord_url' => 'nullable|string|max:255',
            'telegram_url' => 'nullable|string|max:255',
            'release_notes' => 'nullable|string',
            'api_server_active' => 'nullable|boolean',
            'razorpay_enabled' => 'nullable|boolean',
            'razorpay_key_id' => 'nullable|string|max:100',
            'razorpay_key_secret' => 'nullable|string|max:100',
            'min_donation_amount' => 'nullable|integer|min:1|max:50000',
        ]);

        $validated['api_server_active'] = $request->has('api_server_active');
        $validated['razorpay_enabled'] = $request->has('razorpay_enabled');
        $validated['min_donation_amount'] = (int) ($request->input('min_donation_amount') ?: 100);

        // Keep existing secret if left empty during updates
        if (empty($request->input('razorpay_key_secret'))) {
            unset($validated['razorpay_key_secret']);
        }

        $settings->update($validated);

        return redirect()->route('admin.settings')->with('success', 'Application settings have been updated successfully.');
    }
}
