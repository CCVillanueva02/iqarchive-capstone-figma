<!-- Modal for Uploading Common Document -->
<div x-show="showUploadModal" 
     x-cloak
     @click="closeUploadModal()" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-300 flex items-center justify-center p-4">
    
    <div @click.stop 
         x-show="showUploadModal"
         x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 max-w-lg w-full p-6 flex flex-col gap-5 relative z-310">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-orange/10 text-brand-orange flex items-center justify-center font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-heading-sm font-extrabold text-primary">Upload Common Document</h3>
                    <p class="text-body-sm text-zinc-400 mt-0.5">Attach a file and assign it to a category</p>
                </div>
            </div>
            <button type="button" @click="closeUploadModal()" class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Alert messages -->
        <template x-if="uploadError">
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-body-sm font-semibold" x-text="uploadError"></div>
        </template>
        <template x-if="uploadSuccess">
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-body-sm font-semibold" x-text="uploadSuccess"></div>
        </template>

        <!-- Form Body -->
        <form @submit.prevent="submitUploadDocument()" class="flex flex-col gap-4 font-sans">
            <!-- Document Title -->
            <div class="flex flex-col gap-1.5">
                <label class="text-body-sm font-bold text-primary">Document Title <span class="text-rose-500">*</span></label>
                <input type="text" x-model="uploadForm.title" placeholder="e.g. Bicol University Academic Code 2026" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-body-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
            </div>

            <!-- Document Category Select (Optional: Defaults to Uncategorized Documents) -->
            <div class="flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-body-sm font-bold text-primary">Document Category</label>
                    <span class="text-label font-medium text-zinc-400">Optional (Defaults to Uncategorized)</span>
                </div>
                <select x-model="uploadForm.category_name" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-body-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <option value="">None (Uncategorized Document)</option>
                    <template x-for="cat in categories" :key="cat.id || cat.name">
                        <option :value="cat.name" x-text="cat.name"></option>
                    </template>
                </select>
            </div>

            <!-- Attachment File -->
            <div class="flex flex-col gap-1.5">
                <label class="text-body-sm font-bold text-primary">Attachment File</label>
                <input type="file" id="adminFileUploadInput" @change="uploadForm.file = $event.target.files[0]" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx" />
                <label for="adminFileUploadInput" class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center bg-slate-50/50 hover:bg-slate-50 transition cursor-pointer flex flex-col items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-zinc-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                    </svg>
                    <span class="text-body-sm font-bold text-primary" x-text="uploadForm.file ? uploadForm.file.name : 'Click to select PDF or Word document'"></span>
                    <span class="text-label text-zinc-400" x-text="uploadForm.file ? (Math.round(uploadForm.file.size / 1024) + ' KB selected') : 'Supported formats: .pdf, .docx, .xlsx (Max: 25MB)'"></span>
                </label>
            </div>

            <!-- Modal Action Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" @click="closeUploadModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold text-body-sm rounded-xl transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" :disabled="uploadLoading" class="px-5 py-2.5 bg-brand-orange hover:bg-brand-orange-hover text-white font-bold text-body-sm rounded-xl transition shadow-2xs cursor-pointer flex items-center gap-2">
                    <span x-text="uploadLoading ? 'Uploading...' : 'Save Document'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/pages/documents/partials/common-documents/upload-modal.blade.php ENDPATH**/ ?>