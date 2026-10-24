<x-admin.layout title="Admin Dashboard — PocketSQL">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
                <i class="fa-solid fa-gauge-high text-blue-600"></i>
                <span>System Overview Dashboard</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Real-time status of application distribution, releases, screenshots, traffic analytics, and community inquiries.</p>
        </div>
        <div class="flex items-center space-x-2.5">
            <a href="{{ route('admin.traffic.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-bold rounded-[8px] bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 shadow-xs transition">
                <i class="fa-solid fa-traffic-light mr-2 text-blue-600"></i>
                <span>Traffic &amp; Locations</span>
            </a>
            <a href="{{ route('admin.releases.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-bold rounded-[8px] bg-blue-600 text-white hover:bg-blue-700 shadow-xs shadow-blue-500/20 transition">
                <i class="fa-solid fa-circle-plus mr-2"></i>
                <span>New Release</span>
            </a>
        </div>
    </div>

    <!-- Stat Metric Cards (4 Cards - Max 10px Radius) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Inquiries -->
        <div class="bg-white p-5 rounded-[10px] border border-slate-200 shadow-xs hover:border-slate-300 transition space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">User Inquiries</span>
                <div class="w-10 h-10 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center text-sm border border-amber-100">
                    <i class="fa-solid fa-inbox"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-slate-900">{{ $unreadMessages }}</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-[6px] inline-flex items-center space-x-1 {{ $unreadMessages > 0 ? 'bg-amber-100 text-amber-800 font-bold' : 'bg-slate-100 text-slate-600' }}">
                    @if($unreadMessages > 0)
                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                        <span>Action Needed</span>
                    @else
                        <i class="fa-solid fa-circle-check text-[10px] text-emerald-600"></i>
                        <span>All Clear</span>
                    @endif
                </span>
            </div>
            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1 border-t border-slate-100">
                <span>Total Received:</span>
                <span class="font-mono font-bold text-slate-600">{{ $totalMessages }}</span>
            </div>
        </div>

        <!-- Card 2: App Version -->
        <div class="bg-white p-5 rounded-[10px] border border-slate-200 shadow-xs hover:border-slate-300 transition space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Current App Build</span>
                <div class="w-10 h-10 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-sm border border-blue-100">
                    <i class="fa-brands fa-android text-base"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-blue-600">{{ $settings->current_version }}</span>
                <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded-[6px] bg-blue-50 text-blue-700 border border-blue-100">
                    Build #{{ $settings->version_code }}
                </span>
            </div>
            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1 border-t border-slate-100">
                <span>Release Status:</span>
                <span class="font-bold text-emerald-600 flex items-center space-x-1">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span>Production</span>
                </span>
            </div>
        </div>

        <!-- Card 3: Daemon Server -->
        <div class="bg-white p-5 rounded-[10px] border border-slate-200 shadow-xs hover:border-slate-300 transition space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">API Server Daemon</span>
                <div class="w-10 h-10 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm border border-emerald-100">
                    <i class="fa-solid fa-server"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold {{ $settings->api_server_active ? 'text-emerald-600' : 'text-slate-400' }}">
                    {{ $settings->api_server_active ? 'Online' : 'Offline' }}
                </span>
                <span class="flex items-center space-x-1.5 text-xs font-semibold px-2 py-0.5 rounded-[6px] {{ $settings->api_server_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                    <span class="w-2 h-2 rounded-full {{ $settings->api_server_active ? 'bg-emerald-500 animate-ping' : 'bg-slate-400' }}"></span>
                    <span>Port 8080</span>
                </span>
            </div>
            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1 border-t border-slate-100">
                <span>Protocol:</span>
                <span class="font-mono text-slate-600">HTTP REST Daemon</span>
            </div>
        </div>

        <!-- Card 4: Releases & Downloads -->
        <div class="bg-white p-5 rounded-[10px] border border-slate-200 shadow-xs hover:border-slate-300 transition space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">APK Downloads</span>
                <div class="w-10 h-10 rounded-[8px] bg-purple-50 text-purple-600 flex items-center justify-center text-sm border border-purple-100">
                    <i class="fa-solid fa-cloud-arrow-down"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-slate-900">{{ number_format($totalDownloads) }}</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-[6px] bg-purple-50 text-purple-700 border border-purple-100">
                    {{ $totalReleases }} Builds
                </span>
            </div>
            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1 border-t border-slate-100">
                <span>Active Channels:</span>
                <span class="font-mono font-bold text-slate-600">{{ $activeDonations }} Donation Channels</span>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- ANALYTICS CHARTS SECTION: TRAFFIC & DOWNLOADERS         -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Chart 1: Web Traffic Activity Trends -->
        <div class="bg-white p-5 sm:p-6 rounded-[10px] border border-slate-200 shadow-xs space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-sm border border-blue-200">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h2 class="font-bold text-slate-900 text-sm">Web Traffic Volume</h2>
                                <span class="text-[10px] font-mono font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded-[6px] border border-blue-200">Line Graph</span>
                            </div>
                            <p class="text-[11px] text-slate-400">7-Day requests &amp; unique visitors area curve</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-[6px] border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-ping"></span> Live Stream
                        </span>
                        <a href="{{ route('admin.traffic.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                            Details &rarr;
                        </a>
                    </div>
                </div>

                <div class="pt-4 relative w-full" style="height: 250px;">
                    <canvas id="dashboardTrafficChart"></canvas>
                </div>
            </div>

            <!-- Mini Summary Footer -->
            <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-600">
                <div class="flex items-center space-x-3">
                    <span class="flex items-center space-x-1.5 font-medium">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span>Total: <strong class="text-slate-900 font-mono">{{ number_format($totalRequests) }}</strong></span>
                    </span>
                    <span class="flex items-center space-x-1.5 font-medium">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>Today: <strong class="text-emerald-700 font-mono">+{{ number_format($todayRequests) }}</strong></span>
                    </span>
                </div>
                <!-- Top Traffic Country Flags -->
                <div class="flex items-center space-x-1.5">
                    @foreach($topTrafficCountries as $tc)
                        @if($tc->flag_url)
                            <img src="{{ $tc->flag_url }}" 
                                 alt="{{ $tc->country_code }}" 
                                 title="{{ $tc->country }} ({{ $tc->count }} requests)" 
                                 class="w-4 h-3 object-cover rounded-[2px] shadow-2xs border border-slate-200">
                        @else
                            <span title="{{ $tc->country }}">{{ $tc->flag_emoji }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Chart 2: APK Downloaders Trajectory (Bar Chart) -->
        <div class="bg-white p-5 sm:p-6 rounded-[10px] border border-slate-200 shadow-xs space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-[8px] bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm border border-indigo-200">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h2 class="font-bold text-slate-900 text-sm">APK Downloads</h2>
                                <span class="text-[10px] font-mono font-bold bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-[6px] border border-indigo-200">Bar Chart</span>
                            </div>
                            <p class="text-[11px] text-slate-400">Daily package downloads histogram</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-[6px] border border-indigo-200">
                            {{ number_format($totalDownloads) }} Total
                        </span>
                        <a href="{{ route('admin.traffic.index', ['tab' => 'downloads']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                            Locations &rarr;
                        </a>
                    </div>
                </div>

                <div class="pt-4 relative w-full" style="height: 250px;">
                    <canvas id="dashboardDownloadsChart"></canvas>
                </div>
            </div>

            <!-- Mini Summary Footer -->
            <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-600">
                <div class="flex items-center space-x-3">
                    <span class="flex items-center space-x-1.5 font-medium">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                        <span>Today Downloads: <strong class="text-indigo-700 font-mono">+{{ number_format($todayDownloads) }}</strong></span>
                    </span>
                </div>
                <!-- Top Download Country Flags -->
                <div class="flex items-center space-x-1.5">
                    @foreach($topDownloadCountries as $dc)
                        @if($dc->flag_url)
                            <img src="{{ $dc->flag_url }}" 
                                 alt="{{ $dc->country_code }}" 
                                 title="{{ $dc->country }} ({{ $dc->count }} downloads)" 
                                 class="w-4 h-3 object-cover rounded-[2px] shadow-2xs border border-slate-200">
                        @else
                            <span title="{{ $dc->country }}">{{ $dc->flag_emoji }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Management Hub (4 Launcher Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <a href="{{ route('admin.screenshots.index') }}" 
           class="group bg-white p-4 rounded-[10px] border border-slate-200 shadow-xs hover:border-blue-300 hover:shadow-sm transition flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-[8px] bg-purple-50 text-purple-600 flex items-center justify-center text-base group-hover:bg-purple-600 group-hover:text-white transition">
                    <i class="fa-solid fa-images"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">Screenshots</div>
                    <div class="text-[11px] text-slate-400">Manage mobile gallery</div>
                </div>
            </div>
            <i class="fa-solid fa-arrow-right text-xs text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition"></i>
        </a>

        <a href="{{ route('admin.releases.index') }}" 
           class="group bg-white p-4 rounded-[10px] border border-slate-200 shadow-xs hover:border-blue-300 hover:shadow-sm transition flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-[8px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-base group-hover:bg-emerald-600 group-hover:text-white transition">
                    <i class="fa-solid fa-code-branch"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">Releases Archive</div>
                    <div class="text-[11px] text-slate-400">Publish &amp; checksums</div>
                </div>
            </div>
            <i class="fa-solid fa-arrow-right text-xs text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition"></i>
        </a>

        <a href="{{ route('admin.messages.index') }}" 
           class="group bg-white p-4 rounded-[10px] border border-slate-200 shadow-xs hover:border-blue-300 hover:shadow-sm transition flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center text-base group-hover:bg-amber-600 group-hover:text-white transition">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">User Inquiries</div>
                    <div class="text-[11px] text-slate-400">{{ $unreadMessages }} unread messages</div>
                </div>
            </div>
            <i class="fa-solid fa-arrow-right text-xs text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition"></i>
        </a>

        <a href="{{ route('admin.traffic.index') }}" 
           class="group bg-white p-4 rounded-[10px] border border-slate-200 shadow-xs hover:border-blue-300 hover:shadow-sm transition flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-[8px] bg-cyan-50 text-cyan-600 flex items-center justify-center text-base group-hover:bg-cyan-600 group-hover:text-white transition">
                    <i class="fa-solid fa-traffic-light"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">Traffic &amp; Shield</div>
                    <div class="text-[11px] text-slate-400">Rate limits &amp; GeoIP</div>
                </div>
            </div>
            <i class="fa-solid fa-arrow-right text-xs text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition"></i>
        </a>

    </div>

    <!-- Recent Inquiries Table (Max 10px Radius Card) -->
    <div class="bg-white border border-slate-200 rounded-[10px] shadow-xs overflow-hidden space-y-4 p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                    <i class="fa-solid fa-comments text-blue-600"></i>
                    <span>Recent User Inquiries</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Latest community inquiries, bug reports, and feedback submitted via Contact Us.</p>
            </div>
            <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                <span>View all inquiries</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[11px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto -mx-5 sm:mx-0">
            <table class="w-full text-left text-xs min-w-[640px]">
                <thead class="bg-slate-50 text-slate-600 uppercase font-bold border-y border-slate-200">
                    <tr>
                        <th class="px-4 py-3">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-user text-slate-400 text-[10px]"></i>
                                <span>Sender</span>
                            </span>
                        </th>
                        <th class="px-4 py-3">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-tag text-slate-400 text-[10px]"></i>
                                <span>Category</span>
                            </span>
                        </th>
                        <th class="px-4 py-3">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-heading text-slate-400 text-[10px]"></i>
                                <span>Subject</span>
                            </span>
                        </th>
                        <th class="px-4 py-3">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-clock text-slate-400 text-[10px]"></i>
                                <span>Date</span>
                            </span>
                        </th>
                        <th class="px-4 py-3">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-shield-halved text-slate-400 text-[10px]"></i>
                                <span>Status</span>
                            </span>
                        </th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($recentMessages as $msg)
                        <tr class="hover:bg-slate-50/70 transition {{ $msg->status === 'unread' ? 'bg-amber-50/20' : '' }}">
                            <td class="px-4 py-3 font-semibold text-slate-900">
                                <div>{{ $msg->name }}</div>
                                <div class="text-[11px] text-slate-400 font-normal font-mono">{{ $msg->email }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-[6px] bg-slate-100 text-slate-700 font-mono text-[11px]">
                                    {{ $msg->inquiry_type }}
                                </span>
                            </td>
                            <td class="px-4 py-3 truncate max-w-xs font-medium">{{ $msg->subject }}</td>
                            <td class="px-4 py-3 text-slate-400 font-mono text-[11px]">{{ $msg->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                @if($msg->status === 'unread')
                                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-[6px] bg-amber-100 text-amber-800 font-bold text-[10px]">
                                        <i class="fa-solid fa-envelope text-[9px]"></i>
                                        <span>Unread</span>
                                    </span>
                                @elseif($msg->status === 'replied')
                                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-[6px] bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                        <i class="fa-solid fa-reply text-[9px]"></i>
                                        <span>Replied</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-[6px] bg-slate-100 text-slate-600 font-semibold text-[10px] capitalize">
                                        <i class="fa-solid fa-check text-[9px]"></i>
                                        <span>{{ $msg->status }}</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.messages.show', $msg) }}" 
                                   class="inline-flex items-center px-2.5 py-1 rounded-[6px] bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white font-bold text-[11px] transition">
                                    <i class="fa-solid fa-eye mr-1"></i>
                                    <span>Review</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-slate-400 space-y-2">
                                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-lg">
                                    <i class="fa-regular fa-envelope-open"></i>
                                </div>
                                <div class="font-medium text-slate-600">No contact inquiries logged yet</div>
                                <div class="text-[11px]">Messages sent from the Contact page will appear here.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js Dashboard Charts Initialization -->
    <script>
        (function() {
            let attempts = 0;
            function initializeCharts() {
                if (typeof Chart === 'undefined') {
                    attempts++;
                    if (!document.getElementById('chartjs-local-script')) {
                        const script = document.createElement('script');
                        script.id = 'chartjs-local-script';
                        script.src = "{{ asset('js/chart.umd.min.js') }}";
                        script.onload = () => setTimeout(renderCharts, 50);
                        script.onerror = () => {
                            // Fallback to CDN if local fails
                            const cdnScript = document.createElement('script');
                            cdnScript.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                            cdnScript.onload = () => setTimeout(renderCharts, 50);
                            document.head.appendChild(cdnScript);
                        };
                        document.head.appendChild(script);
                    }
                    if (attempts < 50) {
                        setTimeout(initializeCharts, 100);
                    }
                    return;
                }
                renderCharts();
            }

            function renderCharts() {
                const chartLabels = @json($chartLabels);
                const trafficCounts = @json($trafficCounts);
                const trafficUniqueIps = @json($trafficUniqueIps);
                const downloadCounts = @json($downloadCounts);

                // 1. Web Traffic Spline Area Graph
                const trafficCanvas = document.getElementById('dashboardTrafficChart');
                if (trafficCanvas && !trafficCanvas.chartInstance) {
                    const ctxTraffic = trafficCanvas.getContext('2d');
                    const blueGradient = ctxTraffic.createLinearGradient(0, 0, 0, 240);
                    blueGradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
                    blueGradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

                    const greenGradient = ctxTraffic.createLinearGradient(0, 0, 0, 240);
                    greenGradient.addColorStop(0, 'rgba(16, 185, 129, 0.20)');
                    greenGradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

                    trafficCanvas.chartInstance = new Chart(ctxTraffic, {
                        type: 'line',
                        data: {
                            labels: chartLabels,
                            datasets: [
                                {
                                    label: 'HTTP Requests',
                                    data: trafficCounts,
                                    borderColor: '#2563eb',
                                    backgroundColor: blueGradient,
                                    borderWidth: 2.5,
                                    fill: true,
                                    tension: 0.38,
                                    pointBackgroundColor: '#2563eb',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 7
                                },
                                {
                                    label: 'Unique Visitors',
                                    data: trafficUniqueIps,
                                    borderColor: '#10b981',
                                    backgroundColor: greenGradient,
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.38,
                                    pointBackgroundColor: '#10b981',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 3.5,
                                    pointHoverRadius: 6
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    align: 'end',
                                    labels: {
                                        boxWidth: 8,
                                        usePointStyle: true,
                                        font: { size: 11, family: 'Poppins, sans-serif', weight: '600' }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    padding: 10,
                                    titleFont: { size: 12, weight: 'bold' },
                                    bodyFont: { size: 11 },
                                    cornerRadius: 8
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 11, family: 'monospace' }, color: '#64748b' }
                                },
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: 10,
                                    grid: { color: 'rgba(226, 232, 240, 0.7)' },
                                    ticks: {
                                        precision: 0,
                                        font: { size: 11, family: 'monospace' },
                                        color: '#64748b'
                                    }
                                }
                            }
                        }
                    });
                }

                // 2. APK Downloads Bar Histogram
                const downloadsCanvas = document.getElementById('dashboardDownloadsChart');
                if (downloadsCanvas && !downloadsCanvas.chartInstance) {
                    const ctxDownloads = downloadsCanvas.getContext('2d');
                    const indigoGradient = ctxDownloads.createLinearGradient(0, 0, 0, 240);
                    indigoGradient.addColorStop(0, '#6366f1');
                    indigoGradient.addColorStop(1, '#818cf8');

                    downloadsCanvas.chartInstance = new Chart(ctxDownloads, {
                        type: 'bar',
                        data: {
                            labels: chartLabels,
                            datasets: [
                                {
                                    label: 'APK Package Downloads',
                                    data: downloadCounts,
                                    backgroundColor: indigoGradient,
                                    hoverBackgroundColor: '#4f46e5',
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    maxBarThickness: 34
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    align: 'end',
                                    labels: {
                                        boxWidth: 8,
                                        usePointStyle: true,
                                        font: { size: 11, family: 'Poppins, sans-serif', weight: '600' }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    padding: 10,
                                    titleFont: { size: 12, weight: 'bold' },
                                    bodyFont: { size: 11 },
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function (context) {
                                            return ` ${context.raw} installations`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 11, family: 'monospace' }, color: '#64748b' }
                                },
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: 5,
                                    grid: { color: 'rgba(226, 232, 240, 0.7)' },
                                    ticks: {
                                        precision: 0,
                                        font: { size: 11, family: 'monospace' },
                                        color: '#64748b'
                                    }
                                }
                            }
                        }
                    });
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeCharts);
            } else {
                initializeCharts();
            }
        })();
    </script>

</x-admin.layout>
