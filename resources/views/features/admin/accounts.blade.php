<div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- 1. Unified Page Header -->
    <x-ui.page-header
        title="Accounts Management"
        subtitle="Pre-register and manage institutional user accounts, roles, and college affiliations."
        :breadcrumbs="[
            ['label' => 'Administration', 'url' => '#'],
            ['label' => 'Accounts Management']
        ]"
    >
        <x-slot:actions>
            <x-ui.button
                type="button"
                variant="brand"
                size="sm"
                wire:click="openQuickTfModal"
            >
                <x-slot:icon>
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </x-slot:icon>
                Quick Pre-Register Task Force
            </x-ui.button>

            <x-ui.button
                type="button"
                variant="primary"
                size="sm"
                wire:click="openCreateModal"
            >
                <x-slot:icon>
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </x-slot:icon>
                Pre-Register User
            </x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <!-- 2. Status Segments & Search/Filter Controls -->
    @include('livewire.admin.partials.accounts-filter')

    <!-- 3. Accounts Table & Pagination -->
    @include('livewire.admin.partials.accounts-table')

    <!-- 4. Quick Pre-Register Task Force Modal -->
    @include('livewire.admin.partials.quick-tf-modal')

    <!-- 5. Generic Pre-Register User Modal -->
    @include('livewire.admin.partials.create-modal')

    <!-- 6. Edit User Account Modal -->
    @include('livewire.admin.partials.edit-modal')

    <!-- 7. Deactivate / Activate Account Modal -->
    @include('livewire.admin.partials.delete-modal')
</div>
