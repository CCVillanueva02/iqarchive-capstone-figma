<!-- Modal for Creating New Category (IQA Admin & System Admin only) -->
<div x-show="showCreateCategoryModal" 
     x-cloak
     @click="closeCreateCategoryModal()" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-[300] flex items-center justify-center p-4">
    
    <div @click.stop 
         x-show="showCreateCategoryModal"
         x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 max-w-lg w-full p-6 flex flex-col gap-5 relative z-[310]">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-surface-subtle text-primary flex items-center justify-center font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-heading-sm font-extrabold text-primary">Create Document Category</h3>
                    <p class="text-body-sm text-zinc-400 mt-0.5">Add a new category card to organize common documents</p>
                </div>
            </div>
            <button type="button" @click="closeCreateCategoryModal()" class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Alert messages -->
        <template x-if="createCategoryError">
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-body-sm font-semibold" x-text="createCategoryError"></div>
        </template>
        <template x-if="createCategorySuccess">
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-body-sm font-semibold" x-text="createCategorySuccess"></div>
        </template>

        <!-- Form Body -->
        <form @submit.prevent="submitNewCategory()" class="flex flex-col gap-4 font-sans">
            <div class="flex flex-col gap-1.5">
                <label class="text-body-sm font-bold text-primary">Category Name <span class="text-rose-500">*</span></label>
                <input type="text" x-model="newCategoryForm.name" placeholder="e.g. Research & Publication Policies" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-body-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-body-sm font-bold text-primary">Category Description</label>
                <textarea x-model="newCategoryForm.description" rows="3" placeholder="Brief summary of files contained in this category card..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-body-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
            </div>

            <!-- Modal Action Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" @click="closeCreateCategoryModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold text-body-sm rounded-xl transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" :disabled="createCategoryLoading" class="px-5 py-2.5 bg-primary hover:bg-primary-dark-hover text-white font-bold text-body-sm rounded-xl transition shadow-2xs cursor-pointer flex items-center gap-2">
                    <span x-text="createCategoryLoading ? 'Creating...' : 'Create Category Card'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
