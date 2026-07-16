<x-layouts::auth :title="__('Log in')">
    <div class="w-full max-w-[440px] bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-2xl shadow-xs p-8 md:p-10 flex flex-col gap-6">
        <div class="text-center flex flex-col items-center">
            <!-- University/Office Logo Icon -->
            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-stone-800 border border-slate-200 dark:border-stone-700 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#586A85] dark:text-slate-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V8.25M15.75 21V8.25M8.25 21V8.25M3 9L12 3L21 9M19.5 21V12M4.5 21V12M2.25 21h19.5" />
                </svg>
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
                    icon="lock"
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
            <flux:button type="submit" class="w-full bg-[#f27224] hover:bg-[#d65f1a] text-white py-2.5 rounded-lg font-semibold border-none shadow-xs" data-test="login-button">
                {{ __('Log In') }}
            </flux:button>
        </form>

        <!-- Don't have an account? Contact Admin -->
        <div class="text-xs text-center text-slate-500 dark:text-stone-400">
            {{ __("Don't have an account?") }}
            <span class="text-blue-800 dark:text-blue-400 font-semibold hover:underline cursor-pointer">
                {{ __('Contact your IQA Administrator') }}
            </span>
        </div>
    </div>

    <!-- Copyright Footer -->
    <div class="mt-6 text-center text-xs text-slate-400 dark:text-stone-500 tracking-wide">
        &copy; {{ date('Y') }} Bicol University — Internal Quality Assurance Office
    </div>
</x-layouts::auth>
