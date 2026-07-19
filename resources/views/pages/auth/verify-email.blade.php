<x-layouts::auth :title="__('Email verification')">
    <div class="w-full max-w-[440px] bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-2xl shadow-xs p-8 md:p-10 flex flex-col gap-6">
        <div class="text-center flex flex-col items-center">
            <!-- University/Office Logo Icon -->
            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-stone-800 border border-slate-200 dark:border-stone-800 mb-4">
                <x-lucide-landmark class="w-8 h-8 text-[#586A85]" />
            </div>

            <!-- Title & Subtitle -->
            <h1 class="text-2xl font-bold text-[#1b355a] dark:text-slate-100 tracking-tight">Verify Email</h1>
            <p class="text-sm text-[#7a8b9e] dark:text-stone-400 mt-1">Please verify your email address by clicking on the link we just emailed to you.</p>
            
            <!-- Orange Divider -->
            <div class="w-16 h-[3px] bg-[#f27224] mt-3 rounded-full"></div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30 rounded-xl text-xs text-center font-medium text-emerald-600 dark:text-emerald-400">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="w-full text-white py-2.5 rounded-lg font-semibold border-none shadow-xs">
                    {{ __('Resend Verification Email') }}
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                @csrf
                <button type="submit" class="text-xs font-semibold text-slate-500 hover:text-[#f27224] dark:text-stone-400 dark:hover:text-[#f27224] hover:underline cursor-pointer" data-test="logout-button">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Copyright Footer -->
    <div class="mt-6 text-center text-xs text-slate-400 dark:text-stone-500 tracking-wide">
        &copy; {{ date('Y') }} Bicol University — Internal Quality Assurance Office
    </div>
</x-layouts::auth>
