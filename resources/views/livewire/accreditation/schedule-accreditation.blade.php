<div>
    <flux:modal wire:model="showModal" name="schedule-accreditation" class="max-w-2xl md:min-w-2xl">
        <form wire:submit="save" class="space-y-5">
            <!-- Modal Header -->
            <div class="flex items-center gap-3 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-orange border border-orange-200/60 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <path d="M9 16l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div>
                    <flux:heading size="lg" class="text-primary-dark font-bold">
                        {{ __('Record Accreditation Visit') }}
                    </flux:heading>
                    <flux:subheading class="text-label text-slate-500 mt-0.5">
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

            <!-- Dynamic Program Preview Card Partial -->
            @include('livewire.accreditation.partials.schedule-program-preview-card')

            <!-- Survey Dates Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input type="date" wire:model="target_date" :label="__('Target Visit Start Date')" required />
                    <p class="text-label-xs text-slate-400 mt-1">Official start date of the evaluation visit.</p>
                </div>
                <div>
                    <flux:input type="date" wire:model="survey_end_date" :label="__('Target End Date (Optional)')" />
                    <p class="text-label-xs text-slate-400 mt-1">Survey conclusion date (e.g. 3-day duration).</p>
                </div>
            </div>

            <!-- Workflow Notice Banner Partial -->
            @include('livewire.accreditation.partials.schedule-notice')

            <!-- Modal Footer Actions -->
            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                <flux:button type="button" variant="outline" x-on:click="$flux.modal('schedule-accreditation').close()">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button 
                    type="submit" 
                    variant="primary" 
                    style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" 
                    class="text-white font-semibold border-none shadow-xs">
                    <span wire:loading.remove wire:target="save">{{ __('Record & Schedule Visit') }}</span>
                    <span wire:loading wire:target="save" class="flex items-center gap-1.5">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('Scheduling Visit...') }}
                    </span>
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
