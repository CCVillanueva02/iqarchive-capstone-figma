<?php

use App\Concerns\ProfileValidationRules;
/* @chisel-email-verification */
use Illuminate\Contracts\Auth\MustVerifyEmail;
/* @end-chisel-email-verification */
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $avatar_file;
    public ?string $current_avatar = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->current_avatar = $user->avatar;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $rules = $this->profileRules($user->id);
        if ($this->avatar_file) {
            $rules['avatar_file'] = 'image|max:2048'; // 2MB Max
        }
        $validated = $this->validate($rules);

        if ($this->avatar_file) {
            if ($user->avatar) {
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

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Remove the current avatar.
     */
    public function removeAvatar(): void
    {
        $user = Auth::user();
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
            $user->save();
        }
        $this->avatar_file = null;
        $this->current_avatar = null;
        Flux::toast(variant: 'success', text: __('Profile photo removed.'));
    }

    /* @chisel-email-verification */
    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

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
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
    /* @end-chisel-email-verification */
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" enctype="multipart/form-data" class="my-6 w-full space-y-6">
            <!-- Profile Photo Section -->
            <div class="flex items-center gap-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                <div class="relative w-20 h-20 rounded-full bg-[#F47920] border-2 border-white dark:border-zinc-800 text-white font-bold flex items-center justify-center text-2xl shrink-0 select-none shadow-sm overflow-hidden">
                    @if ($avatar_file)
                        <img src="{{ $avatar_file->temporaryUrl() }}" class="w-full h-full object-cover">
                    @elseif ($current_avatar)
                        <img src="{{ Storage::url($current_avatar) }}" class="w-full h-full object-cover">
                    @else
                        {{ Auth::user()->initials() }}
                    @endif
                </div>

                <div class="space-y-2">
                    <flux:heading size="sm" class="font-bold">{{ __('Profile Photo') }}</flux:heading>
                    <div class="flex items-center gap-3">
                        <label class="cursor-pointer">
                            <span class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white bg-[#F47920] hover:bg-[#d66516] rounded-xl shadow-xs transition duration-150 ease-in-out">
                                {{ __('Upload New') }}
                            </span>
                            <input type="file" wire:model="avatar_file" accept="image/*" class="hidden">
                        </label>

                        @if ($current_avatar || $avatar_file)
                            <flux:button type="button" variant="ghost" size="sm" class="text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950/20" wire:click="removeAvatar">
                                {{ __('Remove') }}
                            </flux:button>
                        @endif
                    </div>
                    <flux:subheading class="text-[11px] text-slate-400">
                        {{ __('JPG, PNG or WebP. Max 2MB.') }}
                    </flux:subheading>
                    <div wire:loading wire:target="avatar_file" class="text-xs text-slate-500 font-semibold flex items-center gap-2">
                        <flux:icon.loading class="w-3.5 h-3.5" /> Uploading temporary preview...
                    </div>
                    @error('avatar_file')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                {{-- @chisel-email-verification --}}
                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
                {{-- @end-chisel-email-verification --}}
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="w-full text-white font-semibold border-none shadow-xs" data-test="update-profile-button">
                        {{ __('Save') }}
                    </flux:button>
                </div>

            </div>
        </form>

        {{-- @chisel-email-verification --}}
        @if ($this->showDeleteUser)
        {{-- @end-chisel-email-verification --}}
            <livewire:pages::settings.delete-user-form />
        {{-- @chisel-email-verification --}}
        @endif
        {{-- @end-chisel-email-verification --}}
    </x-pages::settings.layout>
</section>
