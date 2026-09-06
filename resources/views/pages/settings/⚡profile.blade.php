<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    /** @var TemporaryUploadedFile|null */
    public $avatar_file = null;
    public ?string $current_avatar = null;
    public ?string $google_avatar = null;
    public bool $has_google_linked = false;

    /**
     * Get the authenticated user model.
     */
    private function user(): User
    {
        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = $this->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->current_avatar = $user->avatar;
        $this->google_avatar = $user->google_avatar;
        $this->has_google_linked = !empty($user->google_id) || !empty($user->google_avatar) || Str::endsWith(strtolower($user->email), '@bicol-u.edu.ph');
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = $this->user();

        $rules = $this->profileRules($user->id);
        if ($this->avatar_file) {
            $rules['avatar_file'] = 'image|max:2048'; // 2MB Max
        }
        $validated = $this->validate($rules);

        if ($this->avatar_file) {
            if ($user->avatar && !Str::startsWith($user->avatar, ['http://', 'https://'])) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $this->avatar_file->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->avatar_file = null;
        $this->current_avatar = $user->avatar;
        $this->google_avatar = $user->google_avatar;

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Set Google profile picture as current avatar.
     */
    public function useGoogleAvatar(): void
    {
        $user = $this->user();

        $targetGoogleAvatar = $user->google_avatar;
        if (!$targetGoogleAvatar && $this->has_google_linked) {
            $targetGoogleAvatar = 'https://lh3.googleusercontent.com/a/default-user';
        }

        if (!$targetGoogleAvatar) {
            Flux::toast(variant: 'error', text: __('No Google profile picture available.'));
            return;
        }

        if ($user->avatar && !Str::startsWith($user->avatar, ['http://', 'https://'])) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = $targetGoogleAvatar;
        $user->google_avatar = $targetGoogleAvatar;
        $user->save();

        $this->avatar_file = null;
        $this->current_avatar = $user->avatar;
        $this->google_avatar = $targetGoogleAvatar;

        Flux::toast(variant: 'success', text: __('Google profile picture set as your avatar.'));
    }

    /**
     * Remove the current avatar.
     */
    public function removeAvatar(): void
    {
        $user = $this->user();
        if ($user->avatar) {
            if (!Str::startsWith($user->avatar, ['http://', 'https://'])) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = null;
            $user->save();
        }
        $this->avatar_file = null;
        $this->current_avatar = null;
        Flux::toast(variant: 'success', text: __('Profile photo removed.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = $this->user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        $user = $this->user();
        return $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        $user = $this->user();
        return ! $user instanceof MustVerifyEmail
            || ($user instanceof MustVerifyEmail && $user->hasVerifiedEmail());
    }
}; ?>

<section class="w-full space-y-6 antialiased">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Manage your account identity, profile photo, and personal details')">

        <div class="space-y-6 w-full">
            @php
            $user = Auth::user();
            $avatarType = 'initials';
            if ($avatar_file) {
            $avatarType = 'preview';
            } elseif ($current_avatar) {
            $avatarType = Str::startsWith($current_avatar, ['http://', 'https://']) ? 'google' : 'custom';
            }
            $roleTitle = match($user->role) {
                'system-administrator' => 'System Administrator',
                'iqa-staff', 'iqa-admin', 'iqa-member' => 'IQA Member',
                'accreditor' => 'AACCUP Accreditor',
                'university-administrator' => 'BU Executive',
                'college-head' => 'College Head',
                'task-force-member', 'task-force' => 'Task Force Member',
                default => ucwords(str_replace('-', ' ', $user->role))
            };
            @endphp

            <!-- Summary Header Card (Dark Navy-to-Black Gradient, Two-Column SaaS Header) -->
            <div class="relative overflow-hidden rounded-2xl bg-linear-to-r from-primary-dark via-[#091E3A] to-[#040D1A] border border-white/10 p-5 md:p-6 shadow-xl text-white flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-brand-orange/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Left: Identity Block -->
                <div class="flex items-center gap-4 min-w-0 w-full sm:w-auto relative z-10">
                    <!-- Square Avatar (~64px, ~12px rounded corners) with inside 10px status dot -->
                    <div class="relative w-16 h-16 rounded-xl bg-brand-orange border border-white/15 text-white font-bold flex items-center justify-center text-2xl shrink-0 select-none overflow-hidden shadow-sm">
                        @if ($avatar_file)
                        <img src="{{ $avatar_file->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                        @else
                        {{ $user->initials() }}
                        @endif

                        <!-- Small circular status indicator (green, ~10px) positioned fully inside bottom-right corner with 2px dark border ring -->
                        <span class="absolute bottom-1 right-1 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-primary-dark z-10 pointer-events-none"></span>
                    </div>

                    <!-- Name, Outline Role Badge, and Monospace Email -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <h2 class="text-heading-sm font-bold text-white tracking-tight leading-tight truncate">{{ $user->name }}</h2>

                            <!-- Outline-Only Role Badge (Thin gray border, no fill, gray text) -->
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-normal text-slate-300 border border-slate-600/80 bg-transparent tracking-wide select-none">
                                {{ $roleTitle }}
                            </span>
                        </div>

                        <!-- Monospace Email (~4px tight spacing below name line) -->
                        <p class="text-xs text-slate-400 font-mono mt-1 truncate">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Right: Single Solid Fill Status Badge (Vertically Centered)
                <div class="flex items-center shrink-0 relative z-10 w-full sm:w-auto justify-end">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-500 text-white font-bold text-xs shadow-xs select-none">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ $user->status === 'active' ? 'Active Account' : ucfirst($user->status) }}
                    </span>
                </div> -->
            </div>

            <!-- Profile Photo Section Card -->
            <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 rounded-2xl p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-zinc-800 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ __('Profile Photo') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            {{ __('Lorem Ipsum is simply dummy text of the printing and typesetting industry. ') }}
                        </p>
                    </div>

                   
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-6 pt-1">
                    <!-- Photo Preview Frame -->
                    <div class="relative w-20 h-20 rounded-2xl bg-brand-orange border-2 border-slate-200 dark:border-zinc-700 text-white font-bold flex items-center justify-center text-2xl shrink-0 select-none shadow-xs overflow-hidden">
                        @if ($avatar_file)
                        <img src="{{ $avatar_file->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                        @else
                        {{ $user->initials() }}
                        @endif
                    </div>

                    <!-- Action Controls & Constraints -->
                    <div class="space-y-2.5 text-center sm:text-left flex-1">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                            <!-- Custom Upload Button -->
                            <label class="cursor-pointer">
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-brand-orange hover:bg-brand-orange-hover rounded-xl shadow-xs transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    {{ __('Upload New') }}
                                </span>
                                <input type="file" wire:model="avatar_file" accept="image/*" class="hidden">
                            </label>

                            <!-- Use Google Picture Button -->
                            @if ($this->has_google_linked || $this->google_avatar)
                            <flux:button type="button" variant="subtle" size="sm" class="text-xs font-semibold flex items-center gap-1.5 border border-slate-200 dark:border-zinc-700 hover:bg-slate-50 dark:hover:bg-zinc-800" wire:click="useGoogleAvatar">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z" />
                                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.93l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.23v3.15C3.25 21.32 7.33 24 12 24z" />
                                    <path fill="#FBBC05" d="M5.28 14.25c-.25-.72-.38-1.49-.38-2.25s.13-1.53.38-2.25V6.6H1.23C.44 8.18 0 9.99 0 12s.44 3.82 1.23 5.4l4.05-3.15z" />
                                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.25 2.68 1.23 6.6l4.05 3.15c.95-2.83 3.6-4.93 6.72-4.93z" />
                                </svg>
                                {{ __('Use Google Picture') }}
                            </flux:button>
                            @endif

                            <!-- Remove Photo Button -->
                            @if ($current_avatar || $avatar_file)
                            <flux:button type="button" variant="ghost" size="sm" class="text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950/20 text-xs font-semibold" wire:click="removeAvatar">
                                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                {{ __('Remove') }}
                            </flux:button>
                            @endif
                        </div>

                        <!-- Explicit File Constraints Notice -->
                        <p class="text-label-xs text-slate-400 dark:text-zinc-500 font-mono">
                            JPG, PNG or WebP. Max 2MB.
                        </p>

                        <div wire:loading wire:target="avatar_file" class="text-xs text-brand-orange font-semibold flex items-center justify-center sm:justify-start gap-2">
                            <flux:icon.loading class="w-3.5 h-3.5" /> Uploading temporary preview...
                        </div>
                        @error('avatar_file')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Personal Information Form Card -->
            <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 rounded-2xl p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 dark:border-zinc-800 pb-3">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ __('Personal Information') }}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        {{ __('Update your name and primary email address used for notifications and access control') }}
                    </p>
                </div>

                <form wire:submit="updateProfileInformation" enctype="multipart/form-data" class="space-y-5">
                    <div class="space-y-4">
                        <div>
                            <flux:input wire:model="name" :label="__('Full Name')" type="text" required autofocus autocomplete="name" />
                        </div>

                        <div>
                            <flux:input wire:model="email" :label="__('Email Address')" type="email" required autocomplete="email" />

                            @if ($this->hasUnverifiedEmail)
                            <div class="mt-3 p-3 rounded-xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50">
                                <flux:text class="text-xs font-medium text-amber-800 dark:text-amber-300">
                                    {{ __('Your email address is unverified.') }}

                                    <flux:link class="text-xs font-bold text-amber-900 dark:text-amber-200 underline cursor-pointer ml-1" wire:click.prevent="resendVerificationNotification">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </flux:link>
                                </flux:text>

                                @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-2 flex items-center justify-end">
                        <flux:button variant="primary" type="submit" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="px-6 text-white font-bold border-none shadow-xs hover:opacity-95" data-test="update-profile-button">
                            <svg class="w-4 h-4 inline mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Save Changes') }}
                        </flux:button>
                    </div>
                </form>
            </div>

            <!-- Delete User Account Danger Zone Card (Bordered / Outlined, De-emphasized) -->
            @if ($this->showDeleteUser)
            <div class="bg-transparent border border-red-500/30 dark:border-red-900/40 rounded-2xl p-6 transition-all duration-150">
                <livewire:pages::settings.delete-user-form />
            </div>
            @endif
        </div>

    </x-pages::settings.layout>
</section>