<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-white antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Page Not Found | PocketSQL</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex items-center justify-center p-4 font-sans bg-slate-950">
    <div class="max-w-md w-full text-center space-y-6 bg-slate-900 border border-slate-800 rounded-[10px] p-8 shadow-2xl relative overflow-hidden">
        <div class="w-16 h-16 rounded-[10px] bg-blue-500/10 border border-blue-500/30 text-blue-500 flex items-center justify-center mx-auto text-2xl shadow-lg">
            <i class="fa-solid fa-compass"></i>
        </div>
        
        <div class="space-y-2">
            <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-[10px] bg-blue-500/10 text-blue-400 font-mono text-xs border border-blue-500/20">
                <i class="fa-solid fa-circle-notch text-[11px]"></i>
                <span>HTTP 404 • Resource Missing</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white">Page Not Found</h1>
            <p class="text-xs text-slate-400 leading-relaxed">
                The requested URL does not exist or has been relocated to another section.
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
