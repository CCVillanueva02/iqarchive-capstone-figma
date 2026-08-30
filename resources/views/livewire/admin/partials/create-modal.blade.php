<flux:modal wire:model="showCreateModal" class="max-w-md md:min-w-md no-scrollbar scrollbar-none" @close="closeCreateModal">
    <form wire:submit="createAccount" class="space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-surface-subtle text-primary flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <flux:heading size="lg">{{ __('Pre-Register User') }}</flux:heading>
            </div>
            <flux:subheading class="mt-1 text-xs text-slate-500">
                {{ __('Pre-registers institutional identity and role assignment. Account authentication is completed by the user via Google Workspace.') }}
            </flux:subheading>
        </div>

        <div class="space-y-4">
            <!-- 1. Institutional Email -->
            <div>
                <flux:input 
                    wire:model="email" 
                    :label="__('Institutional Email')" 
                    type="email" 
                    required 
                    placeholder="user@bicol-u.edu.ph" 
                />
                <p class="text-label-xs text-slate-400 mt-1">Must match official Google Workspace domain (@bicol-u.edu.ph).</p>
            </div>
            
            <!-- 2. Primary Role Selector -->
            <div>
                <flux:select wire:model.live="role_id" :label="__('Primary Role')" required placeholder="Select primary role">
                    <flux:select.option value="">Select primary role</flux:select.option>
                    @foreach($roles as $role)
                        <flux:select.option value="{{ $role->id }}">{{ $role->description }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <!-- Additional Roles (Multi-Role Support) -->
            <div>
                <label class="block text-body-sm font-bold text-slate-700 mb-1.5">{{ __('Additional Assigned Roles (Optional)') }}</label>
                <div class="grid grid-cols-2 gap-2 bg-slate-50 p-3 rounded-xl border border-slate-200">
                    @foreach($roles as $role)
                        @if((string)$role->id !== (string)$role_id)
                            <label class="flex items-center gap-2 text-body-sm font-semibold text-slate-700 cursor-pointer select-none hover:text-primary-dark">
                                <input type="checkbox" wire:model.live="selected_role_ids" value="{{ $role->id }}" class="rounded border-slate-300 text-brand-orange focus:ring-brand-orange">
                                <span>{{ $role->description }}</span>
                            </label>
                        @endif
                    @endforeach
                </div>
                <p class="text-label-xs text-slate-400 mt-1">Check any additional roles held by this user (e.g. Task Force Member).</p>
            </div>

            <!-- 3. College / Department (Conditional Required) -->
            <div>
                <flux:select wire:model.live="college_id" :label="__('College / Department') . ($this->isCollegeRequired() ? ' *' : '')" placeholder="Select College / Department" :required="$this->isCollegeRequired()">
                    <flux:select.option value="">Select College / Department</flux:select.option>
                    @foreach($colleges as $college)
                        <flux:select.option value="{{ $college->id }}">{{ $college->name }} ({{ $college->code }})</flux:select.option>
                    @endforeach
                </flux:select>
                @if($this->isCollegeRequired())
                    <p class="text-label-xs font-semibold text-amber-600 mt-1">Required for College Head role.</p>
                @else
                    <p class="text-label-xs text-slate-400 mt-1">Required for College/Dept Head and affiliated faculty.</p>
                @endif
            </div>

            <!-- Program (Optional) -->
            <div>
                <flux:select wire:model="program_id" :label="__('Program (Optional)')" placeholder="None (Optional)" :disabled="empty($college_id)">
                    <flux:select.option value="">None (Optional)</flux:select.option>
                    @foreach($programs as $program)
                        <flux:select.option value="{{ $program->id }}">{{ $program->name }} ({{ $program->code }})</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeCreateModal">{{ __('Cancel') }}</flux:button>
            <button type="submit" class="px-4 py-2 rounded-xl text-body-sm font-bold bg-primary hover:bg-primary-hover text-white transition-colors cursor-pointer shadow-xs">
                {{ __('Pre-Register User') }}
            </button>
        </div>
    </form>
</flux:modal>
