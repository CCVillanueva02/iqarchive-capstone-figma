<div>
    <flux:modal wire:model="showModal" name="schedule-accreditation" class="max-w-2xl md:min-w-2xl">
        <form wire:submit="save" class="space-y-5">
            <!-- Modal Header -->
            <div class="flex items-center gap-3 pb-4 border-b border-zinc-200">
                <div class="w-10 h-10 rounded-xl bg-brand-orange/10 text-brand-orange border border-brand-orange/20 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <path d="M9 16l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div>
                    <flux:heading size="lg" class="text-primary-dark font-extrabold">
                        {{ __('Record Accreditation Visit') }}
                    </flux:heading>
                    <flux:subheading class="text-label text-zinc-500 mt-0.5">
                        {{ __('Initiate an official program accreditation survey, configure the evaluation window, and trigger Task Force mobilization.') }}
                    </flux:subheading>
                </div>
            </div>

            <!-- College & Program Selection Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:select wire:model.live="college_id" :label="__('Parent College / Campus')" placeholder="Filter by College...">
                        <flux:select.option value="">All Colleges & Campuses</flux:select.option>
                        @foreach($colleges as $college)
                            <flux:select.option value="{{ $college->id }}">
                                {{ $college->name }} ({{ $college->code }})
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:select wire:model.live="program_id" :label="__('Target Degree Program')" required placeholder="Select degree program...">
                        <flux:select.option value="">Choose academic program...</flux:select.option>
                        @foreach($programs as $program)
                            <flux:select.option value="{{ $program->id }}">
                                {{ $program->college->code ?? '' }} - {{ $program->name }} ({{ $program->code }})
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <!-- Dynamic Program Preview Card -->
            @if($selectedProgram)
            <div class="bg-surface-card border border-zinc-200/90 rounded-2xl p-4 shadow-3xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-zinc-200/80">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-label-xs font-bold bg-primary/10 text-primary border border-primary/20 shrink-0">
                            @if($selectedProgram->college && $selectedProgram->college->logo)
                                <img src="{{ $selectedProgram->college->logo }}" alt="Logo" class="w-4 h-4 object-contain shrink-0" onerror="this.style.display='none'">
                            @endif
                            {{ $selectedProgram->college->code ?? 'N/A' }}
                        </span>
                        <div>
                            <h4 class="text-body font-bold text-primary-dark leading-tight">
                                {{ $selectedProgram->name }}
                            </h4>
                            <p class="text-label-xs text-zinc-400 font-mono mt-0.5">
                                {{ $selectedProgram->code }} &bull; {{ $selectedProgram->college->name ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3">
                    <div class="bg-white p-3 rounded-xl border border-zinc-200/70">
                        <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400 block">Campus</span>
                        <span class="text-body-sm font-bold text-zinc-800 block mt-0.5">
                            {{ $selectedProgram->college->campus ?? 'Main Campus' }}
                        </span>
                    </div>

                    <div class="bg-white p-3 rounded-xl border border-zinc-200/70">
                        <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400 block">Current Standing</span>
                        <span class="text-body-sm font-bold text-zinc-800 block mt-0.5">
                            {{ $selectedProgram->accreditation_level ?: 'Candidate Status' }}
                        </span>
                    </div>

                    <div class="bg-white p-3 rounded-xl border border-zinc-200/70">
                        <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400 block">Dean / Lead</span>
                        <span class="text-body-sm font-bold text-zinc-800 block mt-0.5 truncate">
                            {{ $selectedProgram->college->dean->name ?? 'None Designated' }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Survey Dates Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input type="date" wire:model="target_date" :label="__('Target Visit Start Date')" required />
                    <p class="text-label-xs text-zinc-400 mt-1">Official start date of the evaluation visit.</p>
                </div>
                <div>
                    <flux:input type="date" wire:model="survey_end_date" :label="__('Target End Date (Optional)')" />
                    <p class="text-label-xs text-zinc-400 mt-1">Exit conference and final wrap-up date.</p>
                </div>
            </div>

            <!-- Informational Notice -->
            <div class="bg-surface-subtle border border-primary/15 rounded-xl p-3.5 flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-white border border-zinc-200 text-primary flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1 text-body-sm text-zinc-700">
                    <h5 class="font-bold text-primary-dark text-body-sm">
                        Automated Stakeholder Mobilization
                    </h5>
                    <p class="text-label text-zinc-600 mt-0.5 leading-relaxed">
                        Upon recording, this visit enters the <strong class="text-amber-800">Scheduled</strong> stage. An automated alert is immediately dispatched to the College Dean to nominate faculty members for the official Program Task Force.
                    </p>
                </div>
            </div>

            <!-- Footer CTA -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200">
                <flux:modal.close>
                    <x-ui.button variant="secondary" type="button">
                        Cancel
                    </x-ui.button>
                </flux:modal.close>

                <x-ui.button variant="brand" type="submit" loading="save">
                    Schedule Visit
                </x-ui.button>
            </div>
        </form>
    </flux:modal>
</div>
