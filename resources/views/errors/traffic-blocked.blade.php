<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-white antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Access Restricted | PocketSQL Traffic Shield</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex items-center justify-center p-4 font-sans bg-slate-950">
    <div class="max-w-md w-full text-center space-y-6 bg-slate-900 border border-red-500/30 rounded-[10px] p-8 shadow-2xl relative overflow-hidden">
        <div class="w-16 h-16 rounded-[10px] bg-red-500/10 border border-red-500/30 text-red-500 flex items-center justify-center mx-auto text-2xl shadow-lg">
            <i class="fa-solid fa-shield-virus"></i>
        </div>
        
        <div class="space-y-2">
            <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-[10px] bg-red-500/10 text-red-400 font-mono text-xs border border-red-500/20">
                <i class="fa-solid fa-ban text-[11px]"></i>
                <span>HTTP 403 • Restricted by Traffic Handler</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white">Access Restricted</h1>
            <p class="text-xs text-slate-400 leading-relaxed">
                {{ $message ?? 'Your IP address has been restricted by the PocketSQL Traffic Shield due to security policies or excessive activity.' }}
            </p>
        </div>

        <div class="bg-slate-950/80 rounded-[10px] border border-white/10 p-3.5 text-xs font-mono text-left space-y-1">
            <div class="text-slate-400 flex justify-between">
                <span>Client IP:</span>
                <span class="text-red-400 font-bold">{{ $ip ?? request()->ip() }}</span>
            </div>
            <div class="text-slate-400 flex justify-between">
                <span>Timestamp:</span>
                <span class="text-slate-300">{{ now()->toIso8601String() }}</span>
            </div>
        </div>

        <div class="pt-2 text-xs text-slate-500">
            If you believe this restriction is an error, please reach out via <a href="mailto:support@pocketsql.app" class="text-blue-400 hover:underline">support@pocketsql.app</a> with your IP address.
        </div>
    </div>
</body>
</html>
