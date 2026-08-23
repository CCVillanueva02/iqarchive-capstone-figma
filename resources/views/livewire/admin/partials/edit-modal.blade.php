<flux:modal wire:model="showEditModal" class="max-w-md md:min-w-md no-scrollbar scrollbar-none" @close="closeEditModal">
    <form wire:submit="updateAccount" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Edit User Account') }}</flux:heading>
            <flux:subheading class="mt-1 text-xs text-slate-500">{{ __('Modify role and affiliation assignments for this user.') }}</flux:subheading>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <flux:input wire:model="first_name" :label="__('First Name')" placeholder="First Name" />
                </div>
                <div>
                    <flux:input wire:model="last_name" :label="__('Last Name')" placeholder="Last Name" />
                </div>
            </div>

            <div>
                <flux:input 
                    wire:model="email" 
                    :label="__('Institutional Email Address')" 
                    type="email" 
                    required 
                    placeholder="user@bicol-u.edu.ph" 
                />
            </div>

            <!-- Role Selector -->
            <div>
                <flux:select wire:model.live="role_id" :label="__('Primary Role')" required placeholder="Select role">
                    @foreach($roles as $role)
                        <flux:select.option value="{{ $role->id }}">{{ $role->description }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <!-- Additional Roles -->
            <div>
                <label class="block text-body-sm font-bold text-slate-700 mb-1.5">{{ __('Additional Assigned Roles') }}</label>
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
            </div>

            <!-- College Selection -->
            <div>
                <flux:select wire:model.live="college_id" :label="__('College / Department') . ($this->isCollegeRequired() ? ' *' : '')" placeholder="None (Optional)" :required="$this->isCollegeRequired()">
                    <flux:select.option value="">None (Optional)</flux:select.option>
                    @foreach($colleges as $college)
                        <flux:select.option value="{{ $college->id }}">{{ $college->name }} ({{ $college->code }})</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <!-- Program Selection -->
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
            <flux:button variant="outline" wire:click="closeEditModal">{{ __('Cancel') }}</flux:button>
            <button type="submit" class="px-4 py-2 rounded-xl text-body-sm font-bold bg-primary hover:bg-primary-hover text-white transition-colors cursor-pointer shadow-xs">
                {{ __('Save Changes') }}
            </button>
        </div>
    </form>
</flux:modal>
