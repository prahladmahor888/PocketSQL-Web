<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-white antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Forbidden | PocketSQL</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex items-center justify-center p-4 font-sans bg-slate-950">
    <div class="max-w-md w-full text-center space-y-6 bg-slate-900 border border-red-500/30 rounded-[10px] p-8 shadow-2xl relative overflow-hidden">
        <div class="w-16 h-16 rounded-[10px] bg-red-500/10 border border-red-500/30 text-red-500 flex items-center justify-center mx-auto text-2xl shadow-lg">
            <i class="fa-solid fa-lock"></i>
        </div>
        
        <div class="space-y-2">
            <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-[10px] bg-red-500/10 text-red-400 font-mono text-xs border border-red-500/20">
                <i class="fa-solid fa-ban text-[11px]"></i>
                <span>HTTP 403 • Authorization Required</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white">Access Forbidden</h1>
            <p class="text-xs text-slate-400 leading-relaxed">
                You do not have administrative authorization to access this private resource.
            </p>
        </div>

        <div class="pt-2">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-[10px] bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-md transition">
                <i class="fa-solid fa-house mr-1.5"></i>
                <span>Return to Homepage</span>
            </a>
        </div>
    </div>
</body>
</html>
