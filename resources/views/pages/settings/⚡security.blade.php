<?php

use App\Concerns\PasswordValidationRules;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\Title;
use Livewire\Component;
/* @chisel-passkeys */
use Laravel\Passkeys\Actions\DeletePasskey;
use Livewire\Attributes\Locked;
/* @end-chisel-passkeys */
/* @chisel-2fa */
use Livewire\Attributes\On;
/* @end-chisel-2fa */

new #[Title('Security settings')] class extends Component {
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /* @chisel-2fa */
    public bool $canManageTwoFactor;

    public bool $twoFactorEnabled;

    public bool $requiresConfirmation;
    /* @end-chisel-2fa */

    /* @chisel-passkeys */
    #[Locked]
    public bool $canManagePasskeys;

    #[Locked]
    public array $passkeys = [];

    public bool $showDeleteModal = false;

    #[Locked]
    public ?int $deletingPasskeyId = null;

    #[Locked]
    public string $deletingPasskeyName = '';
    /* @end-chisel-passkeys */

    public string $confirm_password = '';
    public bool $showConfirmLogoutModal = false;

    public function confirmLogout(): void
    {
        $this->confirm_password = '';
        $this->showConfirmLogoutModal = true;
    }

    public function logoutOtherBrowserSessions(): void
    {
        if (! \Illuminate\Support\Facades\Hash::check($this->confirm_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'confirm_password' => [__('This password does not match our records.')],
            ]);
        }

        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();

        $this->reset('confirm_password');
        $this->showConfirmLogoutModal = false;

        Flux::toast(variant: 'success', text: __('Other browser sessions logged out.'));
    }

    public function getSessions()
    {
        return \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                $agent = $this->parseUserAgent($session->user_agent);
                return [
                    'platform' => $agent->platform,
                    'browser' => $agent->browser,
                    'is_desktop' => $agent->is_desktop,
                    'ip_address' => $session->ip_address,
                    'is_current_device' => $session->id === request()->session()->getId(),
                    'last_active' => \Illuminate\Support\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                ];
            })
            ->toArray();
    }

    protected function parseUserAgent($userAgent)
    {
        $platform = 'Unknown OS';
        $browser = 'Unknown Browser';

        if (preg_match('/Windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $platform = 'iOS';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $platform = 'Android';
        }

        if (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
            if (preg_match('/Edg/i', $userAgent)) {
                $browser = 'Edge';
            } elseif (preg_match('/OPR/i', $userAgent)) {
                $browser = 'Opera';
            }
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/MSIE|Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        }

        return (object) [
            'platform' => $platform,
            'browser' => $browser,
            'is_desktop' => !preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent),
        ];
    }

    /**
     * Mount the component.
     */
    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        /* @chisel-2fa */
        $this->canManageTwoFactor = Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {
            if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
                $disableTwoFactorAuthentication(auth()->user());
            }

            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
            $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }
        /* @end-chisel-2fa */

        /* @chisel-passkeys */
        $this->canManagePasskeys = Features::canManagePasskeys();

        if ($this->canManagePasskeys) {
            $this->loadPasskeys();
        }
        /* @end-chisel-passkeys */
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'password_change',
            'target_type' => \App\Models\User::class,
            'target_id' => Auth::id(),
            'timestamp' => now(),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        Flux::toast(variant: 'success', text: __('Password updated.'));
    }

    /* @chisel-passkeys */
    /**
     * Load the user's passkeys.
     */
    public function loadPasskeys(): void
    {
        $this->passkeys = auth()->user()->passkeys()
            ->select(['id', 'name', 'credential', 'created_at', 'last_used_at'])
            ->latest()
            ->get()
            ->map(fn ($passkey) => [
                'id' => $passkey->id,
                'name' => $passkey->name,
                'authenticator' => $passkey->authenticator,
                'created_at_diff' => $passkey->created_at->diffForHumans(),
                'last_used_at_diff' => $passkey->last_used_at?->diffForHumans(),
            ])
            ->toArray();
    }

    /**
     * Show the delete confirmation modal.
     */
    public function confirmDelete(int $passkeyId): void
    {
        $passkey = auth()->user()->passkeys()->findOrFail($passkeyId);

        $this->deletingPasskeyId = $passkey->id;
        $this->deletingPasskeyName = $passkey->name;
        $this->showDeleteModal = true;
    }

    /**
     * Delete the passkey.
     */
    public function deletePasskey(DeletePasskey $deletePasskey): void
    {
        if (! $this->deletingPasskeyId) {
            return;
        }

        $passkey = auth()->user()->passkeys()->findOrFail($this->deletingPasskeyId);

        $deletePasskey(auth()->user(), $passkey);

        $this->closeDeleteModal();
        $this->loadPasskeys();
    }

    /**
     * Close the delete confirmation modal.
     */
    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deletingPasskeyId = null;
        $this->deletingPasskeyName = '';
    }
    /* @end-chisel-passkeys */

    /* @chisel-2fa */
    /**
     * Handle the two-factor authentication enabled event.
     */
    #[On('two-factor-enabled')]
    public function onTwoFactorEnabled(): void
    {
        $this->twoFactorEnabled = true;
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }
    /* @end-chisel-2fa */
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Security settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('Current password')"
                type="password"
                required
                autocomplete="current-password"
                viewable
            />
            <flux:input
                wire:model="password"
                :label="__('New password')"
                type="password"
                required
                autocomplete="new-password"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs" data-test="update-password-button">
                    {{ __('Save') }}
                </flux:button>
            </div>
        </form>

        {{-- @chisel-2fa --}}
        @if ($canManageTwoFactor)
            <section class="mt-12">
                <flux:heading>{{ __('Two-factor authentication') }}</flux:heading>
                <flux:subheading>{{ __('Manage your two-factor authentication settings') }}</flux:subheading>

                <div class="flex flex-col w-full mx-auto space-y-6 text-sm" wire:cloak>
                    @if ($twoFactorEnabled)
                        <div class="space-y-4">
                            <flux:text>
                                {{ __('You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                            </flux:text>

                            <div class="flex justify-start">
                                <flux:button
                                    variant="danger"
                                    wire:click="disable"
                                >
                                    {{ __('Disable 2FA') }}
                                </flux:button>
                            </div>

                            <livewire:pages::settings.two-factor.recovery-codes :$requiresConfirmation />
                        </div>
                    @else
                        <div class="space-y-4">
                            <flux:text variant="subtle">
                                {{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}
                            </flux:text>

                            <flux:modal.trigger name="two-factor-setup-modal">
                                <flux:button
                                    variant="primary"
                                    style="--color-accent: #F47920; --color-accent-foreground: #ffffff;"
                                    class="text-white font-semibold border-none shadow-xs"
                                    wire:click="$dispatch('start-two-factor-setup')"
                                >
                                    {{ __('Enable 2FA') }}
                                </flux:button>
                            </flux:modal.trigger>

                            <livewire:pages::settings.two-factor-setup-modal :requires-confirmation="$requiresConfirmation" />
                        </div>
                    @endif
                </div>
            </section>
        @endif
        {{-- @end-chisel-2fa --}}

        {{-- @chisel-passkeys --}}
        @if ($canManagePasskeys)
            <section class="mt-12">
                <flux:heading>{{ __('Passkeys') }}</flux:heading>
                <flux:subheading>{{ __('Manage your passkeys for passwordless sign-in') }}</flux:subheading>

                <div class="mt-6 flex flex-col w-full mx-auto space-y-6 text-sm" wire:cloak>
                    <div class="border rounded-lg border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        @forelse ($passkeys as $passkey)
                            <div class="flex items-center justify-between p-4 {{ ! $loop->last ? 'border-b border-zinc-200 dark:border-zinc-700' : '' }}">
                                <div class="flex items-center gap-4">
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 dark:bg-stone-800 border border-slate-200 dark:border-stone-800">
                                        <flux:icon.key class="size-5 text-[#586A85]" />
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2.5">
                                            <p class="font-medium tracking-tight">{{ $passkey['name'] }}</p>
                                            @if ($passkey['authenticator'])
                                                <flux:badge size="sm">{{ $passkey['authenticator'] }}</flux:badge>
                                            @endif
                                        </div>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">
                                            {{ __('Added :time', ['time' => $passkey['created_at_diff']]) }}
                                            @if ($passkey['last_used_at_diff'])
                                                <span class="opacity-50 mx-1">/</span>
                                                {{ __('Last used :time', ['time' => $passkey['last_used_at_diff']]) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <flux:button
                                    variant="ghost"
                                    size="sm"
                                    icon="trash"
                                    icon:variant="outline"
                                    wire:click="confirmDelete({{ $passkey['id'] }})"
                                    class="text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50"
                                />
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                    <div class="mx-auto mb-4 flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-stone-800 border border-slate-200 dark:border-stone-800">
                                        <flux:icon.key class="w-8 h-8 text-[#586A85]" />
                                    </div>
                                <p class="font-medium">{{ __('No passkeys yet') }}</p>
                                <flux:text class="mt-1">{{ __('Add a passkey to sign in without a password') }}</flux:text>
                            </div>
                        @endforelse
                    </div>

                    <x-passkey-registration />
                </div>
            </section>
        @endif
        {{-- @end-chisel-passkeys --}}

        {{-- Browser Sessions --}}
        <section class="mt-12 pt-12 border-t border-zinc-200">
            <flux:heading>{{ __('Browser sessions') }}</flux:heading>
            <flux:subheading>{{ __('Manage and log out your active sessions on other browsers and devices.') }}</flux:subheading>

            <flux:text variant="subtle" class="mt-4">
                {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
            </flux:text>

            <div class="mt-6 flex flex-col w-full mx-auto space-y-6 text-sm" wire:cloak>
                <div class="space-y-6">
                    @foreach ($this->getSessions() as $session)
                        <div class="flex items-center gap-4">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 dark:bg-stone-800 border border-slate-200 dark:border-stone-800 text-[#586A85]">
                                @if ($session['is_desktop'])
                                    <x-lucide-computer class="size-5" />
                                @else
                                    <x-lucide-smartphone class="size-5" />
                                @endif
                            </div>
                            <div class="space-y-0.5">
                                    <div class="text-sm font-medium tracking-tight text-slate-800 dark:text-stone-200">
                                    {{ $session['platform'] }} - {{ $session['browser'] }}
                                </div>
                                <div class="text-xs text-zinc-400 font-semibold">
                                    {{ $session['ip_address'] }} — 
                                    @if ($session['is_current_device'])
                                        <span class="text-green-600 font-bold">{{ __('This device') }}</span>
                                    @else
                                        <span>{{ __('Last active') }} {{ $session['last_active'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-start">
                    <flux:button
                        variant="subtle"
                        style="--color-accent: #F47920; --color-accent-foreground: #ffffff;"
                        class="font-semibold text-xs hover:border-[#F47920] hover:text-[#F47920]"
                        wire:click="confirmLogout"
                    >
                        {{ __('Log Out Other Browser Sessions') }}
                    </flux:button>
                </div>
            </div>
        </section>
    </x-pages::settings.layout>

    {{-- @chisel-passkeys --}}
    <flux:modal
        name="delete-passkey-modal"
        class="max-w-md md:min-w-md"
        @close="closeDeleteModal"
        wire:model="showDeleteModal"
    >
        <div class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">{{ __('Remove passkey') }}</flux:heading>
                <flux:text>
                    {{ __('Are you sure you want to remove the passkey ":name"? You will no longer be able to use it to sign in.', ['name' => $deletingPasskeyName]) }}
                </flux:text>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button
                    variant="outline"
                    wire:click="closeDeleteModal"
                >
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button
                    variant="danger"
                    wire:click="deletePasskey"
                >
                    {{ __('Remove passkey') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
    {{-- @end-chisel-passkeys --}}

    {{-- Confirm Logout Other Devices Modal --}}
    <flux:modal
        name="confirm-logout-modal"
        class="max-w-md md:min-w-md"
        wire:model="showConfirmLogoutModal"
    >
        <form wire:submit="logoutOtherBrowserSessions" class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">{{ __('Log Out Other Browser Sessions') }}</flux:heading>
                <flux:text>
                    {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}
                </flux:text>
            </div>

            <flux:input
                wire:model="confirm_password"
                type="password"
                required
                placeholder="{{ __('Password') }}"
                :label="__('Password')"
                viewable
            />

            <div class="flex gap-3 justify-end">
                <flux:button
                    variant="outline"
                    wire:click="$set('showConfirmLogoutModal', false)"
                >
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button
                    variant="danger"
                    type="submit"
                >
                    {{ __('Log Out Other Browser Sessions') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</section>
