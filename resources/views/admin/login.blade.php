<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PocketSQL Admin Authentication</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <!-- Local Compiled Tailwind CSS & Font Awesome Icons via Vite Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .rounded-10, button, input {
            border-radius: 10px !important;
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 font-sans">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center space-y-3">
        <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 group">
            <img src="{{ asset('images/logo.png') }}" alt="PocketSQL" class="h-12 w-12 rounded-[10px] object-cover shadow-sm border border-slate-200 transition-transform group-hover:scale-105">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">Pocket<span class="text-blue-600">SQL</span></div>
                <div class="text-[10px] font-mono text-slate-400 font-bold uppercase tracking-wider mt-1">Admin Console</div>
            </div>
        </a>
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight pt-2">Sign In to Control Center</h2>
        <p class="text-xs text-slate-500">Manage releases, screenshots, traffic handler, and live system policies.</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-sm border border-slate-200 rounded-[10px] sm:px-10 space-y-6">
            
            <!-- Rate Limiter & Session Expire Security Notice -->
            <div class="p-3 bg-blue-50/70 border border-blue-200/80 rounded-[8px] flex items-center justify-between text-xs text-blue-900">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-shield-halved text-blue-600"></i>
                    <span class="font-semibold text-[11px]">Strict Security: Only 3 Attempts</span>
                </div>
                <span class="font-mono text-[10px] bg-white px-2 py-0.5 rounded border border-blue-200 text-blue-700 font-bold">
                    Auto-Expire
                </span>
            </div>

            @if(session('success'))
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-[8px] flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-3.5 bg-red-50 border border-red-300 text-red-900 text-xs rounded-[8px] space-y-1">
                    <div class="flex items-center space-x-2 font-bold text-red-700">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Authentication Warning</span>
                    </div>
                    <p class="text-[11px] leading-relaxed text-red-800">
                        {{ $errors->first() }}
                    </p>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-envelope text-slate-400 text-[11px]"></i>
                        <span>Admin Email Address</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required 
                           value="{{ old('email', 'admin@pocketsql.app') }}"
                           class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs text-slate-900 font-mono">
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-lock text-slate-400 text-[11px]"></i>
                        <span>Password</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           value="password"
                           class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs text-slate-900 font-mono">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>Remember session</span>
                    </label>
                    <span class="text-slate-400 font-mono text-[11px]">Demo: password</span>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm shadow-blue-500/20 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Authenticate &amp; Access Dashboard</span>
                    </button>
                </div>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-blue-600 font-medium inline-flex items-center space-x-1.5 transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Return to public homepage</span>
                </a>
            </div>

        </div>
    </div>

</body>
</html>
