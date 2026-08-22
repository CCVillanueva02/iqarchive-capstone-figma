<!-- Create College Modal -->
<flux:modal wire:model="showCreateCollegeModal" class="max-w-md md:min-w-md" @close="closeCreateCollegeModal">
    <form wire:submit="createCollege" class="space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-primary flex items-center justify-center font-bold">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                </div>
                <flux:heading size="lg">{{ __('Add New College / Satellite') }}</flux:heading>
            </div>
            <flux:subheading class="mt-1 text-xs text-slate-500">
                {{ __('Register a new college or satellite campus within Bicol University.') }}
            </flux:subheading>
        </div>

        <div class="space-y-4">
            <div>
                <flux:input wire:model="college_name" :label="__('College / Unit Name')" required placeholder="e.g. BU College of Science or BU Polangui" />
            </div>
            <div>
                <flux:input wire:model="college_code" :label="__('College Code / Abbreviation')" required placeholder="e.g. CS or BUP" />
                <p class="text-[11px] text-slate-400 mt-1">Unique short code or abbreviation for official reports.</p>
            </div>
            <div>
                <flux:input wire:model="college_campus" :label="__('Campus Designation')" required placeholder="e.g. LEGAZPI WEST CAMPUS, BU POLANGUI" />
            </div>
        </div>

        <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeCreateCollegeModal">{{ __('Cancel') }}</flux:button>
            <flux:button type="submit" variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">
                {{ __('Add College') }}
            </flux:button>
        </div>
    </form>
</flux:modal>

<!-- Edit College Modal -->
<flux:modal wire:model="showEditCollegeModal" class="max-w-md md:min-w-md" @close="closeEditCollegeModal">
    <form wire:submit="updateCollege" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Edit College Details') }}</flux:heading>
            <flux:subheading class="mt-1 text-xs text-slate-500">{{ __('Modify name, abbreviation code, or campus designation.') }}</flux:subheading>
        </div>

        <div class="space-y-4">
            <div>
                <flux:input wire:model="college_name" :label="__('College / Unit Name')" required placeholder="e.g. College of Science" />
            </div>
            <div>
                <flux:input wire:model="college_code" :label="__('College Code / Abbreviation')" required placeholder="e.g. CS" />
            </div>
        </div>

        <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeEditCollegeModal">{{ __('Cancel') }}</flux:button>
            <flux:button type="submit" variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">{{ __('Save Changes') }}</flux:button>
        </div>
    </form>
</flux:modal>

<!-- Delete College Modal -->
<flux:modal wire:model="showDeleteCollegeModal" class="max-w-md md:min-w-md" @close="closeDeleteCollegeModal">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-700">{{ __('Soft Delete College?') }}</flux:heading>
            <flux:subheading class="mt-1 text-xs text-slate-500">
                {{ __('Are you sure you want to delete ') }} <strong>{{ $targetCollegeName }}</strong>? {{ __('This will soft-delete the college and all degree programs under it. Historical audit logs will be preserved.') }}
            </flux:subheading>
        </div>

        <div class="flex gap-3 justify-end">
            <flux:button variant="outline" wire:click="closeDeleteCollegeModal">{{ __('Cancel') }}</flux:button>
            <flux:button type="button" variant="danger" wire:click="deleteCollege">{{ __('Confirm Soft Delete') }}</flux:button>
        </div>
    </div>
</flux:modal>

<!-- Create Program Modal -->
<flux:modal wire:model="showCreateProgramModal" class="max-w-md md:min-w-md" @close="closeCreateProgramModal">
    <form wire:submit="createProgram" class="space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-orange-50 text-brand-orange flex items-center justify-center font-bold">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>
                <flux:heading size="lg">{{ __('Add Academic Program') }}</flux:heading>
            </div>
            <flux:subheading class="mt-1 text-xs text-slate-500">
                {{ __('Register a degree program under an institutional college or satellite campus.') }}
            </flux:subheading>
        </div>

        <div class="space-y-4">
            <div>
                <flux:select wire:model="program_college_id" :label="__('Parent College / Campus')" required placeholder="Select College">
                    <flux:select.option value="">Select College / Campus</flux:select.option>
                    @foreach($allCollegesDropdown as $c)
                    <flux:select.option value="{{ $c->id }}">{{ $c->name }} ({{ $c->code }})</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div>
                <flux:input wire:model="program_name" :label="__('Program Name')" required placeholder="e.g. Bachelor of Science in Computer Science" />
            </div>

            <div>
                <flux:input wire:model="program_code" :label="__('Program Code')" required placeholder="e.g. BSCS" />
            </div>

            <div>
                <flux:select wire:model="program_accreditation_level" :label="__('Accreditation Status / Level')" required placeholder="Select Accreditation Level">
                    @foreach($accreditationLevels as $al)
                    <flux:select.option value="{{ $al }}">{{ $al }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeCreateProgramModal">{{ __('Cancel') }}</flux:button>
            <flux:button type="submit" variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">
                {{ __('Add Program') }}
            </flux:button>
        </div>
    </form>
</flux:modal>

<!-- Edit Program Modal -->
<flux:modal wire:model="showEditProgramModal" class="max-w-md md:min-w-md" @close="closeEditProgramModal">
    <form wire:submit="updateProgram" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Edit Degree Program') }}</flux:heading>
            <flux:subheading class="mt-1 text-xs text-slate-500">{{ __('Update degree title, code, or accreditation level.') }}</flux:subheading>
        </div>

        <div class="space-y-4">
            <div>
                <flux:select wire:model="program_college_id" :label="__('Parent College / Campus')" required placeholder="Select College">
                    @foreach($allCollegesDropdown as $c)
                    <flux:select.option value="{{ $c->id }}">{{ $c->name }} ({{ $c->code }})</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div>
                <flux:input wire:model="program_name" :label="__('Program Name')" required placeholder="e.g. Bachelor of Science in Computer Science" />
            </div>

            <div>
                <flux:input wire:model="program_code" :label="__('Program Code')" required placeholder="e.g. BSCS" />
            </div>

            <div>
                <flux:select wire:model="program_accreditation_level" :label="__('Accreditation Status / Level')" required placeholder="Select Accreditation Level">
                    @foreach($accreditationLevels as $al)
                    <flux:select.option value="{{ $al }}">{{ $al }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeEditProgramModal">{{ __('Cancel') }}</flux:button>
            <flux:button type="submit" variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">{{ __('Save Changes') }}</flux:button>
        </div>
    </form>
</flux:modal>

<!-- Delete Program Modal -->
<flux:modal wire:model="showDeleteProgramModal" class="max-w-md md:min-w-md" @close="closeDeleteProgramModal">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-rose-700">{{ __('Soft Delete Program?') }}</flux:heading>
            <flux:subheading class="mt-1 text-xs text-slate-500">
                {{ __('Are you sure you want to delete ') }} <strong>{{ $targetProgramName }}</strong>? {{ __('This will soft-delete the program from active selections. Historical document links and audit trail will be retained.') }}
            </flux:subheading>
        </div>

        <div class="flex gap-3 justify-end">
            <flux:button variant="outline" wire:click="closeDeleteProgramModal">{{ __('Cancel') }}</flux:button>
            <flux:button type="button" variant="danger" wire:click="deleteProgram">{{ __('Confirm Soft Delete') }}</flux:button>
        </div>
    </div>
</flux:modal>
