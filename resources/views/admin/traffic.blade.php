<x-admin.layout title="Traffic Manager &amp; Handler — PocketSQL Admin">

    <!-- Top Breadcrumb & Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-1 font-mono">
                <span>Security Engine</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                <span class="text-blue-600 font-bold">Traffic Handler</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-3">
                <div class="w-10 h-10 rounded-[10px] bg-blue-50 text-blue-600 flex items-center justify-center text-lg border border-blue-200 shadow-xs">
                    <i class="fa-solid fa-traffic-light"></i>
                </div>
                <span>Traffic Manager &amp; Handler</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Real-time traffic audit, DDoS mitigation, IP restrictions, and strict rate limiter management.
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
                    <span>Clear Logs</span>
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

    <!-- 1. Top Analytics Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Metric 1: Requests Today -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-medium">
                <span>Requests Today</span>
                <span class="w-7 h-7 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono">
                {{ number_format($totalRequestsToday) }}
            </div>
            <div class="flex items-center space-x-2 text-[11px] text-slate-500">
                <span class="inline-flex items-center text-emerald-600 font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-ping"></span> Live Stream
                </span>
                <span>• 24h cycle</span>
            </div>
        </div>

        <!-- Metric 2: Unique IPs Today -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-medium">
                <span>Unique Client IPs</span>
                <span class="w-7 h-7 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-users-viewfinder"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono">
                {{ number_format($uniqueIpsToday) }}
            </div>
            <div class="text-[11px] text-slate-500">
                Distinct visitors logged today
            </div>
        </div>

        <!-- Metric 3: Rate Limited (429) & Blocked -->
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
                <span class="font-bold text-red-600">{{ $blockedCount }} IPs in Blacklist</span>
            </div>
        </div>

        <!-- Metric 4: Avg Response Latency -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-medium">
                <span>Avg Latency (6h)</span>
                <span class="w-7 h-7 rounded-[8px] bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-stopwatch"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono">
                {{ $avgResponseTime }} <span class="text-sm font-normal text-slate-500">ms</span>
            </div>
            <div class="text-[11px] text-slate-500">
                Local server round-trip speed
            </div>
        </div>
    </div>

    <!-- 2. Security Shield Rules & IP Restriction Grid -->
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

                    <!-- Rule 2: Admin Login Max Attempts (STRICT 3 ATTEMPTS) -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="admin_login_max_attempts" class="block text-xs font-bold text-slate-700">
                                Admin Login Max
                            </label>
                            <span class="text-[9px] font-bold text-red-600 bg-red-50 px-1.5 py-0.2 rounded border border-red-200">Only 3 Req</span>
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

    <!-- 3. Blocked IPs Table -->
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

    <!-- 4. Live Traffic Logs Table -->
    <div class="bg-white border border-slate-200 rounded-[10px] p-6 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-list-check text-blue-600"></i>
                <h2 class="font-bold text-slate-900 text-sm">Real-Time Traffic Audit Logs</h2>
                <span class="text-xs font-mono font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded-[6px]">
                    Last 50 Requests
                </span>
            </div>

            <!-- Filter Tabs -->
            <div class="flex items-center space-x-1.5 text-xs">
                <a href="{{ route('admin.traffic.index', ['filter' => 'all']) }}" 
                   class="px-2.5 py-1 rounded-[6px] font-semibold transition {{ $logFilter === 'all' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    All
                </a>
                <a href="{{ route('admin.traffic.index', ['filter' => 'success']) }}" 
                   class="px-2.5 py-1 rounded-[6px] font-semibold transition {{ $logFilter === 'success' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    2xx OK
                </a>
                <a href="{{ route('admin.traffic.index', ['filter' => 'rate_limited']) }}" 
                   class="px-2.5 py-1 rounded-[6px] font-semibold transition {{ $logFilter === 'rate_limited' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    429 Throttled
                </a>
                <a href="{{ route('admin.traffic.index', ['filter' => 'errors']) }}" 
                   class="px-2.5 py-1 rounded-[6px] font-semibold transition {{ $logFilter === 'errors' ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Errors
                </a>
            </div>
        </div>

        @if($trafficLogs->isEmpty())
            <div class="text-center py-8 text-xs text-slate-400 font-mono">
                No traffic logs recorded yet. Visit public pages to generate live traffic.
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
                            <th class="py-2.5 px-3">Latency</th>
                            <th class="py-2.5 px-3">Time</th>
                            <th class="py-2.5 px-3 text-right">Quick Restrict</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($trafficLogs as $log)
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
                                <td class="py-2.5 px-3 font-mono text-slate-600">
                                    {{ $log->ip_address }}
                                </td>

                                <!-- Latency -->
                                <td class="py-2.5 px-3 font-mono text-slate-400 text-[11px]">
                                    {{ $log->response_time_ms }}ms
                                </td>

                                <!-- Time -->
                                <td class="py-2.5 px-3 font-mono text-slate-400 text-[11px]">
                                    {{ $log->created_at->format('H:i:s') }}
                                </td>

                                <!-- Action -->
                                <td class="py-2.5 px-3 text-right">
                                    <form action="{{ route('admin.traffic.block_ip', [], false) }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="ip_address" value="{{ $log->ip_address }}">
                                        <input type="hidden" name="reason" value="Flagged from live traffic stream">
                                        <input type="hidden" name="duration_hours" value="24">
                                        <button type="submit" 
                                                title="Quick restrict IP for 24h"
                                                class="px-2 py-0.5 rounded-[6px] text-[10px] font-semibold text-slate-500 hover:text-red-600 hover:bg-red-50 transition border border-transparent hover:border-red-200">
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

</x-admin.layout>
