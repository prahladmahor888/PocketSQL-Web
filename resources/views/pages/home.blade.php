<x-layout 
    title="PocketSQL — Embedded SQL Database &amp; REST API Server for Android (Zero Root)"
    description="Run a full-featured, zero-root SQL database engine and background REST/TLS API server directly on any Android device. 100% offline-first, microsecond latency, zero cloud dependencies. Download PocketSQL today."
    keywords="PocketSQL, pocketsql, pocketsql android, pocketsql apk, pocketsql download, android sql database, run mysql on android, android rest api server, offline sql database, zero root sqlite server, termux mysql alternative, mobile sql server, android database daemon, sqlite android terminal"
    :faqItems="$topFaqs"
>

    <!-- 1. HERO SECTION (FULL WIDTH AUTO-SLIDING BACKGROUND IMAGES TUCKED UNDER NAVBAR) -->
    <section class="-mt-20 pt-28 pb-16 lg:pt-36 lg:pb-24 relative overflow-hidden bg-slate-950 text-white border-b border-slate-800 shadow-[inset_0_14px_28px_rgba(0,0,0,0.65)]"
             x-data="{
                active: 0,
                timer: null,
                slides: [
                    {
                        image: '{{ asset('images/hero/hackathon_developer.jpg') }}',
                        title: 'Offline Team Prototyping'
                    },
                    {
                        image: '{{ asset('images/hero/coding_workspace.jpg') }}',
                        title: 'Laptop & Script Integration'
                    },
                    {
                        image: '{{ asset('images/hero/analytics_dashboard.jpg') }}',
                        title: 'Real-Time Data Visualization'
                    }
                ],
                startTimer() {
                    this.stopTimer();
                    this.timer = setInterval(() => {
                        this.active = (this.active + 1) % this.slides.length;
                    }, 4000);
                },
                stopTimer() {
                    if (this.timer) clearInterval(this.timer);
                }
             }"
             x-init="startTimer()"
             @mouseenter="stopTimer()"
             @mouseleave="startTimer()">

        <!-- FULL-WIDTH AUTO-SLIDING BACKGROUND IMAGES (EDGE TO EDGE BEHIND TEXT) -->
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="active === index"
                     x-transition:enter="transition-opacity duration-700 ease-out"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity duration-700 ease-in"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 w-full h-full">
                    <img :src="slide.image" 
                         :alt="slide.title" 
                         class="w-full h-full object-cover object-center">
                </div>
            </template>

            <!-- Nav Ke Niche Daba Hua Shadow (Recessed Top Shadow Under Navbar) -->
            <div class="absolute top-0 inset-x-0 h-20 bg-gradient-to-b from-black/80 via-black/40 to-transparent z-10"></div>

            <!-- Clean Overlay: High Image Visibility on Right, Readable Gradient on Left Text -->
            <div class="absolute inset-0 bg-slate-950/25 bg-gradient-to-r from-slate-950/85 via-slate-950/40 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
        </div>

        <!-- HERO CONTENT IN FOREGROUND (ON TOP OF FULL-WIDTH BACKGROUND SLIDER) -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl space-y-6 text-center lg:text-left py-4">
                
                <!-- Version Badge -->
                <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-[10px] bg-slate-900/75 border border-white/20 text-blue-300 text-xs font-semibold backdrop-blur-md shadow-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>{{ $settings->current_version }} Released</span>
                    <span class="text-white/30">|</span>
                    <span>{{ number_format($totalDownloads) }}+ Downloads</span>
                    <span class="text-white/30">|</span>
                    <span class="text-emerald-300">100% Open Source</span>
                </div>

                <!-- Main Headline (Optimized for 'PocketSQL' and 'Run MySQL Database on Android') -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.15] drop-shadow-md">
                    PocketSQL — Run Full <span class="text-blue-400 underline decoration-blue-500/40 decoration-wavy underline-offset-8">MySQL</span> Database on Your Android Device.
                </h1>

                <!-- Subtext -->
                <p class="text-base sm:text-lg lg:text-xl text-slate-200 leading-relaxed max-w-2xl mx-auto lg:mx-0 drop-shadow-sm">
                    PocketSQL is an embedded, pure-Java SQL database engine with an interactive terminal CLI and a persistent background HTTP/TLS REST API server. Connect from your laptop, IoT sensors, or scripts. <strong class="text-white">Zero root required.</strong>
                </p>

                <!-- CTAs with Font Awesome Icons -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3.5 pt-2">
                    <x-button variant="primary" href="{{ $settings->playstore_url ?? 'https://play.google.com/store/apps/details?id=app.pocketsql.database' }}" target="_blank" rel="noopener" class="py-3 px-6 text-base shadow-xl shadow-blue-500/40">
                        <i class="fa-brands fa-google-play mr-2 text-white"></i>
                        Get on Google Play
                    </x-button>

                    <x-button variant="secondary" href="{{ route('download.apk') }}" class="py-3 px-6 text-base !bg-white !text-slate-900 hover:!bg-slate-100 shadow-xl">
                        <i class="fa-solid fa-download mr-2 text-blue-600"></i>
                        Direct APK ({{ $settings->apk_size }})
                    </x-button>

                    <x-button variant="secondary" href="{{ route('docs') }}" class="py-3 px-5 text-sm !bg-slate-900/80 !text-white !border-white/25 hover:!bg-slate-800 backdrop-blur-md shadow-md">
                        <i class="fa-solid fa-book-open mr-1.5 text-blue-400"></i>
                        API Docs &rarr;
                    </x-button>

                    <x-button variant="secondary" href="{{ route('donate') }}" class="py-3 px-5 text-sm !bg-slate-900/80 !text-white !border-white/25 hover:!bg-slate-800 backdrop-blur-md shadow-md">
                        <i class="fa-solid fa-heart mr-1.5 text-blue-400"></i>
                        Donate
                    </x-button>
                </div>

                <!-- Highlights Bar -->
                <div class="pt-6 grid grid-cols-2 sm:grid-cols-4 gap-6 border-t border-white/20 max-w-2xl mx-auto lg:mx-0 text-left">
                    <div>
                        <div class="text-xl sm:text-2xl font-extrabold text-white drop-shadow-md">&lt; 2 ms</div>
                        <div class="text-xs text-slate-300 font-medium">Query Latency</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-extrabold text-white drop-shadow-md">40+</div>
                        <div class="text-xs text-slate-300 font-medium">System Tables</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-extrabold text-white drop-shadow-md">{{ number_format($totalDownloads) }}+</div>
                        <div class="text-xs text-slate-300 font-medium">Downloads</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-extrabold text-emerald-400 drop-shadow-md">100%</div>
                        <div class="text-xs text-slate-300 font-medium">Offline &amp; Private</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Top Ad Banner Directly Below Hero Section -->
    <div class="bg-slate-50/70 border-b border-slate-200/80 py-4">
        <x-ad-slot type="horizontal" class="my-0" />
    </div>

    <!-- 2. QUICK FEATURES GRID (6 CARDS - MAX 10PX RADIUS) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3 reveal-on-scroll">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-[10px] border border-blue-200">Engine Architecture</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Engineered for Pure Performance on Mobile</h2>
                <p class="text-base text-slate-600">
                    PocketSQL packs enterprise database capabilities into a lightweight Android application designed to execute natively without cloud dependencies.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Feature 1 -->
                <x-card class="space-y-3 reveal-on-scroll reveal-delay-1 hover-lift">
                    <div class="w-10 h-10 rounded-[10px] bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Embedded SQL Engine</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Full SQL syntax execution supporting multi-table `JOINs`, analytical window functions (`PERCENT_RANK`, `NTILE`), aggregate computations, and subqueries.
                    </p>
                </x-card>

                <!-- Feature 2 -->
                <x-card class="space-y-3 reveal-on-scroll reveal-delay-2 hover-lift">
                    <div class="w-10 h-10 rounded-[10px] bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-base transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-terminal"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Interactive Terminal CLI</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Built-in console rendered in JetBrains Mono with live keyword suggestions, history navigation, multi-line query buffers, and 200+ help topics.
                    </p>
                </x-card>

                <!-- Feature 3 -->
                <x-card class="space-y-3 reveal-on-scroll reveal-delay-3 hover-lift">
                    <div class="w-10 h-10 rounded-[10px] bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-base transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-network-wired"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Background REST API</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Persistent Android Foreground Service listening on port 8080 (auto-failover up to 8099). Query your mobile databases from curl, Python, or Web.
                    </p>
                </x-card>

                <!-- Feature 4 -->
                <x-card class="space-y-3 reveal-on-scroll reveal-delay-1 hover-lift">
                    <div class="w-10 h-10 rounded-[10px] bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-base transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-table-cells"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">40+ MySQL System Tables</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Full metadata introspection emulating `information_schema`, `performance_schema`, `mysql`, and `sys` databases for standard database drivers.
                    </p>
                </x-card>

                <!-- Feature 5 -->
                <x-card class="space-y-3 reveal-on-scroll reveal-delay-2 hover-lift">
                    <div class="w-10 h-10 rounded-[10px] bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-base transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-file-export"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Multi-Format Exporter</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Export tables seamlessly to SQL DUMP scripts, Excel XLSX spreadsheets, ZIP-compressed CSV archives, or encrypted SQLite `.db` binaries.
                    </p>
                </x-card>

                <!-- Feature 6 -->
                <x-card class="space-y-3 reveal-on-scroll reveal-delay-3 hover-lift">
                    <div class="w-10 h-10 rounded-[10px] bg-cyan-50 text-cyan-600 flex items-center justify-center font-bold text-base transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">On-Device TLS 1.3</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Generate self-signed X.509 SSL certificates on the phone for encrypted HTTPS traffic. Granular Bearer API tokens protect each database.
                    </p>
                </x-card>

            </div>

            <div class="text-center mt-10 reveal-on-scroll">
                <a href="{{ route('features') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-transform hover:translate-x-1 duration-200">
                    Explore all technical specifications &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 2.5 HOW POCKETSQL WORKS: 3-STEP ZERO-SETUP ARCHITECTURE (HIGH-INTENT SEO CONTENT) -->
    <section class="py-20 bg-slate-900 text-white border-y border-slate-800 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-12">
            
            <div class="text-center max-w-3xl mx-auto space-y-3 reveal-on-scroll">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-400 bg-blue-950/80 px-3.5 py-1.5 rounded-[10px] border border-blue-800/80">Workflow &amp; Architecture</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    How PocketSQL Turns Any Android Phone into a Database Server
                </h2>
                <p class="text-base text-slate-300 leading-relaxed">
                    Unlike heavy Termux environments or complex Linux chroots, PocketSQL runs natively on Android ART with zero root privileges, providing an instant SQL endpoint in seconds.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Step 1 -->
                <div class="bg-slate-950/60 border border-slate-800 rounded-[10px] p-6 space-y-4 hover-lift reveal-on-scroll reveal-delay-1 relative">
                    <div class="w-12 h-12 rounded-[10px] bg-blue-600/20 text-blue-400 border border-blue-500/30 flex items-center justify-center font-extrabold text-lg">
                        01
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-white">One-Tap Install (Zero Root)</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Install the official signed APK or install via Google Play. PocketSQL executes strictly within Android's sandboxed user space. No Magisk, SuperSU, proot, or custom ROMs needed.
                        </p>
                    </div>
                    <div class="pt-2 text-xs font-mono text-emerald-400 flex items-center space-x-2">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                        <span>Android 10 - 15 Verified</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-slate-950/60 border border-slate-800 rounded-[10px] p-6 space-y-4 hover-lift reveal-on-scroll reveal-delay-2 relative">
                    <div class="w-12 h-12 rounded-[10px] bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-extrabold text-lg">
                        02
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-white">Persistent Foreground Daemon</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Launch the Background HTTP/TLS REST server on port 8080 (auto-failover up to 8099). An Android Foreground Service keeps the database active even when the screen is locked or idle.
                        </p>
                    </div>
                    <div class="pt-2 text-xs font-mono text-blue-400 flex items-center space-x-2">
                        <i class="fa-solid fa-bolt text-blue-400"></i>
                        <span>Survives Android Doze Mode</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-slate-950/60 border border-slate-800 rounded-[10px] p-6 space-y-4 hover-lift reveal-on-scroll reveal-delay-3 relative">
                    <div class="w-12 h-12 rounded-[10px] bg-purple-600/20 text-purple-400 border border-purple-500/30 flex items-center justify-center font-extrabold text-lg">
                        03
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-white">Query via CLI, LAN, or Scripts</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Run queries on-device with the JetBrains Mono terminal CLI, or connect external laptops, IoT boards, and scripts over local Wi-Fi or phone hotspot using JSON API requests.
                        </p>
                    </div>
                    <div class="pt-2 text-xs font-mono text-purple-400 flex items-center space-x-2">
                        <i class="fa-solid fa-network-wired text-purple-400"></i>
                        <span>Python • JS • cURL • Java • PHP</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. APP SCREENSHOTS SHOWCASE (REAL MOBILE SCREENS - CUSTOMIZABLE FROM ADMIN) -->
    <section class="py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4 reveal-on-scroll">
                <div class="space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Visual Interface</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Actual App Screenshots Showcase</h2>
                    <p class="text-sm text-slate-600">
                        Inspecting the real PocketSQL user experience: interactive console, server daemon, batch insert, and templates.
                    </p>
                </div>
                <div class="text-xs text-slate-500 font-medium">
                    <span class="inline-flex items-center space-x-1.5 px-3 py-1 bg-white border border-slate-200 rounded-[8px] text-slate-600 shadow-xs">
                        <i class="fa-solid fa-mobile-screen text-blue-600"></i>
                        <span>Native Android 10-15 UI</span>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($screenshots as $index => $screenshot)
                    <div class="bg-white border border-slate-200 rounded-[10px] overflow-hidden shadow-sm hover-lift hover:shadow-lg transition flex flex-col justify-between reveal-on-scroll reveal-delay-{{ ($index % 4) + 1 }}">
                        
                        <!-- Phone Mockup Container (Realistic 9:18 Screen Ratio) -->
                        <div class="aspect-[9/18] bg-black relative overflow-hidden flex items-center justify-center p-2 group">
                            <img src="{{ asset($screenshot->image_path) }}" 
                                 alt="{{ $screenshot->title }}" 
                                 class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-[1.03]">
                        </div>

                        <!-- Caption -->
                        <div class="p-4 space-y-1.5 bg-white border-t border-slate-100">
                            <h4 class="text-sm font-bold text-slate-900 line-clamp-1">{{ $screenshot->title }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $screenshot->subtitle }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 3.5 ENTERPRISE SQL ENGINE CAPABILITIES & LANGUAGE SPECIFICATION (SEO CONTENT EXPANSION) -->
    <section class="py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center max-w-3xl mx-auto space-y-3 reveal-on-scroll">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">SQL Dialect &amp; Capabilities</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Full Relational SQL Standard in Your Pocket
                </h2>
                <p class="text-base text-slate-600 leading-relaxed">
                    PocketSQL isn't a stripped-down key-value store or rudimentary viewer. It provides a complete relational engine capable of executing complex analytical queries, transaction workflows, and data transformations.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Spec 1: Relational Joins & Subqueries -->
                <div class="bg-white border border-slate-200 rounded-[10px] p-6 space-y-3 hover-lift reveal-on-scroll reveal-delay-1 shadow-2xs">
                    <div class="w-10 h-10 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-code-merge"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Relational Joins &amp; Subqueries</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Execute multi-table `INNER JOIN`, `LEFT OUTER JOIN`, `CROSS JOIN`, correlated subqueries, and `UNION ALL` statements. Filter with complex boolean expressions and regex patterns.
                    </p>
                    <div class="font-mono text-[11px] text-blue-700 bg-blue-50/70 p-2.5 rounded-[8px] border border-blue-100">
                        SELECT u.id, o.sum FROM users u JOIN (SELECT user_id, SUM(total) as sum FROM orders GROUP BY user_id) o ON u.id = o.user_id;
                    </div>
                </div>

                <!-- Spec 2: Window Functions -->
                <div class="bg-white border border-slate-200 rounded-[10px] p-6 space-y-3 hover-lift reveal-on-scroll reveal-delay-2 shadow-2xs">
                    <div class="w-10 h-10 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Analytical Window Functions</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Compute running totals, rankings, and lead/lag values using `ROW_NUMBER()`, `RANK()`, `DENSE_RANK()`, `NTILE(n)`, `LEAD()`, and `LAG()` over partition windows without client-side looping.
                    </p>
                    <div class="font-mono text-[11px] text-emerald-700 bg-emerald-50/70 p-2.5 rounded-[8px] border border-emerald-100">
                        SELECT id, score, NTILE(4) OVER (ORDER BY score DESC) as quartile FROM leaderboard;
                    </div>
                </div>

                <!-- Spec 3: Full ACID Transactions -->
                <div class="bg-white border border-slate-200 rounded-[10px] p-6 space-y-3 hover-lift reveal-on-scroll reveal-delay-3 shadow-2xs">
                    <div class="w-10 h-10 rounded-[8px] bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">ACID Transactions &amp; WAL</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Execute multi-statement transactions with `BEGIN TRANSACTION`, `SAVEPOINT`, `ROLLBACK`, and `COMMIT`. Write-Ahead Logging (WAL) ensures zero data corruption even if phone battery dies.
                    </p>
                    <div class="font-mono text-[11px] text-purple-700 bg-purple-50/70 p-2.5 rounded-[8px] border border-purple-100">
                        BEGIN; UPDATE accounts SET bal = bal - 500 WHERE id = 1; UPDATE accounts SET bal = bal + 500 WHERE id = 2; COMMIT;
                    </div>
                </div>

                <!-- Spec 4: MySQL System Tables -->
                <div class="bg-white border border-slate-200 rounded-[10px] p-6 space-y-3 hover-lift reveal-on-scroll reveal-delay-1 shadow-2xs">
                    <div class="w-10 h-10 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">40+ MySQL System Tables</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Emulates `information_schema.tables`, `information_schema.columns`, `information_schema.schemata`, and system stats so database introspection tools and drivers work seamlessly.
                    </p>
                    <div class="font-mono text-[11px] text-amber-700 bg-amber-50/70 p-2.5 rounded-[8px] border border-amber-100">
                        SELECT table_name, table_rows FROM information_schema.tables WHERE table_schema = 'main';
                    </div>
                </div>

                <!-- Spec 5: On-Device TLS 1.3 & Tokens -->
                <div class="bg-white border border-slate-200 rounded-[10px] p-6 space-y-3 hover-lift reveal-on-scroll reveal-delay-2 shadow-2xs">
                    <div class="w-10 h-10 rounded-[8px] bg-cyan-50 text-cyan-600 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">On-Device TLS 1.3 &amp; API Keys</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Generate local X.509 certificates directly on Android for encrypted HTTPS connections. Protect access to each database using granular Bearer tokens backed by Android Keystore.
                    </p>
                    <div class="font-mono text-[11px] text-cyan-700 bg-cyan-50/70 p-2.5 rounded-[8px] border border-cyan-100">
                        Authorization: Bearer psql_live_sec_a7f920bc48e...
                    </div>
                </div>

                <!-- Spec 6: High-Speed Batch Import/Export -->
                <div class="bg-white border border-slate-200 rounded-[10px] p-6 space-y-3 hover-lift reveal-on-scroll reveal-delay-3 shadow-2xs">
                    <div class="w-10 h-10 rounded-[8px] bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-file-zipper"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Multi-Format Batch Exporter</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Seamlessly import large CSVs and dump entire databases into SQL DUMP scripts, Excel XLSX spreadsheets, ZIP compressed archives, or encrypted SQLCipher SQLite `.db` binaries.
                    </p>
                    <div class="font-mono text-[11px] text-rose-700 bg-rose-50/70 p-2.5 rounded-[8px] border border-rose-100">
                        .dump table_name --format=xlsx --compress=gzip
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. INTERACTIVE CLIENT CONNECTOR TABS (PYTHON, JS, JAVA, PHP, CURL) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-5 space-y-5 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-[10px] border border-blue-200">Connect in Seconds</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        One Simple REST API. Any Programming Language.
                    </h2>
                    <p class="text-base text-slate-600 leading-relaxed">
                        PocketSQL exposes standard HTTP and TLS endpoints. Issue SQL queries with JSON request payloads and receive clean, structured JSON columns and rows in return.
                    </p>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center space-x-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                            <span>Standard `POST /api/query` HTTP contract</span>
                        </li>
                        <li class="flex items-center space-x-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                            <span>Database-scoped Bearer token authentication</span>
                        </li>
                        <li class="flex items-center space-x-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                            <span>Microsecond execution latency reporting</span>
                        </li>
                    </ul>
                    <div class="pt-2">
                        <x-button variant="primary" href="{{ route('docs') }}">
                            Explore Full API Specification &rarr;
                        </x-button>
                    </div>
                </div>

                <!-- Code Tabs Container (Alpine.js) -->
                <div class="lg:col-span-7 reveal-on-scroll reveal-delay-2" x-data="{ activeTab: 'python' }">
                    <div class="bg-slate-900 border border-slate-800 rounded-[10px] shadow-xl overflow-hidden hover-lift">
                        
                        <!-- Tabs Header -->
                        <div class="flex items-center justify-between px-4 py-2.5 bg-slate-950 border-b border-slate-800">
                            <div class="flex items-center space-x-1 sm:space-x-2 overflow-x-auto no-scrollbar py-0.5">
                                @foreach($codeSnippets as $snippet)
                                    <button type="button"
                                            @click="activeTab = '{{ $snippet->language }}'"
                                            :class="activeTab === '{{ $snippet->language }}' ? 'bg-blue-600 text-white font-semibold shadow-xs scale-100' : 'text-slate-400 hover:text-white hover:bg-slate-800'"
                                            class="px-3 py-1.5 text-xs rounded-[8px] transition font-mono whitespace-nowrap flex-shrink-0 active:scale-95">
                                        {{ $snippet->title }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Quick Copy Current Snippet Button -->
                            <button type="button" 
                                    @click="
                                        let currentEl = document.querySelector('#snippet-' + activeTab);
                                        if (currentEl) copyToClipboard(currentEl.innerText, $el);
                                    "
                                    class="inline-flex items-center px-2.5 py-1 text-xs font-mono text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 rounded-[8px] transition ml-2 flex-shrink-0 border border-slate-700 active:scale-95">
                                <i class="fa-regular fa-copy mr-1 text-slate-400"></i>
                                <span>Copy</span>
                            </button>
                        </div>

                        <!-- Code Content Box -->
                        <div class="p-5 font-mono text-xs leading-relaxed overflow-x-auto dark-scrollbar text-slate-200 bg-slate-900 min-h-[220px]">
                            @foreach($codeSnippets as $snippet)
                                <div x-show="activeTab === '{{ $snippet->language }}'" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-cloak 
                                     id="snippet-{{ $snippet->language }}">
                                    <pre class="font-mono"><code>{{ $snippet->code_content }}</code></pre>
                                </div>
                            @endforeach
                        </div>

                        <!-- Footer Info bar inside Code Card -->
                        <div class="px-5 py-2.5 bg-slate-950 border-t border-slate-800 text-[11px] font-mono text-slate-400 flex items-center justify-between">
                            <span>Target: <span class="text-emerald-400">POST http://&lt;phone-ip&gt;:8080/api/query</span></span>
                            <span>Status: 200 OK</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Single Restrained Sponsor Ad Banner -->
    <x-ad-slot type="horizontal" />

    <!-- 4.5 SEO SECTION: ARCHITECTURE COMPARISON TABLE (TARGETING SEARCH INTENT) -->
    <section class="py-20 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center max-w-3xl mx-auto space-y-3 reveal-on-scroll">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-[10px] border border-blue-200">Comparative Analysis</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Why Developers Choose PocketSQL for Android
                </h2>
                <p class="text-sm sm:text-base text-slate-600">
                    See how PocketSQL's embedded pure-Java SQL architecture eliminates root requirements, complex package setups, and remote cloud latency.
                </p>
            </div>

            <div class="bg-white border border-slate-200 rounded-[10px] shadow-sm overflow-hidden reveal-on-scroll reveal-delay-1 hover-lift">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs min-w-[650px]">
                        <thead class="bg-slate-900 text-white font-mono uppercase text-[11px]">
                            <tr>
                                <th class="py-4 px-5">Capability / Feature</th>
                                <th class="py-4 px-5 bg-blue-600 text-white font-bold">PocketSQL</th>
                                <th class="py-4 px-5">Termux + MariaDB</th>
                                <th class="py-4 px-5">Cloud DBs (Supabase)</th>
                                <th class="py-4 px-5">Basic SQLite Viewers</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-5 font-semibold text-slate-900">Root Access Required?</td>
                                <td class="py-3.5 px-5 bg-blue-50/50 font-bold text-emerald-600">
                                    <i class="fa-solid fa-circle-check mr-1.5"></i>Zero Root
                                </td>
                                <td class="py-3.5 px-5 text-amber-600">No (proot setup)</td>
                                <td class="py-3.5 px-5 text-emerald-600">No</td>
                                <td class="py-3.5 px-5 text-emerald-600">No</td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-5 font-semibold text-slate-900">Background REST/TLS API Daemon</td>
                                <td class="py-3.5 px-5 bg-blue-50/50 font-bold text-emerald-600">
                                    <i class="fa-solid fa-circle-check mr-1.5"></i>Built-in Daemon
                                </td>
                                <td class="py-3.5 px-5 text-red-500">Requires manual script</td>
                                <td class="py-3.5 px-5 text-emerald-600">Cloud REST</td>
                                <td class="py-3.5 px-5 text-red-500">None (UI Only)</td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-5 font-semibold text-slate-900">Setup Time</td>
                                <td class="py-3.5 px-5 bg-blue-50/50 font-bold text-blue-600">Instant (1 tap)</td>
                                <td class="py-3.5 px-5 text-slate-500">20-40 minutes</td>
                                <td class="py-3.5 px-5 text-slate-500">5-10 minutes</td>
                                <td class="py-3.5 px-5 text-blue-600">Instant</td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-5 font-semibold text-slate-900">100% Offline / Zero Wi-Fi Needed</td>
                                <td class="py-3.5 px-5 bg-blue-50/50 font-bold text-emerald-600">
                                    <i class="fa-solid fa-circle-check mr-1.5"></i>Yes (Air-Gapped)
                                </td>
                                <td class="py-3.5 px-5 text-emerald-600">Yes</td>
                                <td class="py-3.5 px-5 text-red-500 font-bold">Fails without Internet</td>
                                <td class="py-3.5 px-5 text-emerald-600">Yes</td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-5 font-semibold text-slate-900">Android Doze Mode Survival</td>
                                <td class="py-3.5 px-5 bg-blue-50/50 font-bold text-emerald-600">
                                    <i class="fa-solid fa-circle-check mr-1.5"></i>Foreground Service
                                </td>
                                <td class="py-3.5 px-5 text-amber-600">Often killed by OS</td>
                                <td class="py-3.5 px-5 text-slate-500">N/A</td>
                                <td class="py-3.5 px-5 text-slate-500">N/A</td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-5 font-semibold text-slate-900">Battery &amp; RAM Footprint</td>
                                <td class="py-3.5 px-5 bg-blue-50/50 font-bold text-emerald-600">&lt; 35 MB RAM</td>
                                <td class="py-3.5 px-5 text-red-500">250+ MB RAM</td>
                                <td class="py-3.5 px-5 text-slate-500">Low (client SDK)</td>
                                <td class="py-3.5 px-5 text-emerald-600">&lt; 30 MB RAM</td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-5 font-semibold text-slate-900">Analytical Window Functions</td>
                                <td class="py-3.5 px-5 bg-blue-50/50 font-bold text-emerald-600">
                                    <i class="fa-solid fa-circle-check mr-1.5"></i>Full Support
                                </td>
                                <td class="py-3.5 px-5 text-emerald-600">Supported</td>
                                <td class="py-3.5 px-5 text-emerald-600">Supported</td>
                                <td class="py-3.5 px-5 text-amber-600">Limited</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Developer Use Cases Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-6">
                <div class="bg-white p-5 rounded-[10px] border border-slate-200 shadow-xs space-y-2 reveal-on-scroll reveal-delay-1 hover-lift">
                    <div class="w-10 h-10 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-base">
                        <i class="fa-solid fa-wifi-slash"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Offline Field Operations</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Execute full SQL logging in remote, subterranean, or disaster response zones without reliance on external cellular towers or cloud availability.
                    </p>
                </div>

                <div class="bg-white p-5 rounded-[10px] border border-slate-200 shadow-xs space-y-2 reveal-on-scroll reveal-delay-2 hover-lift">
                    <div class="w-10 h-10 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-base">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Hackathons &amp; Prototyping</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Turn any spare Android phone into a shared team database. Connect laptops via local Wi-Fi or hotspot and start querying in seconds.
                    </p>
                </div>

                <div class="bg-white p-5 rounded-[10px] border border-slate-200 shadow-xs space-y-2 reveal-on-scroll reveal-delay-3 hover-lift">
                    <div class="w-10 h-10 rounded-[8px] bg-purple-50 text-purple-600 flex items-center justify-center text-base">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">IoT Local Edge Hub</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Aggregate sensor telemetry from ESP32, Arduino, and Raspberry Pi devices into SQLite tables directly via HTTP POST endpoints.
                    </p>
                </div>

                <div class="bg-white p-5 rounded-[10px] border border-slate-200 shadow-xs space-y-2 reveal-on-scroll reveal-delay-4 hover-lift">
                    <div class="w-10 h-10 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center text-base">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Academic Computer Science</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Students can practice complex SQL joins, constraints, triggers, and transactions directly on mobile hardware without requiring PC access.
                    </p>
                </div>
            </div>

            <!-- 4.7 QUICK DEVELOPER INTEGRATION & NETWORKING GUIDE (SEO CONTENT EXPANSION) -->
            <div class="mt-16 bg-white border border-slate-200 rounded-[10px] p-6 sm:p-8 space-y-6 shadow-xs reveal-on-scroll hover-lift">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                    <div class="space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-[10px] border border-blue-200">Zero Cloud Setup</span>
                        <h3 class="text-2xl font-extrabold text-slate-900">How to Connect to PocketSQL from Any Machine</h3>
                    </div>
                    <div class="flex items-center space-x-2 text-xs font-mono text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-[8px] border border-emerald-200 w-fit">
                        <i class="fa-solid fa-wifi"></i>
                        <span>Zero Internet / Wi-Fi Hotspot Friendly</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-slate-600">
                    <div class="space-y-2">
                        <div class="font-bold text-slate-900 flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                            <span>Connect to Same Network</span>
                        </div>
                        <p class="text-xs leading-relaxed text-slate-500">
                            Connect your laptop or microcontroller to the same Wi-Fi router, or simply turn on your phone's personal hotspot and connect your development machine directly. No active internet connection is required.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <div class="font-bold text-slate-900 flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                            <span>Inspect IP &amp; Port on Phone</span>
                        </div>
                        <p class="text-xs leading-relaxed text-slate-500">
                            Open the PocketSQL app and tap <strong>Start API Server</strong>. The app immediately displays your phone's local network IP address (e.g., <code class="text-blue-600 bg-blue-50 px-1 py-0.5 rounded">192.168.1.100:8080</code>) and your scoped Bearer token.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <div class="font-bold text-slate-900 flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">3</span>
                            <span>Query from Code or Terminal</span>
                        </div>
                        <p class="text-xs leading-relaxed text-slate-500">
                            Send JSON payloads with standard HTTP POST requests from Python scripts, Node.js backends, Go microservices, Postman, or cURL. Receive clean JSON arrays with column schemas and microsecond latency.
                        </p>
                    </div>
                </div>

                <div class="bg-slate-900 text-slate-200 p-4 rounded-[8px] font-mono text-xs overflow-x-auto dark-scrollbar border border-slate-800">
                    <div class="text-slate-400 mb-1"># Test connection directly from your laptop terminal in 1 second:</div>
                    <span class="text-emerald-400">curl</span> -X POST http://&lt;phone-ip&gt;:8080/api/query \<br>
                    &nbsp;&nbsp;-H <span class="text-amber-300">"Authorization: Bearer YOUR_API_KEY"</span> \<br>
                    &nbsp;&nbsp;-H <span class="text-amber-300">"Content-Type: application/json"</span> \<br>
                    &nbsp;&nbsp;-d <span class="text-cyan-300">'{"database":"ecommerce","sql":"SELECT sqlite_version(), CURRENT_TIMESTAMP;"}'</span>
                </div>
            </div>

        </div>
    </section>

    <!-- 5. COMMUNITY & SPONSORSHIP CALLOUT BANNER -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left reveal-on-scroll">
                <div class="space-y-2 max-w-2xl">
                    <span class="inline-block px-3 py-1 bg-white/20 text-white font-semibold text-xs rounded-[10px]">Independent Open Source</span>
                    <h2 class="text-3xl font-extrabold tracking-tight">Support PocketSQL Development</h2>
                    <p class="text-blue-100 text-sm sm:text-base">
                        PocketSQL is 100% free and open source. Your contributions help maintain Android 10-15 compatibility, build new SQL features, and keep the project independent.
                    </p>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('donate') }}" class="px-6 py-3 bg-white text-rose-600 font-extrabold rounded-[10px] text-sm hover:bg-rose-50 shadow-md transition flex items-center space-x-2 group hover-lift active:scale-95">
                        <i class="fa-solid fa-heart text-rose-500 transition-transform group-hover:scale-125"></i>
                        <span>Donate &rarr;</span>
                    </a>
                    <a href="{{ $settings->github_repo_url ?? 'https://github.com/pocketsql/pocketsql' }}" target="_blank" rel="noopener" class="px-6 py-3 bg-blue-700 text-white font-bold rounded-[10px] text-sm hover:bg-blue-800 border border-blue-500 shadow-sm transition hover-lift active:scale-95">
                        <i class="fa-brands fa-github mr-1"></i> Star on GitHub ⭐
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. TOP FAQS ACCORDION -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 space-y-2 reveal-on-scroll">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600 bg-slate-100 px-3 py-1 rounded-[10px] border border-slate-200">Got Questions?</span>
                <h2 class="text-3xl font-extrabold text-slate-900">Frequently Asked Questions</h2>
                <p class="text-sm text-slate-600">Quick answers to common questions about running PocketSQL on your device.</p>
            </div>

            <div class="space-y-3" x-data="{ openFaq: null }">
                @foreach($topFaqs as $index => $faq)
                    <div class="border border-slate-200 rounded-[10px] overflow-hidden bg-white reveal-on-scroll reveal-delay-{{ ($index % 5) + 1 }} transition-colors hover:border-slate-300">
                        <button type="button" 
                                @click="openFaq = (openFaq === {{ $index }} ? null : {{ $index }})"
                                class="w-full px-5 py-4 text-left flex items-center justify-between text-slate-900 font-bold text-sm sm:text-base hover:bg-slate-50 transition">
                            <span>{{ $faq->question }}</span>
                            <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300 flex-shrink-0 ml-4"
                               :class="openFaq === {{ $index }} ? 'rotate-180 text-blue-600' : ''"></i>
                        </button>
                        <div x-show="openFaq === {{ $index }}" 
                             x-transition:enter="transition ease-out duration-250"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             x-cloak 
                             class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-8 reveal-on-scroll">
                <a href="{{ route('faq') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-transform hover:translate-x-1 duration-200 inline-flex items-center">
                    View all frequently asked questions &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 7. FINAL DOWNLOAD CTA BANNER -->
    <section class="py-16 bg-slate-50 border-t border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 reveal-on-scroll">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                Ready to Turn Your Phone into an SQL Server?
            </h2>
            <p class="text-base text-slate-600 max-w-2xl mx-auto">
                Download PocketSQL {{ $settings->current_version }} today. Zero setup hurdles, zero cloud accounts, and 100% offline control.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                <x-button variant="primary" href="{{ $settings->playstore_url ?? 'https://play.google.com/store/apps/details?id=app.pocketsql.database' }}" target="_blank" rel="noopener" class="py-3 px-6 text-base">
                    <i class="fa-brands fa-google-play mr-2"></i>
                    Install from Google Play
                </x-button>
                <x-button variant="secondary" href="{{ route('download.apk') }}" class="py-3 px-6 text-base">
                    <i class="fa-solid fa-download mr-2 text-blue-600"></i>
                    Download APK Directly ({{ $settings->apk_size }})
                </x-button>
            </div>
        </div>
    </section>

</x-layout>
