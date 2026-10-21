<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'PocketSQL Administration Console' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Google Fonts: Poppins & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Local Compiled Tailwind CSS & Font Awesome Icons via Vite Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .rounded-10, button, input, select, textarea {
            border-radius: 10px !important;
        }
    </style>
</head>
<body class="min-h-full bg-slate-50 font-sans text-slate-800" x-data="{ sidebarOpen: false }">

    @php
        $unreadCount = \App\Models\ContactMessage::where('status', 'unread')->count();
        $screenshotCount = \App\Models\Screenshot::count();
        $releaseCount = \App\Models\Release::count();
        $settings = \App\Models\AppSetting::instance();
    @endphp

    <div class="min-h-screen flex">
        
        <!-- ============================================== -->
        <!-- 1. MOBILE BACKDROP                             -->
        <!-- ============================================== -->
        <div x-show="sidebarOpen" 
             x-cloak 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs md:hidden"></div>

        <!-- ============================================== -->
        <!-- 2. DESKTOP & MOBILE SIDEBAR                    -->
        <!-- ============================================== -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 flex flex-col justify-between transition-transform duration-200 ease-in-out md:translate-x-0 md:static md:inset-auto"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div class="flex flex-col flex-grow overflow-y-auto">
                
                <!-- Sidebar Brand Header -->
                <div class="h-20 flex items-center justify-between px-5 border-b border-slate-200 bg-white sticky top-0 z-10">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <img src="{{ asset('images/logo.png') }}" alt="PocketSQL" class="h-10 w-10 rounded-[10px] object-cover border border-slate-200 shadow-sm transition-transform duration-200 group-hover:scale-105">
                            <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center space-x-1.5">
                                <span class="text-lg font-extrabold text-slate-900 tracking-tight">Pocket<span class="text-blue-600">SQL</span></span>
                                <span class="text-[9px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded-[6px] bg-blue-100 text-blue-800">Admin</span>
                            </div>
                            <span class="text-[10px] font-mono text-slate-400">Control Console</span>
                        </div>
                    </a>

                    <!-- Close button for mobile -->
                    <button type="button" 
                            @click="sidebarOpen = false" 
                            class="md:hidden p-2 text-slate-400 hover:text-slate-700 rounded-[8px] hover:bg-slate-100 transition"
                            aria-label="Close sidebar">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Navigation Links List -->
                <div class="px-4 py-5 space-y-6">
                    
                    <!-- Section: Core Management -->
                    <div class="space-y-1">
                        <div class="flex items-center justify-between px-3 mb-2">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Main Menu</span>
                            <span class="text-[10px] font-mono text-slate-400">{{ str_starts_with($settings->current_version, 'v') ? $settings->current_version : 'v' . $settings->current_version }}</span>
                        </div>
                        
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="group flex items-center justify-between px-3 py-2.5 rounded-[10px] text-xs font-semibold transition {{ Route::is('admin.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-[8px] flex items-center justify-center text-xs transition {{ Route::is('admin.dashboard') ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-600 group-hover:bg-blue-100' }}">
                                    <i class="fa-solid fa-gauge-high"></i>
                                </div>
                                <span>Dashboard</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-[10px] transition group-hover:translate-x-0.5 {{ Route::is('admin.dashboard') ? 'text-white/70' : 'text-slate-300' }}"></i>
                        </a>

                        <!-- Screenshots -->
                        <a href="{{ route('admin.screenshots.index') }}" 
                           class="group flex items-center justify-between px-3 py-2.5 rounded-[10px] text-xs font-semibold transition {{ Route::is('admin.screenshots*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-[8px] flex items-center justify-center text-xs transition {{ Route::is('admin.screenshots*') ? 'bg-white/20 text-white' : 'bg-purple-50 text-purple-600 group-hover:bg-purple-100' }}">
                                    <i class="fa-solid fa-mobile-screen"></i>
                                </div>
                                <span>Screenshots</span>
                            </div>
                            <span class="text-[10px] px-2 py-0.5 rounded-[6px] font-mono font-bold {{ Route::is('admin.screenshots*') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $screenshotCount }}
                            </span>
                        </a>

                        <!-- Releases -->
                        <a href="{{ route('admin.releases.index') }}" 
                           class="group flex items-center justify-between px-3 py-2.5 rounded-[10px] text-xs font-semibold transition {{ Route::is('admin.releases*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-[8px] flex items-center justify-center text-xs transition {{ Route::is('admin.releases*') ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100' }}">
                                    <i class="fa-solid fa-code-branch"></i>
                                </div>
                                <span>Releases Archive</span>
                            </div>
                            <span class="text-[10px] px-2 py-0.5 rounded-[6px] font-mono font-bold {{ Route::is('admin.releases*') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $releaseCount }}
                            </span>
                        </a>

                        <!-- Inquiries / Messages -->
                        <a href="{{ route('admin.messages.index') }}" 
                           class="group flex items-center justify-between px-3 py-2.5 rounded-[10px] text-xs font-semibold transition {{ Route::is('admin.messages*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-[8px] flex items-center justify-center text-xs transition {{ Route::is('admin.messages*') ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-600 group-hover:bg-amber-100' }}">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <span>User Inquiries</span>
                            </div>
                            @if($unreadCount > 0)
                                <span class="text-[10px] px-2 py-0.5 rounded-[6px] bg-amber-500 text-white font-bold inline-flex items-center space-x-1 animate-pulse">
                                    <i class="fa-solid fa-bell text-[9px]"></i>
                                    <span>{{ $unreadCount }} new</span>
                                </span>
                            @else
                                <span class="text-[10px] px-2 py-0.5 rounded-[6px] font-mono font-bold {{ Route::is('admin.messages*') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                    {{ \App\Models\ContactMessage::count() }}
                                </span>
                            @endif
                        </a>

                        <!-- Settings -->
                        <a href="{{ route('admin.settings') }}" 
                           class="group flex items-center justify-between px-3 py-2.5 rounded-[10px] text-xs font-semibold transition {{ Route::is('admin.settings') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-[8px] flex items-center justify-center text-xs transition {{ Route::is('admin.settings') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
                                    <i class="fa-solid fa-sliders"></i>
                                </div>
                                <span>Site Settings</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-[10px] transition group-hover:translate-x-0.5 {{ Route::is('admin.settings') ? 'text-white/70' : 'text-slate-300' }}"></i>
                        </a>

                        <!-- Traffic Manager & Handler -->
                        <a href="{{ route('admin.traffic.index') }}" 
                           class="group flex items-center justify-between px-3 py-2.5 rounded-[10px] text-xs font-semibold transition {{ Route::is('admin.traffic*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-[8px] flex items-center justify-center text-xs transition {{ Route::is('admin.traffic*') ? 'bg-white/20 text-white' : 'bg-cyan-50 text-cyan-600 group-hover:bg-cyan-100' }}">
                                    <i class="fa-solid fa-traffic-light"></i>
                                </div>
                                <span>Traffic Manager</span>
                            </div>
                            <span class="text-[10px] px-2 py-0.5 rounded-[6px] font-mono font-bold {{ Route::is('admin.traffic*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-600' }}">
                                Shield
                            </span>
                        </a>
                    </div>

                    <!-- Section: Public Web Shortcuts -->
                    <div class="space-y-1 pt-2 border-t border-slate-100">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-2">Live Public Site</span>
                        
                        <a href="{{ route('home') }}" target="_blank" 
                           class="flex items-center justify-between px-3 py-2 rounded-[8px] text-xs text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition group">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-globe w-4 text-center text-slate-400 group-hover:text-blue-600"></i>
                                <span>View Website</span>
                            </div>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-300 group-hover:text-blue-500"></i>
                        </a>

                        <a href="{{ route('docs') }}" target="_blank" 
                           class="flex items-center justify-between px-3 py-2 rounded-[8px] text-xs text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition group">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-book-bookmark w-4 text-center text-slate-400 group-hover:text-blue-600"></i>
                                <span>API Documentation</span>
                            </div>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-300 group-hover:text-blue-500"></i>
                        </a>

                        <a href="{{ route('download') }}" target="_blank" 
                           class="flex items-center justify-between px-3 py-2 rounded-[8px] text-xs text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition group">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-download w-4 text-center text-slate-400 group-hover:text-blue-600"></i>
                                <span>Download Hub</span>
                            </div>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-300 group-hover:text-blue-500"></i>
                        </a>
                    </div>

                    <!-- System Status Mini Card -->
                    <div class="p-3.5 rounded-[10px] bg-slate-50 border border-slate-200 text-xs space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-700 flex items-center space-x-1.5">
                                <i class="fa-solid fa-server text-blue-600 text-[11px]"></i>
                                <span>Daemon Status:</span>
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-[10px] font-bold {{ $settings->api_server_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $settings->api_server_active ? 'bg-emerald-500 animate-ping' : 'bg-slate-400' }} mr-1.5"></span>
                                {{ $settings->api_server_active ? 'Port 8080 Active' : 'Offline' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] font-mono text-slate-500">
                            <span>Build Code:</span>
                            <span class="font-bold">#{{ $settings->version_code }}</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Sidebar User & Logout Footer -->
            <div class="p-4 border-t border-slate-200 bg-slate-50/70">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2.5 overflow-hidden">
                        <div class="w-9 h-9 rounded-[8px] bg-blue-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-xs">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-xs font-bold text-slate-900 truncate">PocketSQL Admin</div>
                            <div class="text-[10px] text-slate-500 font-mono truncate">{{ Auth::user()->email ?? 'admin@pocketsql.app' }}</div>
                        </div>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                title="Sign out"
                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-[8px] transition"
                                aria-label="Sign out">
                            <i class="fa-solid fa-power-off text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- ============================================== -->
        <!-- 3. MAIN CONTENT AREA WITH TOP NAV BAR          -->
        <!-- ============================================== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Topbar Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20">
                
                <div class="flex items-center space-x-3">
                    <!-- Mobile Hamburger -->
                    <button type="button" 
                            @click="sidebarOpen = true"
                            class="md:hidden p-2 text-slate-600 hover:text-slate-900 rounded-[8px] hover:bg-slate-100 transition"
                            aria-label="Open sidebar">
                        <i class="fa-solid fa-bars-staggered text-base"></i>
                    </button>

                    <!-- Breadcrumbs / Section Title -->
                    <div class="flex items-center space-x-2 text-xs">
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-blue-600 flex items-center space-x-1">
                            <i class="fa-solid fa-house text-[11px]"></i>
                            <span class="hidden sm:inline">Admin</span>
                        </a>
                        <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                        <span class="font-bold text-slate-900 flex items-center space-x-1.5">
                            @if(Route::is('admin.dashboard')) 
                                <i class="fa-solid fa-gauge-high text-blue-600"></i>
                                <span>Dashboard</span>
                            @elseif(Route::is('admin.screenshots*')) 
                                <i class="fa-solid fa-mobile-screen text-purple-600"></i>
                                <span>Screenshots Manager</span>
                            @elseif(Route::is('admin.releases*')) 
                                <i class="fa-solid fa-code-branch text-emerald-600"></i>
                                <span>Releases Archive</span>
                            @elseif(Route::is('admin.messages*')) 
                                <i class="fa-solid fa-envelope text-amber-600"></i>
                                <span>User Inquiries</span>
                            @elseif(Route::is('admin.settings')) 
                                <i class="fa-solid fa-sliders text-slate-700"></i>
                                <span>Site Settings</span>
                            @elseif(Route::is('admin.traffic*')) 
                                <i class="fa-solid fa-traffic-light text-cyan-600"></i>
                                <span>Traffic Manager &amp; Handler</span>
                            @else 
                                <i class="fa-solid fa-shield-halved text-blue-600"></i>
                                <span>Console</span>
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Right Topbar Controls -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <!-- Session Inactivity Status Badge -->
                    <div class="hidden md:flex items-center space-x-1.5 px-2.5 py-1 rounded-[8px] bg-slate-100 border border-slate-200 text-[11px] font-mono text-slate-600" title="Admin Session Inactivity Timeout Policy">
                        <i class="fa-solid fa-clock-rotate-left text-amber-500 text-[10px]"></i>
                        <span>Timeout: {{ $settings->admin_session_lifetime_minutes ?? 15 }}m</span>
                    </div>
                    <!-- Quick Public Website Button -->
                    <a href="{{ route('home') }}" target="_blank" 
                       class="inline-flex items-center px-3 py-1.5 rounded-[8px] text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-blue-600 shadow-xs transition">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1.5 text-blue-600"></i>
                        <span class="hidden sm:inline">Live Site</span>
                    </a>

                    <div class="h-4 w-px bg-slate-200"></div>

                    <!-- Direct Logout Button -->
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-1.5 rounded-[8px] text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 transition border border-red-200">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-1.5"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Body Container -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6">
                
                <!-- Flash Alerts -->
                @if(session('success'))
                    <div class="p-4 rounded-[10px] bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-circle-check text-xs"></i>
                            </div>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 rounded-[10px] bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                <i class="fa-solid fa-circle-exclamation text-xs"></i>
                            </div>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 py-3.5 px-4 sm:px-6 lg:px-8 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-database text-blue-600"></i>
                    <span>PocketSQL Administration Console • Engine v{{ $settings->current_version }}</span>
                </div>
                <div class="flex items-center space-x-3 font-mono text-[11px] text-slate-400">
                    <span><i class="fa-brands fa-php mr-1"></i>PHP {{ phpversion() }}</span>
                    <span>•</span>
                    <span><i class="fa-brands fa-laravel mr-1 text-red-500"></i>Laravel 12</span>
                </div>
            </footer>

        </div>

    </div>

</body>
</html>
