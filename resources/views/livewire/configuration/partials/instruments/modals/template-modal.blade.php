<!-- 1. CREATE & DUPLICATE TEMPLATE MODALS -->
<div>
    <!-- Create Master Template Modal -->
    @if ($showCreateTemplateModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-primary flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-heading-sm font-bold text-primary">New Instrument Template</h3>
                        <p class="text-label-xs text-zinc-500">Create a new accreditation standard template</p>
                    </div>
                </div>
                <button type="button" wire:click="closeCreateTemplateModal" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveTemplate" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Template Title <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="templateName" placeholder="e.g. AACCUP Master Template 2026" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    @error('templateName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Template Code <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="templateCode" placeholder="e.g. INST-AACCUP-2026" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 uppercase focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                        @error('templateCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Level</label>
                        <select wire:model="templateLevel" class="w-full rounded-lg border-slate-300 text-body-sm font-semibold text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                            <option value="Candidate">Candidate Status</option>
                            <option value="Level I">Level I</option>
                            <option value="Level II">Level II</option>
                            <option value="Level III">Level III</option>
                            <option value="Level IV">Level IV</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Description / Guidelines</label>
                    <textarea wire:model="templateDescription" rows="2" placeholder="Brief notes or guidelines for this template..." class="w-full rounded-lg border-slate-300 text-body-sm text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeCreateTemplateModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4.5 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Create Template</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Duplicate Template Modal -->
    @if ($showCloneTemplateModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-primary flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-heading-sm font-bold text-primary">Duplicate Instrument Template</h3>
                        <p class="text-label-xs text-zinc-500">Clone full area, parameter, and criteria structure</p>
                    </div>
                </div>
                <button type="button" wire:click="closeCloneModal" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="cloneTemplate" class="flex flex-col gap-4">
                <!-- Target Program Selector -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Duplicate for Program <span class="text-zinc-400 font-normal">(Optional)</span></label>
                    <select wire:model="cloneTargetProgramId" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition cursor-pointer">
                        <option value="">Generic Master Template (No Program)</option>
                        @foreach ($colleges as $college)
                            @if ($college->programs->isNotEmpty())
                            <optgroup label="{{ $college->name }} ({{ $college->code }})">
                                @foreach ($college->programs as $program)
                                <option value="{{ $program->id }}">
                                    {{ $program->name }} ({{ $program->code }})
                                </option>
                                @endforeach
                            </optgroup>
                            @endif
                        @endforeach
                    </select>
                    <span class="text-label-xs text-zinc-400">Select a program to create a custom instrument instance, or leave as generic template.</span>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">New Template Name <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="templateName" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    @error('templateName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">New Code <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="templateCode" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 uppercase focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    @error('templateCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeCloneModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4.5 py-2 rounded-lg bg-primary hover:bg-primary-hover text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Duplicate Structure</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
