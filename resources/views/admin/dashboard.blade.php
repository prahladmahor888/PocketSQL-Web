<x-admin.layout title="Admin Dashboard — PocketSQL">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
                <i class="fa-solid fa-gauge-high text-blue-600"></i>
                <span>System Overview Dashboard</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Real-time status of application distribution, releases, screenshots, and community inquiries.</p>
        </div>
        <div class="flex items-center space-x-2.5">
            <a href="{{ route('admin.settings') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-bold rounded-[8px] bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 shadow-xs transition">
                <i class="fa-solid fa-sliders mr-2 text-slate-500"></i>
                <span>Site Settings</span>
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

        <a href="{{ route('admin.settings') }}" 
           class="group bg-white p-4 rounded-[10px] border border-slate-200 shadow-xs hover:border-blue-300 hover:shadow-sm transition flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-base group-hover:bg-blue-600 group-hover:text-white transition">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">Global Config</div>
                    <div class="text-[11px] text-slate-400">Settings &amp; socials</div>
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

</x-admin.layout>
