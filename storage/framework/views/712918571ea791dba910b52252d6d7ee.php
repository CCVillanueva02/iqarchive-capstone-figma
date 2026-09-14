
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IQArchive — Developer Sandbox</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (Play CDN with standalone dark theme configuration) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        'slate-850': '#172033',
                        'slate-950': '#020617',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-950 bg-linear-to-br from-slate-950 via-slate-900 to-zinc-950 min-h-screen flex flex-col justify-center items-center p-4 md:p-6 text-slate-100 font-sans antialiased selection:bg-amber-500/30 selection:text-amber-200">
    <div class="w-full max-w-xl bg-slate-900/80 backdrop-blur-2xl border border-slate-800/90 rounded-3xl shadow-2xl shadow-black/60 p-6 md:p-8 flex flex-col gap-6 my-auto">
        
        <!-- Header Section -->
        <div class="flex flex-col items-center text-center">
            <!-- Neon Warning Badge -->
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-wider mb-3 shadow-inner">
                <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Local Sandbox Mode</span>
            </div>

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-linear-to-r from-amber-400 via-amber-300 to-yellow-200 tracking-tight">
                IQArchive Dev Switcher
            </h1>
            <p class="text-sm text-slate-400 mt-2 max-w-sm leading-relaxed">
                Instantly log in as any role without credentials. Exclusively available in local environment.
            </p>
        </div>

        <hr class="border-slate-800/80" />

        <!-- Single Role Accounts Grid (6 Roles Scale) -->
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <span>Single Role Accounts</span>
                </h2>
                <span class="text-xs font-medium bg-slate-800/80 border border-slate-700/50 text-slate-300 px-2.5 py-0.5 rounded-full">6 Core Roles</span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- System Admin -->
                <a href="<?php echo e(route('dev.login', 'system-administrator')); ?>" class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-850/70 hover:shadow-lg hover:shadow-amber-500/5 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:outline-none transition-all duration-150 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-100 group-hover:text-amber-400 transition-colors">System Administrator</span>
                        <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-amber-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-1.5 font-mono">sysadmin@example.com</span>
                </a>

                <!-- IQA Staff -->
                <a href="<?php echo e(route('dev.login', 'iqa-staff')); ?>" class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-850/70 hover:shadow-lg hover:shadow-amber-500/5 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:outline-none transition-all duration-150 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-100 group-hover:text-amber-400 transition-colors">IQA Member</span>
                        <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-amber-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-1.5 font-mono">iqastaff@example.com</span>
                </a>

                <!-- Accreditor -->
                <a href="<?php echo e(route('dev.login', 'accreditor')); ?>" class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-850/70 hover:shadow-lg hover:shadow-amber-500/5 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:outline-none transition-all duration-150 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-100 group-hover:text-amber-400 transition-colors">AACCUP Accreditor</span>
                        <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-amber-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-1.5 font-mono">accreditor@example.com</span>
                </a>

                <!-- BU Executive -->
                <a href="<?php echo e(route('dev.login', 'university-administrator')); ?>" class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-850/70 hover:shadow-lg hover:shadow-amber-500/5 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:outline-none transition-all duration-150 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-100 group-hover:text-amber-400 transition-colors">BU Executive</span>
                        <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-amber-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-1.5 font-mono">buexecutive@example.com</span>
                </a>

                <!-- College Head -->
                <a href="<?php echo e(route('dev.login', 'college-head')); ?>" class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-850/70 hover:shadow-lg hover:shadow-amber-500/5 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:outline-none transition-all duration-150 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-100 group-hover:text-amber-400 transition-colors">College Head</span>
                        <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-amber-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-1.5 font-mono">dean@example.com</span>
                </a>

                <!-- Task Force Member -->
                <a href="<?php echo e(route('dev.login', 'task-force-member')); ?>" class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-850/70 hover:shadow-lg hover:shadow-amber-500/5 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:outline-none transition-all duration-150 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-100 group-hover:text-amber-400 transition-colors">Task Force</span>
                        <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-amber-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-1.5 font-mono">tfmember@example.com</span>
                </a>
            </div>
        </div>

        <hr class="border-slate-800/80" />

        <!-- Multi-Role Accounts Grid -->
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <h2 class="text-xs font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                    <span>Multi-Role Accounts (Role Switcher Demo)</span>
                </h2>
                <span class="text-xs font-semibold bg-amber-500/10 border border-amber-500/30 text-amber-300 px-2.5 py-0.5 rounded-full">Multi View</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- IQA Staff + Task Force Member -->
                <a href="<?php echo e(route('dev.login', 'iqa-staff-multi')); ?>" class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-amber-500/30 rounded-2xl hover:border-amber-400 hover:bg-slate-850/80 hover:shadow-lg hover:shadow-amber-500/10 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:outline-none transition-all duration-150 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-bold text-amber-400">IQA Member</span>
                            <span class="text-xs text-slate-200 font-medium flex items-center gap-1">
                                <span>+ Task Force Member</span>
                            </span>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider bg-amber-500/15 text-amber-300 border border-amber-500/30 px-1.5 py-0.5 rounded">Dual</span>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-2.5 font-mono truncate">iqastaff-multi@example.com</span>
                </a>

                <!-- College Head + Task Force Member -->
                <a href="<?php echo e(route('dev.login', 'dean-multi')); ?>" class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-amber-500/30 rounded-2xl hover:border-amber-400 hover:bg-slate-850/80 hover:shadow-lg hover:shadow-amber-500/10 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:outline-none transition-all duration-150 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-bold text-amber-400">College Head</span>
                            <span class="text-xs text-slate-200 font-medium flex items-center gap-1">
                                <span>+ Task Force Member</span>
                            </span>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider bg-amber-500/15 text-amber-300 border border-amber-500/30 px-1.5 py-0.5 rounded">Dual</span>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-2.5 font-mono truncate">dean-multi@example.com</span>
                </a>
            </div>
        </div>

        <hr class="border-slate-800/80" />

        <!-- Footer link back to standard login -->
        <div class="flex justify-between items-center text-xs text-slate-400 pt-1">
            <span>&copy; <?php echo e(date('Y')); ?> Bicol University</span>
            <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-1 text-slate-400 hover:text-amber-300 transition-colors font-medium focus-visible:ring-1 focus-visible:ring-amber-400 focus-visible:outline-none rounded">
                <span>Standard Login</span>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/dev-login.blade.php ENDPATH**/ ?>