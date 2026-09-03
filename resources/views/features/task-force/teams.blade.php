<div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- 1. Page Header & Actions -->
    @include('livewire.task-force.partials.header')

    <!-- 2. Overview Stats Summary Row -->
    @include('livewire.task-force.partials.stats-row')

    <!-- 3. Filter & Search Toolbar -->
    @include('livewire.task-force.partials.filter-toolbar')

    <!-- 4. Task Force Overview Cards Grid -->
    @include('livewire.task-force.partials.task-force-cards')

    <!-- Pagination -->
    @if($taskForces->hasPages())
    <div class="mt-2">
        {{ $taskForces->links() }}
    </div>
    @endif

    <!-- 5. Create Task Force Modal -->
    @include('livewire.task-force.partials.create-modal')

    <!-- 6. Member Roster Detail View Modal -->
    @include('livewire.task-force.partials.roster-modal')

    <!-- SweetAlert Event Listener -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (event) => {
                const data = event[0];
                if (window.Swal) {
                    Swal.fire({
                        icon: data.icon || 'success',
                        title: data.title || '',
                        text: data.text || '',
                        confirmButtonColor: '#f47920',
                        customClass: {
                            popup: 'rounded-2xl border border-zinc-200 shadow-lg font-sans',
                            title: 'text-primary font-bold text-xl',
                            confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-white'
                        }
                    });
                }
            });
        });
    </script>
</div>
