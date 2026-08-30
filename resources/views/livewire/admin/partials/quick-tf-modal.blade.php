<flux:modal wire:model="showQuickTfModal" class="max-w-lg md:min-w-lg no-scrollbar scrollbar-none" @close="closeQuickTfModal">
    <form wire:submit="quickRegisterTaskForce" class="space-y-5">
        <!-- Header -->
        <div class="border-b border-slate-200 pb-4">
            <h2 class="text-heading font-bold text-primary-dark tracking-tight mt-1">
                Quick Pre-Register Task Force
            </h2>
        </div>

        <div class="space-y-4">
            <!-- 1. College Selection -->
            <div>
                <flux:select wire:model.live="quick_tf_college_id" :label="__('College / Department *')" placeholder="Select College / Department" required size="sm">
                    <flux:select.option value="">Select College / Department</flux:select.option>
                    @foreach($colleges as $college)
                        <flux:select.option value="{{ $college->id }}">{{ $college->name }} ({{ $college->code }})</flux:select.option>
                    @endforeach
                </flux:select>
                @error('quick_tf_college_id')
                <p class="text-label-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Program Selection (Optional) -->
            <div>
                <flux:select wire:model="quick_tf_program_id" :label="__('Degree Program (Optional)')" placeholder="All / None (College-Wide)" :disabled="empty($quick_tf_college_id)" size="sm">
                    <flux:select.option value="">All / None (College-Wide)</flux:select.option>
                    @foreach($quickTfPrograms as $prog)
                        <flux:select.option value="{{ $prog->id }}">{{ $prog->name }} ({{ $prog->code }})</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <!-- 3. Multiple Institutional Emails -->
            <div>
                <label class="block text-body-sm font-bold text-slate-700 mb-1">
                    Institutional Emails *
                </label>
                <textarea 
                    wire:model="quick_tf_emails" 
                    rows="4" 
                    required
                    placeholder="Enter email addresses (one per line or comma-separated)&#10;e.g.&#10;maria.santos@bicol-u.edu.ph&#10;juan.delacruz@bicol-u.edu.ph"
                    class="w-full text-body-sm font-mono rounded-xl border border-slate-200 p-3 text-slate-800 placeholder:text-slate-400 focus:border-brand-orange focus:ring-1 focus:ring-brand-orange transition-colors"></textarea>
                @error('quick_tf_emails')
                <p class="text-label-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-label-xs text-slate-500 mt-1">
                    You can paste multiple email addresses at once.
                </p>
            </div>

            <!-- Informational Note -->
            <div class="bg-surface-subtle border border-slate-200/80 rounded-xl p-3 text-label text-slate-600 flex items-start gap-2">
                <svg class="w-4 h-4 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Accounts default to <strong>Pending Activation</strong> until first sign-in.
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeQuickTfModal">
                {{ __('Cancel') }}
            </flux:button>

            <button 
                type="submit" 
                class="px-4 py-2 rounded-xl text-body-sm font-bold bg-brand-orange hover:bg-brand-orange-hover text-white transition-colors cursor-pointer shadow-xs">
                {{ __('Pre-Register Task Force') }}
            </button>
        </div>
    </form>
</flux:modal>
