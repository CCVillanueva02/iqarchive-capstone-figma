<div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-label text-primary-muted font-bold uppercase tracking-wider mb-1">
                <span>Configuration</span>
                <span>&bull;</span>
                <span>Institutional Structure</span>
            </div>
            <h1 class="text-heading-lg font-bold text-primary">Colleges &amp; Programs</h1>
            <p class="text-body-sm text-zinc-500 mt-1">Manage Bicol University campuses, colleges, academic units, and degree program accreditation levels.</p>
        </div>

        @if($canManage)
        <div class="flex items-center gap-3">
            <flux:button variant="outline" class="font-semibold shadow-xs" icon="plus" wire:click="openCreateCollegeModal">
                {{ __('Add College') }}
            </flux:button>
            <flux:button variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs" icon="plus" wire:click="openCreateProgramModal()">
                {{ __('Add Program') }}
            </flux:button>
        </div>
        @endif
    </div>

    <!-- Summary Stats Bar -->
    @include('livewire.configuration.partials.stats-bar')

    <!-- Filter & Search Control Panel -->
    @include('livewire.configuration.partials.filter-bar')

    <!-- Colleges & Programs List -->
    <div class="flex flex-col gap-5">
        @forelse($colleges as $college)
            @include('livewire.configuration.partials.college-card')
        @empty
        <div class="bg-white border border-slate-200/60 rounded-2xl p-12 text-center text-zinc-400 shadow-3xs flex flex-col items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
                </svg>
            </div>
            <p class="font-bold text-primary text-heading-sm">No Colleges or Programs Found</p>
            <p class="text-body-sm text-zinc-500">No entries match your search query or selected filter criteria.</p>
        </div>
        @endforelse
    </div>

    <!-- Modals (College & Program Forms) -->
    @if($canManage)
        @include('livewire.configuration.partials.modals')
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (event) => {
                const data = event[0];
                Swal.fire({
                    icon: data.icon || 'success',
                    title: data.title || '',
                    text: data.text || '',
                    confirmButtonColor: '#f47920',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200/60 shadow-lg font-sans',
                        title: 'text-primary font-bold text-heading-lg',
                        confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-white'
                    }
                });
            });
        });
    </script>
</div>
