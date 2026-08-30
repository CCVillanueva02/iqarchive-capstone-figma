<div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- 1. Header & Quick Actions -->
    @include('livewire.admin.partials.accounts-header')

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
