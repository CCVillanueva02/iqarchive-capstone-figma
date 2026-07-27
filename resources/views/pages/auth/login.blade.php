<x-layouts::auth :title="__('Log in')">
    <div class="w-full max-w-[440px] bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-2xl shadow-xs p-8 md:p-10 flex flex-col gap-6">
        <div class="text-center flex flex-col items-center">
            <!-- University/Office Logo Icon -->
            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 border border-slate-200 mb-4">
                <x-lucide-landmark class="w-8 h-8 text-[#586A85]" />
            </div>

            <!-- Title & Subtitle -->
            <h1 class="text-2xl font-bold text-[#1b355a] dark:text-slate-100 tracking-tight">IQArchive</h1>
            <p class="text-sm text-[#7a8b9e] dark:text-stone-400 mt-1">Internal Quality Assurance Office</p>
            
            <!-- Orange Divider -->
            <div class="w-16 h-[3px] bg-[#f27224] mt-3 rounded-full"></div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email Address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="Enter your email"
                icon="envelope"
            />

            <!-- Password -->
            <div class="flex flex-col gap-2">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    icon="lock-closed"
                    viewable
                />

                @if (Route::has('password.request'))
                    <div class="flex justify-end mt-1">
                        <flux:link class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline" :href="route('password.request')" wire:navigate>
                            {{ __('Forgot Password?') }}
                        </flux:link>
                    </div>
                @endif
            </div>

            <!-- Log In Button -->
            <flux:button type="submit" variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="w-full text-white py-2.5 rounded-lg font-semibold border-none shadow-xs" data-test="login-button">
                {{ __('Log In') }}
            </flux:button>
        </form>

        <div class="relative flex items-center justify-center -mt-2 -mb-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200 dark:border-stone-850"></div>
            </div>
            <span class="relative px-3 bg-white dark:bg-stone-900 text-xs text-slate-400 dark:text-stone-500 uppercase tracking-wider">Or</span>
        </div>

        <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 w-full px-4 py-2.5 text-sm font-semibold text-stone-700 dark:text-stone-300 bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-lg shadow-2xs hover:bg-slate-50 dark:hover:bg-stone-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F47920] transition-all">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            <span>Sign in with Google</span>
        </a>

        <!-- Don't have an account? Contact Admin -->
        <div class="text-xs text-center text-slate-500 dark:text-stone-400">
            {{ __("Don't have an account?") }}
            <span class="text-blue-800 dark:text-blue-400 font-semibold hover:underline cursor-pointer">
                {{ __('Contact your IQA Administrator') }}
            </span>
        </div>

        <!-- @if (app()->environment('local'))
            <div class="mt-2 p-3 bg-orange-50/50 border border-orange-100 rounded-lg dark:bg-orange-950/10 dark:border-orange-900/30 text-xs">
                <div class="font-bold text-orange-600 dark:text-orange-400 mb-1">Local Dev Credentials (Password: <span class="font-mono font-bold select-all">password</span>):</div>
                <div class="text-zinc-600 dark:text-zinc-400 space-y-0.5">
                    <div>• IQA Admin: <span class="font-mono select-all font-semibold">iqaadmin@example.com</span></div>
                    <div>• Accreditor: <span class="font-mono select-all font-semibold">accreditor@example.com</span></div>
                    <div>• Sysadmin: <span class="font-mono select-all font-semibold">sysadmin@example.com</span></div>
                </div>
            </div>
        @endif -->
    </div>

    <!-- Copyright Footer -->
    <div class="mt-6 text-center text-xs text-slate-400 dark:text-stone-500 tracking-wide">
        &copy; {{ date('Y') }} Bicol University — Internal Quality Assurance Office
    </div>
</x-layouts::auth>
