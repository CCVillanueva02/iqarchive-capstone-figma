<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IQArchive — Developer Sandbox</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via Vite or fallback CDN for safety) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-950 via-stone-900 to-zinc-950 min-h-full flex flex-col justify-center items-center p-6 antialiased">
    <div class="w-full max-w-xl bg-slate-900/60 backdrop-blur-xl border border-slate-800/80 rounded-3xl shadow-2xl p-8 md:p-10 flex flex-col gap-6">
        
        <!-- Header Section -->
        <div class="flex flex-col items-center text-center">
            <!-- Neon Warning Badge -->
            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-500 text-body-sm font-semibold uppercase tracking-wider mb-4">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Local Sandbox Mode</span>
            </div>

            <!-- Title -->
            <h1 class="text-heading-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-300 tracking-tight">IQArchive Dev Switcher</h1>
            <p class="text-body text-slate-400 mt-2 max-w-xs">Instantly log in as any role without credentials. Exclusively available in local environment.</p>
        </div>

        <hr class="border-slate-800" />

        <!-- Single Role Accounts Grid (6 Roles Scale) -->
        <div class="flex flex-col gap-3">
            <h2 class="text-body-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <span>Single Role Accounts</span>
                <span class="text-label bg-slate-800 text-slate-400 px-2 py-0.5 rounded-full font-normal">6 Core Roles</span>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <!-- System Admin -->
                <a href="{{ route('dev.login', 'system-administrator') }}" class="group flex flex-col p-3.5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-orange-500/50 hover:bg-slate-850/50 transition-all duration-200 shadow-sm">
                    <span class="text-sm font-semibold text-slate-100 group-hover:text-orange-400 transition-colors">System Administrator</span>
                    <span class="text-xs text-slate-500 mt-0.5 font-mono">sysadmin@example.com</span>
                </a>

                <!-- IQA Staff -->
                <a href="{{ route('dev.login', 'iqa-staff') }}" class="group flex flex-col p-3.5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-orange-500/50 hover:bg-slate-850/50 transition-all duration-200 shadow-sm">
                    <span class="text-sm font-semibold text-slate-100 group-hover:text-orange-400 transition-colors">IQA Member</span>
                    <span class="text-xs text-slate-500 mt-0.5 font-mono">iqastaff@example.com</span>
                </a>

                <!-- Accreditor -->
                <a href="{{ route('dev.login', 'accreditor') }}" class="group flex flex-col p-3.5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-orange-500/50 hover:bg-slate-850/50 transition-all duration-200 shadow-sm">
                    <span class="text-sm font-semibold text-slate-100 group-hover:text-orange-400 transition-colors">AACCUP Accreditor</span>
                    <span class="text-xs text-slate-500 mt-0.5 font-mono">accreditor@example.com</span>
                </a>

                <!-- BU Executive -->
                <a href="{{ route('dev.login', 'university-administrator') }}" class="group flex flex-col p-3.5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-orange-500/50 hover:bg-slate-850/50 transition-all duration-200 shadow-sm">
                    <span class="text-sm font-semibold text-slate-100 group-hover:text-orange-400 transition-colors">BU Executive</span>
                    <span class="text-xs text-slate-500 mt-0.5 font-mono">buexecutive@example.com</span>
                </a>

                <!-- College Head -->
                <a href="{{ route('dev.login', 'college-head') }}" class="group flex flex-col p-3.5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-orange-500/50 hover:bg-slate-850/50 transition-all duration-200 shadow-sm">
                    <span class="text-sm font-semibold text-slate-100 group-hover:text-orange-400 transition-colors">College Head</span>
                    <span class="text-xs text-slate-500 mt-0.5 font-mono">dean@example.com</span>
                </a>

                <!-- Task Force Member -->
                <a href="{{ route('dev.login', 'task-force-member') }}" class="group flex flex-col p-3.5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-orange-500/50 hover:bg-slate-850/50 transition-all duration-200 shadow-sm">
                    <span class="text-sm font-semibold text-slate-100 group-hover:text-orange-400 transition-colors">Task Force</span>
                    <span class="text-xs text-slate-500 mt-0.5 font-mono">tfmember@example.com</span>
                </a>
            </div>
        </div>

        <hr class="border-slate-800" />

        <!-- Multi-Role Accounts Grid -->
        <div class="flex flex-col gap-3">
            <h2 class="text-xs font-bold text-orange-400 uppercase tracking-wider flex items-center gap-2">
                <span>Multi-Role Accounts (Role Switcher Demo)</span>
                <span class="text-[10px] bg-orange-500/20 text-orange-300 px-2 py-0.5 rounded-full font-bold">Multi View</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <!-- IQA Staff + Task Force Member -->
                <a href="{{ route('dev.login', 'iqa-staff-multi') }}" class="group flex flex-col p-3.5 bg-slate-900 border border-orange-500/30 rounded-2xl hover:border-orange-500 hover:bg-slate-850 transition-all duration-200 shadow-sm">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs font-bold text-orange-400">IQA Member</span>
                        <span class="text-xs text-slate-300 font-semibold flex items-center gap-1">
                            <span>+ Task Force Member</span>
                        </span>
                    </div>
                    <span class="text-[11px] text-slate-500 mt-2 font-mono truncate">iqastaff-multi@example.com</span>
                </a>

                <!-- College Head + Task Force Member -->
                <a href="{{ route('dev.login', 'dean-multi') }}" class="group flex flex-col p-3.5 bg-slate-900 border border-orange-500/30 rounded-2xl hover:border-orange-500 hover:bg-slate-850 transition-all duration-200 shadow-sm">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs font-bold text-orange-400">College Head</span>
                        <span class="text-xs text-slate-300 font-semibold flex items-center gap-1">
                            <span>+ Task Force Member</span>
                        </span>
                    </div>
                    <span class="text-[11px] text-slate-500 mt-2 font-mono truncate">dean-multi@example.com</span>
                </a>
            </div>
        </div>

        <hr class="border-slate-800" />

        <!-- Footer link back to standard login -->
        <div class="flex justify-between items-center text-xs text-slate-500">
            <span>&copy; {{ date('Y') }} Bicol University</span>
            <a href="{{ route('login') }}" class="flex items-center gap-1 hover:text-slate-300 transition-colors font-medium">
                <span>Standard Login</span>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</body>
</html>
