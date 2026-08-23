<!-- ================= MODALS CONTAINER ================= -->
<div>
    <!-- 1. CREATE MASTER TEMPLATE MODAL -->
    @if ($showCreateTemplateModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-heading-sm font-extrabold text-primary">New Master Instrument Template</h3>
                <button type="button" wire:click="closeCreateTemplateModal" class="text-zinc-400 hover:text-zinc-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveTemplate" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Template Title</label>
                    <input type="text" wire:model="templateName" placeholder="e.g. AACCUP Master Template 2026" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange focus:border-brand-orange shadow-2xs">
                    @error('templateName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-body-sm font-bold text-slate-700">Template Code</label>
                        <input type="text" wire:model="templateCode" placeholder="e.g. INST-AACCUP-2026" class="w-full rounded-xl border-slate-200 text-body-sm font-medium uppercase focus:ring-brand-orange focus:border-brand-orange shadow-2xs">
                        @error('templateCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-body-sm font-bold text-slate-700">Level</label>
                        <select wire:model="templateLevel" class="w-full rounded-xl border-slate-200 text-body-sm font-semibold focus:ring-brand-orange focus:border-brand-orange shadow-2xs">
                            <option value="Candidate">Candidate Status</option>
                            <option value="Level I">Level I</option>
                            <option value="Level II">Level II</option>
                            <option value="Level III">Level III</option>
                            <option value="Level IV">Level IV</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Description</label>
                    <textarea wire:model="templateDescription" rows="2" placeholder="Brief notes or guidelines for this template..." class="w-full rounded-xl border-slate-200 text-body-sm focus:ring-brand-orange focus:border-brand-orange shadow-2xs"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeCreateTemplateModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-bold shadow-md transition cursor-pointer">Create Template</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 2. CLONE / DUPLICATE TEMPLATE MODAL -->
    @if ($showCloneTemplateModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-heading-sm font-extrabold text-primary">Duplicate Instrument Template</h3>
                <button type="button" wire:click="closeCloneModal" class="text-zinc-400 hover:text-zinc-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="cloneTemplate" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">New Template Name</label>
                    <input type="text" wire:model="templateName" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange focus:border-brand-orange shadow-2xs">
                    @error('templateName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">New Code</label>
                    <input type="text" wire:model="templateCode" class="w-full rounded-xl border-slate-200 text-body-sm font-medium uppercase focus:ring-brand-orange focus:border-brand-orange shadow-2xs">
                    @error('templateCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeCloneModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-sm font-bold shadow-md transition cursor-pointer">Duplicate Template</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 3. AREA MODAL (ADD / EDIT) -->
    @if ($showAreaModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-heading-sm font-extrabold text-primary">{{ $editingAreaId ? 'Edit Area' : 'Add Area' }}</h3>
                <button type="button" wire:click="closeAreaModal" class="text-zinc-400 hover:text-zinc-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveArea" class="flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-body-sm font-bold text-slate-700">Area Code</label>
                        <input type="text" wire:model="areaCode" placeholder="e.g. Area I" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                        @error('areaCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-body-sm font-bold text-slate-700">Display Order</label>
                        <input type="number" wire:model="areaOrder" min="1" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Area Name</label>
                    <input type="text" wire:model="areaName" placeholder="e.g. Vision, Mission, Goals, and Objectives" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                    @error('areaName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Weight (%)</label>
                    <input type="number" step="0.5" wire:model="areaWeight" placeholder="e.g. 10.0" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeAreaModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-bold shadow-md cursor-pointer">Save Area</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 4. PARAMETER MODAL (ADD / EDIT) -->
    @if ($showParameterModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-heading-sm font-extrabold text-primary">{{ $editingParameterId ? 'Edit Parameter' : 'Add Parameter' }}</h3>
                <button type="button" wire:click="closeParameterModal" class="text-zinc-400 hover:text-zinc-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveParameter" class="flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-body-sm font-bold text-slate-700">Parameter Code</label>
                        <input type="text" wire:model="parameterCode" placeholder="e.g. Parameter A" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                        @error('parameterCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-body-sm font-bold text-slate-700">Display Order</label>
                        <input type="number" wire:model="parameterOrder" min="1" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Parameter Title</label>
                    <input type="text" wire:model="parameterName" placeholder="e.g. Statement of VMGO" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                    @error('parameterName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeParameterModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-bold shadow-md cursor-pointer">Save Parameter</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 5. CRITERION MODAL (ADD / EDIT & TAGS) -->
    @if ($showCriterionModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-heading-sm font-extrabold text-primary">
                    {{ $editingCriterionId ? 'Edit Criterion' : 'Add Criterion to ' . ucwords(str_replace('_', ' ', $activeSection)) }}
                </h3>
                <button type="button" wire:click="closeCriterionModal" class="text-zinc-400 hover:text-zinc-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveCriterion" class="flex flex-col gap-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-body-sm font-bold text-slate-700">Code</label>
                        <input type="text" wire:model="criterionCode" placeholder="e.g. S.1" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                        @error('criterionCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5 col-span-2">
                        <label class="text-body-sm font-bold text-slate-700">Display Order</label>
                        <input type="number" wire:model="criterionOrder" min="1" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Criterion Statement / Benchmark Requirement</label>
                    <textarea wire:model="criterionStatement" rows="3" placeholder="Enter benchmark statement..." class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs"></textarea>
                    @error('criterionStatement') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Required Document Tags Input & Chips -->
                <div class="flex flex-col gap-2">
                    <label class="text-body-sm font-bold text-slate-700">Required Document Evidence Tags</label>
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model="newTagInput" wire:keydown.enter.prevent="addTag" placeholder="e.g. #BoardResolution (press Enter)" class="flex-1 rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                        <button type="button" wire:click="addTag" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-primary rounded-xl text-body-sm font-bold cursor-pointer">Add Tag</button>
                    </div>

                    <!-- Tags list chips -->
                    <div class="flex flex-wrap gap-2 min-h-8 p-2 bg-slate-50 border border-slate-200/80 rounded-xl">
                        @forelse ($criterionTags as $idx => $tag)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-label-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            <span>{{ $tag }}</span>
                            <button type="button" wire:click="removeTag({{ $idx }})" class="hover:text-rose-600 cursor-pointer">&times;</button>
                        </span>
                        @empty
                        <span class="text-label-xs text-zinc-400 italic">No tags added yet. Enter a tag above and press Add Tag.</span>
                        @endforelse
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeCriterionModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-bold shadow-md cursor-pointer">Save Criterion</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 6. DELETE CONFIRMATION MODAL -->
    @if ($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-heading-sm font-extrabold text-primary">Confirm Deletion</h3>
                <p class="text-body-sm text-zinc-500 mt-1">
                    Are you sure you want to delete <span class="font-bold text-primary">{{ $deleteTargetTitle }}</span>? This will permanently remove this item and all nested data.
                </p>
            </div>
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" wire:click="closeDeleteModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Cancel</button>
                <button type="button" wire:click="executeDelete" class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-body-sm font-bold shadow-md cursor-pointer">Delete Permanently</button>
            </div>
        </div>
    </div>
    @endif
</div>
