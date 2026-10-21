<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'PocketSQL Administration Console' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .rounded-10, button, input, select, textarea {
            border-radius: 10px !important;
        }
    </style>
</head>
<body class="min-h-full flex flex-col font-sans text-slate-800" x-data>

    <!-- Top Admin Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.svg') }}" alt="PocketSQL" class="h-8 w-auto">
                    <span class="text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded-[6px] bg-blue-100 text-blue-800">Admin</span>
                </a>

                <nav class="hidden md:flex items-center space-x-2 text-sm font-semibold">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-3 py-1.5 rounded-[8px] {{ Route::is('admin.dashboard') ? 'bg-slate-100 text-blue-600' : 'text-slate-600 hover:text-slate-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.messages.index') }}" 
                       class="px-3 py-1.5 rounded-[8px] {{ Route::is('admin.messages*') ? 'bg-slate-100 text-blue-600' : 'text-slate-600 hover:text-slate-900' }}">
                        Inquiries
                    </a>
                    <a href="{{ route('admin.releases.index') }}" 
                       class="px-3 py-1.5 rounded-[8px] {{ Route::is('admin.releases*') ? 'bg-slate-100 text-blue-600' : 'text-slate-600 hover:text-slate-900' }}">
                        Releases
                    </a>
                    <a href="{{ route('admin.settings') }}" 
                       class="px-3 py-1.5 rounded-[8px] {{ Route::is('admin.settings') ? 'bg-slate-100 text-blue-600' : 'text-slate-600 hover:text-slate-900' }}">
                        Settings
                    </a>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs font-semibold text-slate-500 hover:text-blue-600 transition flex items-center">
                    <span>View Public Site</span>
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-red-600 hover:bg-red-50 rounded-[8px] transition border border-red-200">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Admin Container -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="p-4 rounded-[10px] bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-[10px] bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        PocketSQL Administration Console • Version 1.0.5 Engine
    </footer>

</body>
</html>
