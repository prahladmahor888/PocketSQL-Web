<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-white antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>429 — Rate Limit Exceeded | PocketSQL Traffic Handler</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex items-center justify-center p-4 font-sans bg-slate-950">
    <div class="max-w-md w-full text-center space-y-6 bg-slate-900 border border-amber-500/30 rounded-[10px] p-8 shadow-2xl relative overflow-hidden">
        <div class="w-16 h-16 rounded-[10px] bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center mx-auto text-2xl shadow-lg">
            <i class="fa-solid fa-gauge-simple-high"></i>
        </div>
        
        <div class="space-y-2">
            <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-[10px] bg-amber-500/10 text-amber-400 font-mono text-xs border border-amber-500/20">
                <i class="fa-solid fa-hourglass-half text-[11px]"></i>
                <span>HTTP 429 • Traffic Handler Cooldown</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white">Rate Limit Exceeded</h1>
            <p class="text-xs text-slate-400 leading-relaxed">
                You have sent too many requests in a short period. To protect server health, your request rate is temporarily throttled.
            </p>
        </div>

        <div class="bg-slate-950/80 rounded-[10px] border border-white/10 p-4 text-xs font-mono text-left space-y-2">
            <div class="flex justify-between items-center text-slate-400">
                <span>Client IP:</span>
                <span class="text-slate-200 font-bold">{{ $ip ?? request()->ip() }}</span>
            </div>
            <div class="flex justify-between items-center text-slate-400">
                <span>Request Limit:</span>
                <span class="text-blue-400 font-bold">{{ $limit ?? 120 }} req/min</span>
            </div>
            <div class="flex justify-between items-center text-slate-400 border-t border-white/10 pt-2">
                <span>Retry Available In:</span>
                <span class="text-amber-400 font-bold text-sm">{{ $seconds ?? 60 }} seconds</span>
            </div>
        </div>

        <div class="pt-2">
            <button onclick="window.location.reload()" 
                    class="w-full py-2.5 px-4 rounded-[10px] bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs shadow-md transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-rotate-right"></i>
                <span>Retry Connection</span>
            </button>
        </div>
    </div>
</body>
</html>
