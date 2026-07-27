<x-layouts::html :title="__('Log in')" html-class="light scroll-smooth" body-class="bg-[#f3f7fa] dark:bg-stone-950 antialiased text-zinc-800 dark:text-zinc-200 font-sans min-h-screen flex flex-col justify-between">
    @include('partials.header')

    <div class="flex-1 flex items-center justify-center p-6 md:p-10">
        <!-- Improved Login Box -->
        <div class="w-full max-w-[440px] bg-white dark:bg-stone-900 border border-slate-200/80 dark:border-stone-800/80 rounded-2xl shadow-xs p-8 md:p-10 flex flex-col gap-6 hover:shadow-md transition-shadow duration-300">
            
            <div class="text-center flex flex-col items-center">
                <!-- Bicol University Logo -->
                <div class="flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 dark:bg-stone-850 border border-slate-100 dark:border-stone-800 mb-4 p-2 shadow-2xs transition-transform duration-300 hover:scale-105">
                    <img src="/bulogo.png" alt="Bicol University Logo" class="w-full h-full object-contain" />
                </div>

                <!-- Title & Subtitle -->
                <h1 class="text-2xl font-bold text-[#1b355a] dark:text-slate-100 tracking-tight">IQArchive</h1>
                <p class="text-sm text-[#7a8b9e] dark:text-stone-400 mt-1">Internal Quality Assurance Office</p>

                <!-- Orange Divider -->
                <div class="w-16 h-[3px] bg-[#f27224] mt-3 rounded-full"></div>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            @if ($errors->any())
            <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/30 text-xs text-red-600 dark:text-red-400">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Sign in with Google Button -->
            <a href="{{ route('auth.google') }}" class="group relative flex items-center justify-center gap-3 w-full px-5 py-3 text-sm font-semibold text-stone-700 dark:text-stone-300 bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-xl shadow-2xs hover:bg-slate-50 dark:hover:bg-stone-850 hover:border-slate-300 dark:hover:border-stone-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#f27224] transition-all duration-200 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-slate-100/10 dark:via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out"></div>
                <svg class="w-5 h-5 shrink-0 transition-transform group-hover:scale-110 duration-200" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05" />
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335" />
                </svg>
                <span class="relative z-10">Sign in with Google</span>
            </a>

            <!-- Collapsible support info displaying only IQA email -->
            <div x-data="{ open: false }" class="border-t border-slate-100 dark:border-stone-850 pt-5">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-center gap-1.5 text-xs font-bold text-[#002B61] dark:text-[#f27224] hover:underline cursor-pointer select-none bg-transparent border-0 p-0">
                    <span>Don't have an account?</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                     class="mt-3 text-xs text-slate-500 dark:text-stone-400 space-y-3 bg-slate-50 dark:bg-stone-900/40 p-4 rounded-xl border border-slate-200/60 dark:border-stone-800/80"
                     x-cloak>
                    <p class="leading-relaxed">
                        For registration and account access requests, please contact the <strong>Internal Quality Assurance Office</strong>:
                    </p>
                    <div class="flex items-center gap-2 font-semibold text-[#002B61] dark:text-[#f27224]">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <a href="mailto:bu-iqao@bicol-u.edu.ph" class="hover:underline">bu-iqao@bicol-u.edu.ph</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('partials.footer')
</x-layouts::html>