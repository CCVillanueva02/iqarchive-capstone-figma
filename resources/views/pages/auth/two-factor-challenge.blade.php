<x-layouts::auth :title="__('Two-factor authentication')">
    <div
        class="w-full max-w-[440px] bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-2xl shadow-xs p-8 md:p-10 flex flex-col gap-6"
        x-cloak
        x-data="{
            showRecoveryInput: @js($errors->has('recovery_code')),
            code: '',
            recovery_code: '',
            focusOtp() {
                this.$nextTick(() => this.$refs.otp?.querySelector('input')?.focus());
            },
            init() {
                if (! this.showRecoveryInput) {
                    this.focusOtp();
                }
            },
            toggleInput() {
                this.showRecoveryInput = !this.showRecoveryInput;

                this.code = '';
                this.recovery_code = '';

                this.$nextTick(() => {
                    this.showRecoveryInput
                        ? this.$refs.recovery_code?.focus()
                        : this.focusOtp();
                });
            },
        }"
    >
        <div class="text-center flex flex-col items-center">
            <!-- University/Office Logo Icon -->
            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-stone-800 border border-slate-200 dark:border-stone-800 mb-4">
                <x-lucide-landmark class="w-8 h-8 text-[#586A85]" />
            </div>

            <!-- Title & Subtitle -->
            <div x-show="!showRecoveryInput" class="contents">
                <h1 class="text-2xl font-bold text-[#1b355a] dark:text-slate-100 tracking-tight">Two-Factor Auth</h1>
                <p class="text-sm text-[#7a8b9e] dark:text-stone-400 mt-1">Enter the authentication code provided by your authenticator application.</p>
            </div>

            <div x-show="showRecoveryInput" class="contents">
                <h1 class="text-2xl font-bold text-[#1b355a] dark:text-slate-100 tracking-tight">Recovery Code</h1>
                <p class="text-sm text-[#7a8b9e] dark:text-stone-400 mt-1">Please confirm access to your account by entering one of your emergency recovery codes.</p>
            </div>
            
            <!-- Orange Divider -->
            <div class="w-16 h-[3px] bg-[#f27224] mt-3 rounded-full"></div>
        </div>

        <form method="POST" action="{{ route('two-factor.login.store') }}" class="flex flex-col gap-6">
            @csrf

            <div x-show="!showRecoveryInput">
                <div class="flex items-center justify-center" x-ref="otp">
                    <flux:otp
                        x-model="code"
                        length="6"
                        name="code"
                        label="OTP Code"
                        label:sr-only
                        class="mx-auto"
                     />
                </div>
            </div>

            <div x-show="showRecoveryInput" class="flex flex-col gap-2">
                <flux:input
                    type="text"
                    name="recovery_code"
                    x-ref="recovery_code"
                    x-bind:required="showRecoveryInput"
                    autocomplete="one-time-code"
                    x-model="recovery_code"
                    placeholder="Enter recovery code"
                    icon="key"
                />

                @error('recovery_code')
                    <flux:text color="red" class="text-xs text-center mt-1">
                        {{ $message }}
                    </flux:text>
                @enderror
            </div>

            <!-- Action Button -->
            <flux:button type="submit" variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="w-full text-white py-2.5 rounded-lg font-semibold border-none shadow-xs">
                {{ __('Continue') }}
            </flux:button>

            <!-- Toggle Option -->
            <div class="text-xs text-center text-slate-500 dark:text-stone-400">
                <span class="opacity-70">{{ __('or you can') }}</span>
                <span class="text-blue-600 dark:text-blue-400 font-semibold hover:underline cursor-pointer" @click="toggleInput()">
                    <span x-show="!showRecoveryInput">{{ __('login using a recovery code') }}</span>
                    <span x-show="showRecoveryInput">{{ __('login using an authentication code') }}</span>
                </span>
            </div>
        </form>
    </div>

    <!-- Copyright Footer -->
    <div class="mt-6 text-center text-xs text-slate-400 dark:text-stone-500 tracking-wide">
        &copy; {{ date('Y') }} Bicol University — Internal Quality Assurance Office
    </div>
</x-layouts::auth>
