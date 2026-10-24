<x-admin.layout title="Traffic Manager &amp; Handler — PocketSQL Admin">

    <!-- Top Breadcrumb & Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-1 font-mono">
                <span>Security Engine</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                <span class="text-blue-600 font-bold">Traffic &amp; Location Analytics</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-3">
                <div class="w-10 h-10 rounded-[10px] bg-blue-50 text-blue-600 flex items-center justify-center text-lg border border-blue-200 shadow-xs">
                    <i class="fa-solid fa-traffic-light"></i>
                </div>
                <span>Traffic &amp; Country Analytics</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Real-time traffic audit, Country-wise request intelligence with interactive charts, Date range filtering, and APK download tracking.
            </p>
        </div>

        <!-- Quick Maintenance Actions -->
        <div class="flex items-center space-x-2">
            <form action="{{ route('admin.traffic.reset_rate_limiters', [], false) }}" method="POST" onsubmit="return confirm('Reset all active rate limiters and temporary lockout counters?');">
                @csrf
                <button type="submit" class="px-3.5 py-2 rounded-[10px] bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-xs transition flex items-center space-x-1.5 cursor-pointer">
                    <i class="fa-solid fa-rotate text-blue-600"></i>
                    <span>Reset Limiters</span>
                </button>
            </form>

            <div x-data="{ confirming: false }" class="inline-block">
                <button type="button" 
                        x-show="!confirming" 
                        @click="confirming = true"
                        class="px-3.5 py-2 rounded-[10px] bg-white border border-red-200 hover:bg-red-50 text-red-600 text-xs font-semibold shadow-xs transition flex items-center space-x-1.5 cursor-pointer">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Clear Web Logs</span>
                </button>

                <div x-show="confirming" x-cloak class="flex items-center space-x-1">
                    <form action="{{ route('admin.traffic.clear_logs', [], false) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-[10px] bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                            Confirm Clear
                        </button>
                    </form>
                    <button type="button" 
                            @click="confirming = false" 
                            class="p-2 rounded-[10px] bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition cursor-pointer" 
                            title="Cancel">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- DATE RANGE FILTER BAR -->
    <div class="bg-white border border-slate-200 rounded-[10px] p-4 shadow-xs">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            
            <!-- Quick Preset Date Pills -->
            <div class="flex flex-wrap items-center gap-1.5 text-xs">
                <span class="text-xs font-bold text-slate-600 mr-1 flex items-center space-x-1 font-mono">
                    <i class="fa-solid fa-calendar-days text-blue-600"></i>
                    <span>Date Filter:</span>
                </span>

                <a href="{{ route('admin.traffic.index', ['date_range' => 'all', 'tab' => $activeTab]) }}" 
                   class="px-3 py-1.5 rounded-[8px] font-semibold transition {{ $dateRange === 'all' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    All Time
                </a>
                <a href="{{ route('admin.traffic.index', ['date_range' => 'today', 'tab' => $activeTab]) }}" 
                   class="px-3 py-1.5 rounded-[8px] font-semibold transition {{ $dateRange === 'today' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Today
                </a>
                <a href="{{ route('admin.traffic.index', ['date_range' => 'yesterday', 'tab' => $activeTab]) }}" 
                   class="px-3 py-1.5 rounded-[8px] font-semibold transition {{ $dateRange === 'yesterday' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Yesterday
                </a>
                <a href="{{ route('admin.traffic.index', ['date_range' => '7days', 'tab' => $activeTab]) }}" 
                   class="px-3 py-1.5 rounded-[8px] font-semibold transition {{ $dateRange === '7days' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Last 7 Days
                </a>
                <a href="{{ route('admin.traffic.index', ['date_range' => '30days', 'tab' => $activeTab]) }}" 
                   class="px-3 py-1.5 rounded-[8px] font-semibold transition {{ $dateRange === '30days' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Last 30 Days
                </a>
                <a href="{{ route('admin.traffic.index', ['date_range' => 'month', 'tab' => $activeTab]) }}" 
                   class="px-3 py-1.5 rounded-[8px] font-semibold transition {{ $dateRange === 'month' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    This Month
                </a>
            </div>

            <!-- Custom Date Range Form -->
            <form action="{{ route('admin.traffic.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="tab" value="{{ $activeTab }}">
                <div class="flex items-center space-x-1.5 bg-slate-50 border border-slate-300 rounded-[8px] px-2.5 py-1">
                    <span class="text-[11px] font-bold text-slate-500 uppercase font-mono">From:</span>
                    <input type="date" 
                           name="date_from" 
                           value="{{ $dateFrom }}" 
                           class="bg-transparent text-xs text-slate-800 font-mono focus:outline-none">
                </div>
                <div class="flex items-center space-x-1.5 bg-slate-50 border border-slate-300 rounded-[8px] px-2.5 py-1">
                    <span class="text-[11px] font-bold text-slate-500 uppercase font-mono">To:</span>
                    <input type="date" 
                           name="date_to" 
                           value="{{ $dateTo }}" 
                           class="bg-transparent text-xs text-slate-800 font-mono focus:outline-none">
                </div>
                <button type="submit" class="px-3.5 py-1.5 rounded-[8px] bg-slate-900 hover:bg-black text-white text-xs font-bold shadow-xs transition flex items-center space-x-1 cursor-pointer">
                    <i class="fa-solid fa-filter text-[10px]"></i>
                    <span>Apply</span>
                </button>
                @if($dateRange !== 'all')
                    <a href="{{ route('admin.traffic.index', ['tab' => $activeTab]) }}" 
                       class="p-1.5 rounded-[8px] bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition" 
                       title="Reset Date Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- 1. Top Analytics Stats Cards (5 Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Metric 1: Requests -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-medium">
                <span>Requests</span>
                <span class="w-7 h-7 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono">
                {{ number_format($totalRequests) }}
            </div>
            <div class="flex items-center space-x-2 text-[11px] text-slate-500">
                <span class="inline-flex items-center text-emerald-600 font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-ping"></span> Live
                </span>
                <span>• {{ $dateRange === 'all' ? 'All recorded' : 'Filtered period' }}</span>
            </div>
        </div>

        <!-- Metric 2: Unique IPs -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-medium">
                <span>Unique Client IPs</span>
                <span class="w-7 h-7 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-users-viewfinder"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono">
                {{ number_format($uniqueIps) }}
            </div>
            <div class="text-[11px] text-slate-500">
                Distinct visitors logged
            </div>
        </div>

        <!-- Metric 3: APK Downloads Tracked -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs space-y-2 relative overflow-hidden group">
            <div class="flex items-center justify-between text-slate-500 text-xs font-medium">
                <span>APK Downloads</span>
                <span class="w-7 h-7 rounded-[8px] bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-download"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-indigo-600 font-mono">
                {{ number_format($totalApkDownloads) }}
            </div>
            <div class="text-[11px] text-slate-500 flex items-center justify-between">
                <span class="font-bold text-emerald-600">+{{ $apkDownloadsToday }} today</span>
                <span>{{ $uniqueDownloadIps }} Unique IPs</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
        </div>

        <!-- Metric 4: Rate Limited & Blocked -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-medium">
                <span>Throttled &amp; Blocked</span>
                <span class="w-7 h-7 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-shield-virus"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-amber-600 font-mono">
                {{ number_format($rateLimitedCount) }}
            </div>
            <div class="text-[11px] text-slate-500 flex items-center justify-between">
                <span>429 Rate Limits Hit</span>
                <span class="font-bold text-red-600">{{ $blockedCount }} Blocked</span>
            </div>
        </div>

        <!-- Metric 5: Avg Response Latency -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-medium">
                <span>Avg Latency</span>
                <span class="w-7 h-7 rounded-[8px] bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-stopwatch"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono">
                {{ $avgResponseTime }} <span class="text-sm font-normal text-slate-500">ms</span>
            </div>
            <div class="text-[11px] text-slate-500">
                Server response round-trip
            </div>
        </div>
    </div>

    <!-- 2. COUNTRY-WISE TOTALS & INTERACTIVE VISUAL CHART SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Country-Wise Breakdown Table (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-slate-200 rounded-[10px] p-6 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <div class="w-7 h-7 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-xs border border-blue-200">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900 text-sm">Requests by Country (Total Summary)</h2>
                        <p class="text-[11px] text-slate-400">Total volume and unique visitors originating from each country</p>
                    </div>
                </div>
                <span class="text-xs font-mono font-bold bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-[6px] border border-blue-200 self-start sm:self-auto">
                    {{ $countryStats->count() }} {{ Str::plural('Country', $countryStats->count()) }}
                </span>
            </div>

            @if($countryStats->isEmpty())
                <div class="text-center py-10 text-xs text-slate-400 font-mono">
                    <i class="fa-solid fa-earth-americas text-3xl text-slate-300 mb-2 block"></i>
                    No country requests recorded for the selected date range.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 uppercase font-mono text-[10px]">
                                <th class="py-2 px-3">Country &amp; Flag</th>
                                <th class="py-2 px-3 text-right">Total Requests</th>
                                <th class="py-2 px-3 text-right">Unique IPs</th>
                                <th class="py-2 px-3 min-w-[140px]">Traffic Share</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($countryStats as $stat)
                                <tr class="hover:bg-slate-50 transition">
                                    <!-- Country & Flag -->
                                    <td class="py-2.5 px-3">
                                        <div class="flex items-center space-x-2">
                                            @if($stat->flag_url)
                                                <img src="{{ $stat->flag_url }}" 
                                                     srcset="{{ $stat->flag_retina_url }} 2x" 
                                                     alt="{{ $stat->country_code }}" 
                                                     loading="lazy" 
                                                     class="w-5 h-3.5 object-cover rounded-[2px] shadow-2xs border border-slate-200 flex-shrink-0"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                                <span style="display:none;" class="text-sm leading-none">{{ $stat->flag_emoji }}</span>
                                            @else
                                                <span class="text-sm leading-none">{{ $stat->flag_emoji }}</span>
                                            @endif
                                            
                                            <div class="flex items-center space-x-1.5">
                                                <span class="font-bold text-slate-800 text-xs">{{ $stat->country }}</span>
                                                <span class="text-[10px] font-mono text-slate-400 bg-slate-100 px-1 py-0.2 rounded border border-slate-200">
                                                    {{ $stat->country_code }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Total Requests -->
                                    <td class="py-2.5 px-3 font-mono font-bold text-slate-900 text-right">
                                        {{ number_format($stat->total_requests) }}
                                    </td>

                                    <!-- Unique IPs -->
                                    <td class="py-2.5 px-3 font-mono text-slate-600 text-right">
                                        {{ number_format($stat->unique_ips) }}
                                    </td>

                                    <!-- Percentage Bar -->
                                    <td class="py-2.5 px-3">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden flex-grow">
                                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $stat->percentage }}%"></div>
                                            </div>
                                            <span class="font-mono font-bold text-[11px] text-blue-700 w-12 text-right">
                                                {{ $stat->percentage }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-slate-200 bg-slate-50 font-bold text-slate-900">
                                <td class="py-2.5 px-3">Total (All Countries)</td>
                                <td class="py-2.5 px-3 font-mono text-right text-blue-700">{{ number_format($totalRequests) }}</td>
                                <td class="py-2.5 px-3 font-mono text-right text-emerald-700">{{ number_format($uniqueIps) }}</td>
                                <td class="py-2.5 px-3 font-mono text-right text-slate-600">100.0%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>

        <!-- Right: Interactive Chart.js Visual Chart (5 cols) -->
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-[10px] p-6 shadow-xs space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center space-x-2">
                        <div class="w-7 h-7 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs border border-emerald-200">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <h2 class="font-bold text-slate-900 text-sm">Traffic Share by Country</h2>
                    </div>
                    <span class="text-[10px] font-mono text-slate-400 bg-slate-100 px-2 py-0.5 rounded">Visual Chart</span>
                </div>

                <!-- Canvas Chart Container -->
                <div class="pt-4 flex items-center justify-center relative min-h-[260px]">
                    @if(empty($chartData))
                        <div class="text-center py-12 text-xs text-slate-400 font-mono">
                            No chart data available for current date filter.
                        </div>
                    @else
                        <canvas id="countryTrafficChart" class="max-h-[260px]"></canvas>
                    @endif
                </div>
            </div>

            <!-- Mini Summary Legend under Chart -->
            @if(!empty($chartData))
                <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                    @foreach($countryStats->take(4) as $idx => $cs)
                        <div class="flex items-center space-x-1.5 truncate">
                            <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: {{ $chartColors[$idx % count($chartColors)] }}"></span>
                            <span class="font-medium text-slate-700 truncate">{{ $cs->country }}</span>
                            <span class="font-mono text-slate-400 text-[10px]">({{ $cs->percentage }}%)</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <!-- 3. Security Shield Rules & IP Restriction Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Rules & Thresholds Form (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-slate-200 rounded-[10px] p-6 shadow-xs space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <h2 class="font-bold text-slate-900 text-sm">Traffic Handler &amp; Rate Limiter Policies</h2>
                </div>
                <span class="text-[10px] font-mono bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-[6px] border border-blue-200 font-bold">
                    Active Defense
                </span>
            </div>

            <form action="{{ route('admin.traffic.update_rules') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Shield Master Switch -->
                <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 flex items-center justify-between">
                    <div class="space-y-0.5 pr-4">
                        <div class="text-xs font-bold text-slate-900 flex items-center space-x-1.5">
                            <i class="fa-solid fa-shield-halved text-blue-600"></i>
                            <span>Traffic Shield Engine</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            When enabled, automatically monitors inbound IP activity, throttles bursts exceeding thresholds, and drops blacklisted IP addresses.
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                        <input type="checkbox" name="traffic_shield_enabled" value="1" {{ ($settings->traffic_shield_enabled ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Rule 1: Public Rate Limit / min -->
                    <div class="space-y-1.5">
                        <label for="rate_limit_per_minute" class="block text-xs font-bold text-slate-700">
                            Public Limit (req/min)
                        </label>
                        <input type="number" 
                               id="rate_limit_per_minute" 
                               name="rate_limit_per_minute" 
                               min="10" 
                               max="1000" 
                               required 
                               value="{{ $settings->rate_limit_per_minute ?? 120 }}"
                               class="w-full px-3 py-2 text-xs font-mono rounded-[8px] border border-slate-300 focus:ring-2 focus:ring-blue-500">
                        <span class="text-[10px] text-slate-400 block">Max hits per IP/min</span>
                    </div>

                    <!-- Rule 2: Admin Login Max Attempts -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="admin_login_max_attempts" class="block text-xs font-bold text-slate-700">
                                Admin Login Max
                            </label>
                            <span class="text-[9px] font-bold text-red-600 bg-red-50 px-1.5 py-0.2 rounded border border-red-200">Strict</span>
                        </div>
                        <input type="number" 
                               id="admin_login_max_attempts" 
                               name="admin_login_max_attempts" 
                               min="1" 
                               max="10" 
                               required 
                               value="{{ $settings->admin_login_max_attempts ?? 3 }}"
                               class="w-full px-3 py-2 text-xs font-mono rounded-[8px] border border-slate-300 focus:ring-2 focus:ring-blue-500 font-bold text-red-700 bg-red-50/20">
                        <span class="text-[10px] text-slate-400 block">Lockout after fails (5m)</span>
                    </div>

                    <!-- Rule 3: Session Expiration Timeout -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="admin_session_lifetime_minutes" class="block text-xs font-bold text-slate-700">
                                Session Inactivity
                            </label>
                            <span class="text-[9px] font-bold text-purple-600 bg-purple-50 px-1.5 py-0.2 rounded border border-purple-200">Auto Expire</span>
                        </div>
                        <input type="number" 
                               id="admin_session_lifetime_minutes" 
                               name="admin_session_lifetime_minutes" 
                               min="2" 
                               max="1440" 
                               required 
                               value="{{ $settings->admin_session_lifetime_minutes ?? 15 }}"
                               class="w-full px-3 py-2 text-xs font-mono rounded-[8px] border border-slate-300 focus:ring-2 focus:ring-blue-500">
                        <span class="text-[10px] text-slate-400 block">Minutes idle before logout</span>
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-5 py-2.5 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm transition flex items-center space-x-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Apply &amp; Enforce Policies</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Manual IP Restrictor Form (5 cols) -->
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-[10px] p-6 shadow-xs space-y-4">
            <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                <h2 class="font-bold text-slate-900 text-sm">Restrict Client IP (Firewall)</h2>
            </div>
            
            <p class="text-xs text-slate-500 leading-relaxed">
                Immediately block malicious or abusive IPs. Any traffic from this IP will receive HTTP 403 Access Denied.
            </p>

            <form action="{{ route('admin.traffic.block_ip') }}" method="POST" class="space-y-3">
                @csrf
                <div class="space-y-1">
                    <label for="ip_address" class="block text-xs font-bold text-slate-700">IP Address</label>
                    <input type="text" 
                           id="ip_address" 
                           name="ip_address" 
                           placeholder="e.g. 198.51.100.42" 
                           required 
                           class="w-full px-3 py-2 text-xs font-mono rounded-[8px] border border-slate-300 focus:ring-2 focus:ring-red-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label for="duration_hours" class="block text-xs font-bold text-slate-700">Duration</label>
                        <select id="duration_hours" name="duration_hours" class="w-full px-3 py-2 text-xs rounded-[8px] border border-slate-300">
                            <option value="24">24 Hours</option>
                            <option value="72">3 Days</option>
                            <option value="168">7 Days</option>
                            <option value="0">Permanent</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="reason" class="block text-xs font-bold text-slate-700">Reason</label>
                        <input type="text" 
                               id="reason" 
                               name="reason" 
                               placeholder="e.g. Abusive scraper" 
                               class="w-full px-3 py-2 text-xs rounded-[8px] border border-slate-300">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-[8px] bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-ban"></i>
                        <span>Restrict IP Address</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- 4. Blocked IPs Table -->
    <div class="bg-white border border-slate-200 rounded-[10px] p-6 shadow-xs space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-shield-virus text-red-500"></i>
                <h2 class="font-bold text-slate-900 text-sm">Active IP Restrictions (Blacklist)</h2>
                <span class="text-xs font-mono font-bold bg-slate-100 text-slate-700 px-2 py-0.5 rounded-[6px]">
                    {{ $blockedIps->count() }} restricted
                </span>
            </div>
        </div>

        @if($blockedIps->isEmpty())
            <div class="text-center py-6 text-xs text-slate-400 font-mono">
                No active IP restrictions currently enforced. Clean traffic perimeter.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 uppercase font-mono text-[10px]">
                            <th class="py-2.5 px-3">IP Address</th>
                            <th class="py-2.5 px-3">Reason</th>
                            <th class="py-2.5 px-3">Restricted At</th>
                            <th class="py-2.5 px-3">Expires</th>
                            <th class="py-2.5 px-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($blockedIps as $blocked)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2.5 px-3 font-mono font-bold text-red-600">
                                    {{ $blocked->ip_address }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $blocked->reason ?? 'Manual restriction' }}
                                </td>
                                <td class="py-2.5 px-3 font-mono text-slate-400">
                                    {{ $blocked->created_at->format('M d, H:i') }}
                                </td>
                                <td class="py-2.5 px-3 font-mono text-slate-500">
                                    {{ $blocked->blocked_until ? $blocked->blocked_until->diffForHumans() : 'Permanent' }}
                                </td>
                                <td class="py-2.5 px-3 text-right">
                                    <form action="{{ route('admin.traffic.unblock_ip', $blocked, false) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-[6px] bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold text-[11px] border border-emerald-200 transition cursor-pointer">
                                            <i class="fa-solid fa-lock-open mr-1"></i>Unblock
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- 5. Interactive Live Logs & APK Download Tracking Section -->
    <div x-data="{ currentTab: '{{ $activeTab }}' }" class="bg-white border border-slate-200 rounded-[10px] p-6 shadow-xs space-y-6">
        
        <!-- Tab Navigation Switcher Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-4 border-b border-slate-200">
            <div class="flex items-center space-x-2">
                <!-- Tab 1: Web Traffic Stream Button -->
                <button type="button" 
                        @click="currentTab = 'traffic'" 
                        :class="currentTab === 'traffic' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-[8px] text-xs font-bold transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-globe"></i>
                    <span>Web Traffic Stream</span>
                    <span :class="currentTab === 'traffic' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'" class="px-1.5 py-0.2 rounded text-[10px] font-mono">
                        {{ $trafficLogs->count() }}
                    </span>
                </button>

                <!-- Tab 2: APK Download Logs Button -->
                <button type="button" 
                        @click="currentTab = 'downloads'" 
                        :class="currentTab === 'downloads' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-[8px] text-xs font-bold transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-download"></i>
                    <span>APK Download Logs &amp; Locations</span>
                    <span :class="currentTab === 'downloads' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'" class="px-1.5 py-0.2 rounded text-[10px] font-mono">
                        {{ $totalApkDownloads }}
                    </span>
                </button>
            </div>

            <!-- Tab Context Info -->
            <div class="flex items-center space-x-3 text-xs text-slate-500 font-mono">
                <span class="inline-flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                    GeoLocation &amp; Country Engine Active
                </span>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: WEB TRAFFIC AUDIT STREAM -->
        <!-- ========================================== -->
        <div x-show="currentTab === 'traffic'" class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-list-check text-blue-600"></i>
                    <h2 class="font-bold text-slate-900 text-sm">Real-Time Inbound Request Stream</h2>
                    <span class="text-xs font-mono font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded-[6px]">
                        Last 50 Records
                    </span>
                </div>

                <!-- Web Traffic Filter Pills -->
                <div class="flex items-center space-x-1.5 text-xs">
                    <a href="{{ route('admin.traffic.index', ['tab' => 'traffic', 'filter' => 'all', 'date_range' => $dateRange, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
                       class="px-2.5 py-1 rounded-[6px] font-semibold transition {{ $logFilter === 'all' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        All
                    </a>
                    <a href="{{ route('admin.traffic.index', ['tab' => 'traffic', 'filter' => 'success', 'date_range' => $dateRange, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
                       class="px-2.5 py-1 rounded-[6px] font-semibold transition {{ $logFilter === 'success' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        2xx OK
                    </a>
                    <a href="{{ route('admin.traffic.index', ['tab' => 'traffic', 'filter' => 'rate_limited', 'date_range' => $dateRange, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
                       class="px-2.5 py-1 rounded-[6px] font-semibold transition {{ $logFilter === 'rate_limited' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        429 Throttled
                    </a>
                    <a href="{{ route('admin.traffic.index', ['tab' => 'traffic', 'filter' => 'errors', 'date_range' => $dateRange, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
                       class="px-2.5 py-1 rounded-[6px] font-semibold transition {{ $logFilter === 'errors' ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Errors
                    </a>
                </div>
            </div>

            @if($trafficLogs->isEmpty())
                <div class="text-center py-8 text-xs text-slate-400 font-mono">
                    No web traffic logs recorded for the selected filter. Visit public pages to generate live stream activity.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 uppercase font-mono text-[10px]">
                                <th class="py-2.5 px-3">Status</th>
                                <th class="py-2.5 px-3">Method</th>
                                <th class="py-2.5 px-3">Path</th>
                                <th class="py-2.5 px-3">Client IP</th>
                                <th class="py-2.5 px-3 min-w-[210px]">Location &amp; Country</th>
                                <th class="py-2.5 px-3 min-w-[170px]">Device &amp; OS</th>
                                <th class="py-2.5 px-3">Latency</th>
                                <th class="py-2.5 px-3">Time</th>
                                <th class="py-2.5 px-3 text-right">Quick Restrict</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($trafficLogs as $log)
                                @php
                                    $dev = $log->device_info;
                                @endphp
                                <tr class="hover:bg-slate-50 transition">
                                    <!-- Status Badge -->
                                    <td class="py-2.5 px-3">
                                        @if($log->status_code >= 200 && $log->status_code < 300)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] font-mono font-bold text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                {{ $log->status_code }}
                                            </span>
                                        @elseif($log->status_code === 429)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] font-mono font-bold text-[10px] bg-amber-50 text-amber-700 border border-amber-200">
                                                429 Throttled
                                            </span>
                                        @elseif($log->status_code === 403)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] font-mono font-bold text-[10px] bg-red-50 text-red-700 border border-red-200">
                                                403 Blocked
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] font-mono font-bold text-[10px] bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ $log->status_code }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Method -->
                                    <td class="py-2.5 px-3 font-mono font-bold text-[11px] {{ $log->method === 'POST' ? 'text-blue-600' : 'text-slate-700' }}">
                                        {{ $log->method }}
                                    </td>

                                    <!-- Path -->
                                    <td class="py-2.5 px-3 font-mono text-slate-800 truncate max-w-xs" title="{{ $log->path }}">
                                        {{ $log->path }}
                                    </td>

                                    <!-- IP Address -->
                                    <td class="py-2.5 px-3 font-mono text-slate-700 font-semibold">
                                        {{ $log->ip_address }}
                                    </td>

                                    <!-- Location with Country Flag -->
                                    <td class="py-2.5 px-3 text-slate-700">
                                        <div class="flex items-center space-x-2">
                                            @if($log->flag_url)
                                                <img src="{{ $log->flag_url }}" 
                                                     srcset="{{ $log->flag_retina_url }} 2x" 
                                                     alt="{{ $log->country_code }}" 
                                                     loading="lazy" 
                                                     class="w-5 h-3.5 object-cover rounded-[2px] shadow-2xs border border-slate-200 inline-block align-middle flex-shrink-0"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                                <span style="display:none;" class="text-sm leading-none align-middle">{{ $log->flag_emoji }}</span>
                                            @else
                                                <span class="text-sm leading-none align-middle">{{ $log->flag_emoji }}</span>
                                            @endif
                                            
                                            <span class="font-medium text-xs text-slate-800" title="{{ $log->formatted_location }} ({{ $log->country_code }})">
                                                {{ $log->formatted_location }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Device & OS -->
                                    <td class="py-2.5 px-3">
                                        <div class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-[6px] border {{ $dev['badge_class'] ?? 'bg-slate-50 text-slate-700 border-slate-200' }}" title="{{ $log->user_agent }}">
                                            <i class="{{ $dev['device_icon'] ?? 'fa-solid fa-laptop' }} text-xs"></i>
                                            <span class="font-semibold text-[11px] truncate max-w-[140px]">
                                                {{ $dev['label'] ?? ($log->os ?? 'Desktop') }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Latency -->
                                    <td class="py-2.5 px-3 font-mono text-slate-500 text-[11px]">
                                        {{ $log->response_time_ms }}ms
                                    </td>

                                    <!-- Time -->
                                    <td class="py-2.5 px-3 font-mono text-slate-500 text-[11px]">
                                        {{ $log->created_at ? $log->created_at->format('H:i:s') : '—' }}
                                    </td>

                                    <!-- Action -->
                                    <td class="py-2.5 px-3 text-right">
                                        <form action="{{ route('admin.traffic.block_ip', [], false) }}" method="POST" class="inline-block">
                                            @csrf
                                            <input type="hidden" name="ip_address" value="{{ $log->ip_address }}">
                                            <input type="hidden" name="reason" value="Restricted from Web Traffic stream">
                                            <input type="hidden" name="duration_hours" value="24">
                                            <button type="submit" 
                                                    title="Quick restrict IP for 24h"
                                                    class="px-2 py-0.5 rounded-[6px] text-[10px] font-semibold text-slate-500 hover:text-red-600 hover:bg-red-50 transition border border-transparent hover:border-red-200 cursor-pointer">
                                                <i class="fa-solid fa-ban mr-1"></i>Block
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: APK DOWNLOAD LOGS & LOCATIONS -->
        <!-- ========================================== -->
        <div x-show="currentTab === 'downloads'" class="space-y-6">
            
            <!-- Quick Download Summary Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Top Download Locations Widget -->
                <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                        <span class="flex items-center space-x-1.5">
                            <i class="fa-solid fa-map-location-dot text-indigo-600"></i>
                            <span>Top APK Download Locations</span>
                        </span>
                        <span class="text-[10px] font-mono text-slate-500">By Download Volume</span>
                    </div>

                    @if($topDownloadLocations->isEmpty())
                        <div class="text-center py-4 text-xs text-slate-400 font-mono">
                            No location telemetry recorded for downloads yet.
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach($topDownloadLocations as $loc)
                                @php
                                    $flagUrl = \App\Services\GeoLocationService::getFlagUrl($loc->country_code);
                                    $flagEmoji = \App\Services\GeoLocationService::getFlagEmoji($loc->country_code);
                                    $formattedLoc = \App\Services\GeoLocationService::formatLocation($loc->city, $loc->state, $loc->country);
                                @endphp
                                <div class="flex items-center justify-between text-xs bg-white p-2.5 rounded-[8px] border border-slate-200 shadow-2xs">
                                    <div class="flex items-center space-x-2">
                                        @if($flagUrl)
                                            <img src="{{ $flagUrl }}" alt="{{ $loc->country_code }}" class="w-5 h-3.5 object-cover rounded-[2px] shadow-2xs border border-slate-200">
                                        @else
                                            <span>{{ $flagEmoji }}</span>
                                        @endif
                                        <span class="font-bold text-slate-800">{{ $formattedLoc }}</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-[6px] font-mono font-bold text-[11px] bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        {{ $loc->count }} {{ Str::plural('download', $loc->count) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Top Download Devices Widget -->
                <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                        <span class="flex items-center space-x-1.5">
                            <i class="fa-solid fa-mobile-screen-button text-emerald-600"></i>
                            <span>Top Downloading Devices</span>
                        </span>
                        <span class="text-[10px] font-mono text-slate-500">By Platform</span>
                    </div>

                    @if($topDownloadDevices->isEmpty())
                        <div class="text-center py-4 text-xs text-slate-400 font-mono">
                            No device fingerprints recorded for downloads yet.
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach($topDownloadDevices as $d)
                                <div class="flex items-center justify-between text-xs bg-white p-2.5 rounded-[8px] border border-slate-200 shadow-2xs">
                                    <div class="flex items-center space-x-2 text-slate-800">
                                        @if(str_contains(strtolower($d->os), 'android'))
                                            <i class="fa-brands fa-android text-emerald-600 text-sm"></i>
                                        @elseif(str_contains(strtolower($d->os), 'windows'))
                                            <i class="fa-brands fa-windows text-blue-600 text-sm"></i>
                                        @elseif(str_contains(strtolower($d->os), 'ios') || str_contains(strtolower($d->os), 'mac'))
                                            <i class="fa-brands fa-apple text-slate-800 text-sm"></i>
                                        @else
                                            <i class="fa-solid fa-laptop text-slate-600 text-sm"></i>
                                        @endif
                                        <span class="font-bold">{{ $d->os ?: 'Unknown OS' }}</span>
                                        <span class="text-slate-400 font-mono text-[11px]">({{ $d->device_type ?: 'Desktop' }})</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-[6px] font-mono font-bold text-[11px] bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $d->count }} {{ Str::plural('install', $d->count) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Download Search Filter Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
                <form action="{{ route('admin.traffic.index') }}" method="GET" class="flex items-center space-x-2 flex-grow max-w-md">
                    <input type="hidden" name="tab" value="downloads">
                    <input type="hidden" name="date_range" value="{{ $dateRange }}">
                    <input type="hidden" name="date_from" value="{{ $dateFrom }}">
                    <input type="hidden" name="date_to" value="{{ $dateTo }}">
                    <div class="relative w-full">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" 
                               name="dl_search" 
                               value="{{ $downloadSearch }}" 
                               placeholder="Search by IP, City, State, Country, Version..." 
                               class="w-full pl-8 pr-3 py-1.5 text-xs rounded-[8px] border border-slate-300 focus:ring-2 focus:ring-indigo-500 font-mono">
                    </div>
                    <button type="submit" class="px-3 py-1.5 rounded-[8px] bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition flex-shrink-0 cursor-pointer">
                        Search
                    </button>
                    @if(!empty($downloadSearch))
                        <a href="{{ route('admin.traffic.index', ['tab' => 'downloads', 'date_range' => $dateRange, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="p-1.5 rounded-[8px] bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition" title="Clear Search">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </form>

                <!-- Clear Download Logs Action -->
                <div x-data="{ confirmingDl: false }" class="inline-block">
                    <button type="button" 
                            x-show="!confirmingDl" 
                            @click="confirmingDl = true"
                            class="px-3 py-1.5 rounded-[8px] bg-white border border-red-200 hover:bg-red-50 text-red-600 text-xs font-semibold shadow-xs transition flex items-center space-x-1.5 cursor-pointer">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Clear APK Logs</span>
                    </button>

                    <div x-show="confirmingDl" x-cloak class="flex items-center space-x-1">
                        <form action="{{ route('admin.traffic.clear_download_logs', [], false) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-2.5 py-1.5 rounded-[8px] bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                                Confirm Clear
                            </button>
                        </form>
                        <button type="button" 
                                @click="confirmingDl = false" 
                                class="p-1.5 rounded-[8px] bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition cursor-pointer" 
                                title="Cancel">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- APK Downloads Records Table -->
            @if($downloadLogs->isEmpty())
                <div class="text-center py-12 text-xs text-slate-400 font-mono bg-slate-50/50 rounded-[8px] border border-dashed border-slate-200">
                    <i class="fa-solid fa-cloud-arrow-down text-3xl text-slate-300 mb-2 block"></i>
                    No APK download records found for the selected filter.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 uppercase font-mono text-[10px]">
                                <th class="py-2.5 px-3">Release Version</th>
                                <th class="py-2.5 px-3">Client IP Address</th>
                                <th class="py-2.5 px-3 min-w-[210px]">Download Location</th>
                                <th class="py-2.5 px-3 min-w-[170px]">Device &amp; Client</th>
                                <th class="py-2.5 px-3">User Agent</th>
                                <th class="py-2.5 px-3">Downloaded At</th>
                                <th class="py-2.5 px-3 text-right">Quick Restrict</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($downloadLogs as $dl)
                                @php
                                    $dev = $dl->device_info;
                                @endphp
                                <tr class="hover:bg-slate-50 transition">
                                    <!-- Release Version -->
                                    <td class="py-2.5 px-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] font-mono font-bold text-[10px] bg-indigo-50 text-indigo-700 border border-indigo-200 shadow-2xs">
                                            <i class="fa-solid fa-cube mr-1 text-[9px]"></i>
                                            {{ $dl->version ?: ($dl->release->version ?? 'APK') }}
                                        </span>
                                    </td>

                                    <!-- Client IP -->
                                    <td class="py-2.5 px-3 font-mono font-bold text-slate-800">
                                        {{ $dl->ip_address }}
                                    </td>

                                    <!-- Location with Country Flag -->
                                    <td class="py-2.5 px-3 text-slate-700">
                                        <div class="flex items-center space-x-2">
                                            @if($dl->flag_url)
                                                <img src="{{ $dl->flag_url }}" 
                                                     srcset="{{ $dl->flag_retina_url }} 2x" 
                                                     alt="{{ $dl->country_code }}" 
                                                     loading="lazy" 
                                                     class="w-5 h-3.5 object-cover rounded-[2px] shadow-2xs border border-slate-200 inline-block align-middle flex-shrink-0"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                                <span style="display:none;" class="text-sm leading-none align-middle">{{ $dl->flag_emoji }}</span>
                                            @else
                                                <span class="text-sm leading-none align-middle">{{ $dl->flag_emoji }}</span>
                                            @endif
                                            
                                            <span class="font-bold text-xs text-slate-800" title="{{ $dl->formatted_location }} ({{ $dl->country_code }})">
                                                {{ $dl->formatted_location }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Device & OS -->
                                    <td class="py-2.5 px-3">
                                        <div class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-[6px] border {{ $dev['badge_class'] ?? 'bg-indigo-50 text-indigo-700 border-indigo-200' }}">
                                            <i class="{{ $dev['device_icon'] ?? 'fa-solid fa-mobile-screen' }} text-xs"></i>
                                            <span class="font-semibold text-[11px] truncate max-w-[150px]">
                                                {{ $dev['label'] ?? ($dl->os ?? 'Android') }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- User Agent -->
                                    <td class="py-2.5 px-3 font-mono text-slate-500 truncate max-w-xs text-[11px]" title="{{ $dl->user_agent }}">
                                        {{ $dl->user_agent ?: 'Standard Downloader' }}
                                    </td>

                                    <!-- Downloaded At -->
                                    <td class="py-2.5 px-3 font-mono text-slate-500 text-[11px]">
                                        <div>{{ $dl->created_at->format('M d, H:i') }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $dl->created_at->diffForHumans() }}</div>
                                    </td>

                                    <!-- Quick Restrict Action -->
                                    <td class="py-2.5 px-3 text-right">
                                        <form action="{{ route('admin.traffic.block_ip', [], false) }}" method="POST" class="inline-block">
                                            @csrf
                                            <input type="hidden" name="ip_address" value="{{ $dl->ip_address }}">
                                            <input type="hidden" name="reason" value="Flagged from APK downloads tracker">
                                            <input type="hidden" name="duration_hours" value="24">
                                            <button type="submit" 
                                                    title="Quick restrict IP for 24h"
                                                    class="px-2 py-0.5 rounded-[6px] text-[10px] font-semibold text-slate-500 hover:text-red-600 hover:bg-red-50 transition border border-transparent hover:border-red-200 cursor-pointer">
                                                <i class="fa-solid fa-ban mr-1"></i>Block
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <!-- Chart Initialization Script -->
    <script>
        (function() {
            function initCountryChart() {
                if (typeof Chart === 'undefined') {
                    setTimeout(initCountryChart, 50);
                    return;
                }
                const chartCanvas = document.getElementById('countryTrafficChart');
                if (!chartCanvas || chartCanvas.chartInstance) return;

                const labels = @json($chartLabels);
                const dataValues = @json($chartData);
                const colors = @json($chartColors);

                if (labels.length === 0 || dataValues.length === 0) return;

                chartCanvas.chartInstance = new Chart(chartCanvas, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataValues,
                        backgroundColor: colors.slice(0, labels.length),
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 10,
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 12 },
                            cornerRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const val = context.raw || 0;
                                    const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                    return ` ${val.toLocaleString()} requests (${pct}%)`;
                                }
                            }
                        }
                    },
                    cutout: '68%'
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCountryChart);
        } else {
            initCountryChart();
        }
    })();
    </script>

</x-admin.layout>
