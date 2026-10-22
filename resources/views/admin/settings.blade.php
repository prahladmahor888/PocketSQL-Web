<x-admin.layout title="Application Settings — PocketSQL Admin">

    <!-- Header -->
    <div class="border-b border-slate-200 pb-5">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
            <i class="fa-solid fa-sliders text-slate-700"></i>
            <span>Application &amp; Global Settings</span>
        </h1>
        <p class="text-xs text-slate-500 mt-1">Configure global application variables, direct download endpoints, and documentation references dynamically.</p>
    </div>

    <div class="max-w-4xl space-y-6">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section 1: Build & Version Settings -->
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 sm:p-7 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-code-commit"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Build &amp; Version Control</h3>
                        <p class="text-[11px] text-slate-500">Defines the current production release tag shown to users.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="current_version" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-tag text-slate-400 text-[11px]"></i>
                            <span>Current Release Version</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="current_version" 
                               name="current_version" 
                               required 
                               value="{{ old('current_version', $settings->current_version) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                        <span class="text-[11px] text-slate-400">e.g. v1.0.5</span>
                    </div>

                    <div class="space-y-1.5">
                        <label for="version_code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-hashtag text-slate-400 text-[11px]"></i>
                            <span>Internal Build Code</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="version_code" 
                               name="version_code" 
                               required 
                               value="{{ old('version_code', $settings->version_code) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                        <span class="text-[11px] text-slate-400">e.g. 11 (used for Android update verification)</span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Distribution & Store Links -->
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 sm:p-7 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-cloud-arrow-down"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Distribution &amp; Downloads</h3>
                        <p class="text-[11px] text-slate-500">Endpoints and links for downloading the Android package.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="apk_download_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-file-zipper text-slate-400 text-[11px]"></i>
                            <span>Direct APK Download Path / URL</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="apk_download_url" 
                               name="apk_download_url" 
                               required 
                               value="{{ old('apk_download_url', $settings->apk_download_url) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                        <span class="text-[11px] text-slate-400">e.g. /download/apk or direct CDN link</span>
                    </div>

                    <div class="space-y-1.5">
                        <label for="playstore_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-brands fa-google-play text-slate-400 text-[11px]"></i>
                            <span>Google Play Store Listing URL</span>
                        </label>
                        <input type="url" 
                               id="playstore_url" 
                               name="playstore_url" 
                               value="{{ old('playstore_url', $settings->playstore_url) }}"
                               placeholder="https://play.google.com/store/apps/details?id=app.pocketsql.database"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                    </div>
                </div>
            </div>

            <!-- Section 3: Repositories & Support -->
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 sm:p-7 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-[8px] bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-share-nodes"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Developer Channels &amp; Support</h3>
                        <p class="text-[11px] text-slate-500">Official repositories and support points of contact.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="github_repo_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-brands fa-github text-slate-400 text-[11px]"></i>
                            <span>GitHub Repository URL</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="url" 
                               id="github_repo_url" 
                               name="github_repo_url" 
                               required 
                               value="{{ old('github_repo_url', $settings->github_repo_url) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                    </div>

                    <div class="space-y-1.5">
                        <label for="contact_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-envelope text-slate-400 text-[11px]"></i>
                            <span>Public Support Email</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="contact_email" 
                               name="contact_email" 
                               required 
                               value="{{ old('contact_email', $settings->contact_email) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                    </div>

                    <div class="space-y-1.5">
                        <label for="contact_phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-phone text-slate-400 text-[11px]"></i>
                            <span>Contact Phone / WhatsApp</span>
                        </label>
                        <input type="text" 
                               id="contact_phone" 
                               name="contact_phone" 
                               placeholder="+91 98765 43210"
                               value="{{ old('contact_phone', $settings->contact_phone) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                    </div>

                    <div class="space-y-1.5">
                        <label for="support_hours" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-clock text-slate-400 text-[11px]"></i>
                            <span>Support Hours / Turnaround</span>
                        </label>
                        <input type="text" 
                               id="support_hours" 
                               name="support_hours" 
                               placeholder="Mon - Fri, 9:00 AM - 6:00 PM IST (Response in 24-48h)"
                               value="{{ old('support_hours', $settings->support_hours) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-1.5 sm:col-span-2">
                        <label for="contact_address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-location-dot text-slate-400 text-[11px]"></i>
                            <span>Operating / Office Address</span>
                        </label>
                        <input type="text" 
                               id="contact_address" 
                               name="contact_address" 
                               placeholder="e.g. Bangalore, Karnataka, India"
                               value="{{ old('contact_address', $settings->contact_address) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-1.5">
                        <label for="discord_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-brands fa-discord text-slate-400 text-[11px]"></i>
                            <span>Discord Server Invite URL</span>
                        </label>
                        <input type="text" 
                               id="discord_url" 
                               name="discord_url" 
                               placeholder="https://discord.gg/pocketsql"
                               value="{{ old('discord_url', $settings->discord_url) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                    </div>

                    <div class="space-y-1.5">
                        <label for="telegram_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-brands fa-telegram text-slate-400 text-[11px]"></i>
                            <span>Telegram Community Link</span>
                        </label>
                        <input type="text" 
                               id="telegram_url" 
                               name="telegram_url" 
                               placeholder="https://t.me/pocketsql_official"
                               value="{{ old('telegram_url', $settings->telegram_url) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                    </div>
                </div>

                <!-- Documentation Link -->
                <div class="space-y-1.5">
                    <label for="documentation_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-book-open text-slate-400 text-[11px]"></i>
                        <span>Documentation Route / URL</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="documentation_url" 
                           name="documentation_url" 
                           required 
                           value="{{ old('documentation_url', $settings->documentation_url) }}"
                           class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                </div>
            </div>

            <!-- Section 4: Release Announcement Text -->
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 sm:p-7 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Release Announcement Banner</h3>
                        <p class="text-[11px] text-slate-500">Banner announcement copy shown on the hero section.</p>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <textarea id="release_notes" 
                              name="release_notes" 
                              rows="3" 
                              placeholder="e.g. Version 1.0.5 is now live with enhanced foreground execution and Kotlin 2.0 runtime."
                              class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">{{ old('release_notes', $settings->release_notes) }}</textarea>
                </div>
            </div>

            <!-- Section 5: API Server Status Toggle -->
            <div class="p-5 rounded-[10px] bg-white border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start space-x-3">
                    <div class="w-9 h-9 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-server"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-900 block">Foreground API Daemon Active Status</span>
                        <span class="text-[11px] text-slate-500">Controls whether the public website displays the real-time active green indicator for port 8080.</span>
                    </div>
                </div>

                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                    <input type="checkbox" name="api_server_active" value="1" {{ $settings->api_server_active ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- Section 6: Razorpay Payment Gateway Configuration -->
            <div id="razorpay-config" class="bg-white border border-slate-200 rounded-[10px] p-5 sm:p-7 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Razorpay Payment Gateway Settings</h3>
                            <p class="text-[11px] text-slate-500">Collect community donations via UPI (GPay/PhonePe), Credit &amp; Debit Cards, and Netbanking.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                        <input type="checkbox" name="razorpay_enabled" value="1" {{ $settings->razorpay_enabled ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="razorpay_key_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-key text-slate-400 text-[11px]"></i>
                            <span>Razorpay Key ID</span>
                        </label>
                        <input type="text" 
                               id="razorpay_key_id" 
                               name="razorpay_key_id" 
                               placeholder="rzp_live_... or rzp_test_..."
                               value="{{ old('razorpay_key_id', $settings->razorpay_key_id) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                        <span class="text-[11px] text-slate-400">Obtained from Razorpay Dashboard &rarr; Settings &rarr; API Keys</span>
                    </div>

                    <div class="space-y-1.5">
                        <label for="razorpay_key_secret" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-lock text-slate-400 text-[11px]"></i>
                            <span>Razorpay Key Secret</span>
                        </label>
                        <input type="password" 
                               id="razorpay_key_secret" 
                               name="razorpay_key_secret" 
                               placeholder="••••••••••••••••••••••••"
                               value="{{ old('razorpay_key_secret', $settings->razorpay_key_secret) }}"
                               class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono">
                        <span class="text-[11px] text-slate-400">Secret key used strictly for server-side HMAC SHA256 verification</span>
                    </div>

                    <div class="space-y-1.5 sm:col-span-2">
                        <label for="min_donation_amount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-indian-rupee-sign text-slate-400 text-[11px]"></i>
                            <span>Minimum Donation Amount (₹)</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="min_donation_amount" 
                               name="min_donation_amount" 
                               min="1"
                               max="50000"
                               required
                               value="{{ old('min_donation_amount', $settings->min_donation_amount ?: 100) }}"
                               class="w-full sm:w-60 px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 font-mono font-bold">
                        <span class="text-[11px] text-slate-400 block">Default minimum required contribution per transaction (₹100 recommended).</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm shadow-blue-500/20 transition">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    <span>Save &amp; Apply Configuration</span>
                </button>
            </div>
        </form>
    </div>

</x-admin.layout>
