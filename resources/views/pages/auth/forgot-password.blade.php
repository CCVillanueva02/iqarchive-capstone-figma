<x-layouts::auth :title="__('Forgot password')">
    <div class="w-full max-w-[440px] bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-2xl shadow-xs p-8 md:p-10 flex flex-col gap-6">
        <div class="text-center flex flex-col items-center">
            <!-- University/Office Logo Icon -->
            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-stone-800 border border-slate-200 dark:border-stone-800 mb-4">
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

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
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

            <!-- Email Reset Link Button -->
            <flux:button type="submit" variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="w-full text-white py-2.5 rounded-lg font-semibold border-none shadow-xs" data-test="email-password-reset-link-button">
                {{ __('Email Password Reset Link') }}
            </flux:button>
        </form>

        <!-- Return to Log In -->
        <div class="text-xs text-center text-slate-500 dark:text-stone-400">
            <span>{{ __('Or, return to') }}</span>
            <flux:link class="text-blue-600 dark:text-blue-400 font-semibold hover:underline" :href="route('login')" wire:navigate>
                {{ __('log in') }}
            </flux:link>
        </div>
    </div>

    <!-- Copyright Footer -->
    <div class="mt-6 text-center text-xs text-slate-400 dark:text-stone-500 tracking-wide">
        &copy; {{ date('Y') }} Bicol University — Internal Quality Assurance Office
    </div>
</x-layouts::auth>
