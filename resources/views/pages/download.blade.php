<x-layout 
    title="Download PocketSQL — Official Android APK &amp; Google Play Release"
    description="Download official PocketSQL APK or install via Google Play Store. Verify SHA-256 cryptographic checksums, view release notes, and run an offline SQL server on Android 10+."
    keywords="PocketSQL download, download pocketsql apk, pocketsql apk, pocketsql google play, pocketsql releases, android sql database apk, download pocketsql direct"
>

    <!-- Page Header -->
    <div class="bg-slate-50 border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <div class="inline-flex items-center space-x-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Releases</span>
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-[10px] bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold shadow-xs">
                    <i class="fa-solid fa-cloud-arrow-down text-emerald-600"></i>
                    <span>{{ number_format($totalDownloads) }}+ Verified Downloads</span>
                </span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Downloads &amp; Release Archive</h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Download the official signed Android APK directly or install from the Google Play Store. Every download is cryptographically verifiable.
            </p>
        </div>
    </div>

    <!-- Downloads Container -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
        
        <!-- 1. Latest Release Card (Featured - Max 10px Radius) -->
        <div class="bg-white border-2 border-blue-500 rounded-[10px] p-6 sm:p-8 shadow-sm space-y-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 bg-blue-600 text-white text-[11px] font-bold px-4 py-1 rounded-bl-[10px] uppercase tracking-wider flex items-center space-x-1.5">
                <i class="fa-solid fa-crown text-amber-300 text-[10px]"></i>
                <span>Latest Stable Release</span>
            </div>

            <!-- Version Header Row -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-3">
                        <h2 class="text-3xl font-extrabold text-slate-900">{{ $latestRelease->version ?? 'v1.0.5' }}</h2>
                        <span class="px-2.5 py-0.5 rounded-[8px] bg-blue-50 text-blue-700 text-xs font-mono font-bold border border-blue-200">
                            Build {{ $latestRelease->version_code ?? '11' }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-3 mt-1 text-xs text-slate-500">
                        <span>Released on {{ $latestRelease->release_date ?? 'October 18, 2026' }}</span>
                        <span>•</span>
                        <span class="inline-flex items-center space-x-1 font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-[6px] border border-emerald-100">
                            <i class="fa-solid fa-download text-[10px] text-emerald-600"></i>
                            <span>{{ number_format($latestRelease->downloads_count ?? 842) }} downloads</span>
                        </span>
                    </div>
                </div>

                <!-- Action CTAs with Font Awesome -->
                <div class="flex flex-wrap items-center gap-3">
                    <x-button variant="primary" href="{{ route('download.apk', $latestRelease ? $latestRelease->id : null) }}" class="py-2.5 px-5 text-sm shadow-md">
                        <i class="fa-solid fa-download mr-1.5 text-white"></i>
                        <span>Download APK ({{ $latestRelease->apk_size ?? '12.4 MB' }})</span>
                    </x-button>

                    <x-button variant="secondary" href="{{ $settings->playstore_url ?? 'https://play.google.com/store/apps/details?id=app.pocketsql.database' }}" target="_blank" rel="noopener" class="py-2.5 px-5 text-sm">
                        <i class="fa-brands fa-google-play mr-1.5 text-blue-600"></i>
                        <span>Google Play Store</span>
                    </x-button>
                </div>
            </div>

            <!-- SHA-256 Checksum Box -->
            <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
                <div class="space-y-1 overflow-hidden">
                    <span class="font-bold text-slate-700 uppercase tracking-wider text-[10px] flex items-center space-x-1.5">
                        <i class="fa-solid fa-shield-halved text-slate-500 text-[11px]"></i>
                        <span>SHA-256 Checksum:</span>
                    </span>
                    <div class="font-mono text-slate-600 truncate max-w-xl text-[11px]">
                        {{ $latestRelease->sha256_hash ?? '9b8c73e4a2d109ef78b23c914e67f0821bcfa239d87130284ab9102ef108ca73' }}
                    </div>
                </div>
                <button type="button" 
                        onclick="copyToClipboard('{{ $latestRelease->sha256_hash ?? '9b8c73e4a2d109ef78b23c914e67f0821bcfa239d87130284ab9102ef108ca73' }}', this)"
                        class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-100 rounded-[8px] font-semibold text-slate-700 transition flex items-center space-x-1 flex-shrink-0">
                    <i class="fa-regular fa-copy mr-1 text-slate-500"></i>
                    <span>Copy SHA256</span>
                </button>
            </div>

            <!-- Changelog Accordion -->
            <div class="space-y-2 pt-2 border-t border-slate-100" x-data="{ showChangelog: true }">
                <button type="button" 
                        @click="showChangelog = !showChangelog"
                        class="text-xs font-bold text-slate-900 flex items-center justify-between w-full hover:text-blue-600 transition">
                    <span class="flex items-center space-x-1.5">
                        <i class="fa-solid fa-list-check text-blue-600"></i>
                        <span>What's New in this Release:</span>
                    </span>
                    <span x-text="showChangelog ? 'Hide' : 'Show'" class="text-blue-600 font-normal"></span>
                </button>
                <div x-show="showChangelog" class="text-xs text-slate-600 font-mono leading-relaxed bg-slate-50 p-4 rounded-[8px] whitespace-pre-line border border-slate-200">
{{ $latestRelease->changelog ?? '• Added native analytical window functions.\n• On-device TLS 1.3 self-signed cert generation.' }}
                </div>
            </div>
        </div>

        <!-- 2. System Requirements Card -->
        <section class="space-y-4">
            <h3 class="text-xl font-bold text-slate-900 flex items-center space-x-2">
                <i class="fa-solid fa-laptop-code text-blue-600 text-lg"></i>
                <span>System Compatibility &amp; Requirements</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <x-card class="space-y-2">
                    <div class="text-xs font-bold uppercase tracking-wider text-blue-600 flex items-center space-x-1.5">
                        <i class="fa-brands fa-android text-sm"></i>
                        <span>Android OS</span>
                    </div>
                    <div class="text-lg font-bold text-slate-900">Android 10.0 to 15</div>
                    <p class="text-xs text-slate-500">API Level 29 through API Level 36 supported.</p>
                </x-card>

                <x-card class="space-y-2">
                    <div class="text-xs font-bold uppercase tracking-wider text-emerald-600 flex items-center space-x-1.5">
                        <i class="fa-solid fa-unlock text-sm"></i>
                        <span>Root Access</span>
                    </div>
                    <div class="text-lg font-bold text-slate-900">Not Required (Zero)</div>
                    <p class="text-xs text-slate-500">Runs 100% in unprivileged standard user space.</p>
                </x-card>

                <x-card class="space-y-2">
                    <div class="text-xs font-bold uppercase tracking-wider text-purple-600 flex items-center space-x-1.5">
                        <i class="fa-solid fa-hard-drive text-sm"></i>
                        <span>Storage Footprint</span>
                    </div>
                    <div class="text-lg font-bold text-slate-900">~25 MB Free Space</div>
                    <p class="text-xs text-slate-500">Ultralight binary footprint with memory-mapped caching.</p>
                </x-card>
            </div>
        </section>

        <!-- Single Restrained Sponsor Ad Banner -->
        <x-ad-slot type="horizontal" class="my-6" />

        <!-- 3. Previous Releases Table -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-900 flex items-center space-x-2">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600 text-lg"></i>
                    <span>Historical Release Archive</span>
                </h3>
                <span class="text-xs text-slate-500 font-mono">Total Builds: {{ count($previousReleases) + 1 }}</span>
            </div>

            <div class="border border-slate-200 rounded-[10px] overflow-hidden bg-white shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs min-w-[620px]">
                        <thead class="bg-slate-50 border-b border-slate-200 font-bold uppercase text-slate-700">
                            <tr>
                                <th class="px-5 py-3.5">Version</th>
                                <th class="px-5 py-3.5">Release Date</th>
                                <th class="px-5 py-3.5">APK Size</th>
                                <th class="px-5 py-3.5">Downloads</th>
                                <th class="px-5 py-3.5 hidden md:table-cell">SHA-256</th>
                                <th class="px-5 py-3.5 text-right">Download</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600 font-mono">
                            @forelse($previousReleases as $rel)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3.5 font-bold text-slate-900">
                                        <div class="flex items-center space-x-1.5">
                                            <i class="fa-brands fa-android text-emerald-600"></i>
                                            <span>{{ $rel->version }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 font-sans">{{ $rel->release_date }}</td>
                                    <td class="px-5 py-3.5">{{ $rel->apk_size }}</td>
                                    <td class="px-5 py-3.5 font-sans">
                                        <span class="inline-flex items-center space-x-1 text-slate-600 font-semibold">
                                            <i class="fa-solid fa-download text-[10px] text-slate-400"></i>
                                            <span>{{ number_format($rel->downloads_count) }}</span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 hidden md:table-cell text-[11px] truncate max-w-xs">{{ substr($rel->sha256_hash, 0, 16) }}...</td>
                                    <td class="px-5 py-3.5 text-right font-sans">
                                        <a href="{{ route('download.apk', $rel->id) }}" class="inline-flex items-center space-x-1 text-blue-600 hover:text-blue-800 font-bold text-xs bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-[6px] transition">
                                            <i class="fa-solid fa-download text-[11px]"></i>
                                            <span>Download APK</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-6 text-center text-slate-500 font-sans">
                                        No prior archival builds available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 4. Installation & Verification Guide -->
        <section class="p-6 rounded-[10px] bg-slate-50 border border-slate-200 space-y-4 text-sm text-slate-600">
            <h3 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                <i class="fa-solid fa-circle-info text-blue-600"></i>
                <span>APK Sideloading &amp; Verification Guide</span>
            </h3>
            <ol class="list-decimal pl-5 space-y-2 text-xs leading-relaxed">
                <li>Download the APK file onto your Android device via browser.</li>
                <li>When prompted by Android, tap <strong>Settings</strong> and enable <em>"Allow from this source"</em>.</li>
                <li>Tap <strong>Install</strong>. Once completed, launch PocketSQL from your app drawer.</li>
                <li>(Optional) Verify the SHA-256 checksum on your computer using <code class="bg-white px-1.5 py-0.5 rounded border border-slate-300 font-mono">sha256sum PocketSQL-{{ $latestRelease->version ?? $settings->current_version }}.apk</code>.</li>
            </ol>
        </section>

    </div>

</x-layout>
