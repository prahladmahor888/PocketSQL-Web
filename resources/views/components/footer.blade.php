<footer class="bg-white border-t border-slate-200 pt-16 pb-12 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
            <!-- Brand & Mission Column -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="PocketSQL" class="h-10 w-10 rounded-[10px] object-cover shadow-sm border border-slate-200">
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">
                        Pocket<span class="text-blue-600">SQL</span>
                    </span>
                </a>
                <p class="text-sm text-slate-500 leading-relaxed max-w-sm">
                    PocketSQL is an open-source, high-performance embedded SQL database engine and persistent REST server for Android. Built for students, backend engineers, and offline IoT prototyping.
                </p>
                <div class="flex flex-wrap items-center gap-2 pt-2">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-[10px] text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i class="fa-solid fa-certificate text-emerald-600 mr-1.5"></i>
                        MIT Licensed
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-[10px] text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        🇮🇳 Made in India
                    </span>
                    <a href="{{ route('donate') }}" 
                       class="inline-flex items-center px-2.5 py-1 rounded-[10px] text-xs font-semibold bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 transition">
                        <i class="fa-solid fa-heart text-blue-600 mr-1.5"></i>
                        <span>Donate</span>
                    </a>
                </div>
            </div>

            <!-- Product Links -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Product</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('features') }}" class="text-slate-600 hover:text-blue-600 transition">Engine Features</a></li>
                    <li><a href="{{ route('docs') }}" class="text-slate-600 hover:text-blue-600 transition">HTTP REST API</a></li>
                    <li><a href="{{ route('download') }}" class="text-slate-600 hover:text-blue-600 transition">Download Releases</a></li>
                    <li><a href="{{ route('download.apk') }}" class="text-slate-600 hover:text-blue-600 transition">Direct APK ({{ $settings->current_version }})</a></li>
                    <li><a href="{{ $settings->playstore_url ?? 'https://play.google.com/store/apps/details?id=app.pocketsql.database' }}" target="_blank" rel="noopener" class="text-slate-600 hover:text-blue-600 transition">Google Play Store</a></li>
                </ul>
            </div>

            <!-- Community & Resources -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Community</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="text-slate-600 hover:text-blue-600 transition">About the Project</a></li>
                    <li>
                        <a href="{{ route('donate') }}" class="text-slate-600 hover:text-blue-600 transition flex items-center space-x-1.5">
                            <i class="fa-solid fa-heart text-blue-600 text-xs"></i>
                            <span>Donate &amp; Sponsors</span>
                        </a>
                    </li>
                    <li><a href="{{ route('faq') }}" class="text-slate-600 hover:text-blue-600 transition">Frequently Asked</a></li>
                    <li><a href="{{ route('contact') }}" class="text-slate-600 hover:text-blue-600 transition">Contact &amp; Support</a></li>
                    <li><a href="{{ $settings->github_repo_url ?? 'https://github.com/pocketsql/pocketsql' }}" target="_blank" rel="noopener" class="text-slate-600 hover:text-blue-600 transition">GitHub Repository</a></li>
                </ul>
            </div>

            <!-- Legal & Trust -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Legal &amp; Trust</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('legal.privacy') }}" class="text-slate-600 hover:text-blue-600 transition">Privacy Policy</a></li>
                    <li><a href="{{ route('legal.terms') }}" class="text-slate-600 hover:text-blue-600 transition">Terms of Service</a></li>
                </ul>
            </div>
        </div>



        <!-- Bottom Divider & Copyright -->
        <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} PocketSQL Open Source Project. All rights reserved.</p>
            <p class="flex items-center space-x-2">
                <span>Zero Cloud Tracking • 100% Offline-First Engine</span>
            </p>
        </div>
    </div>
</footer>
