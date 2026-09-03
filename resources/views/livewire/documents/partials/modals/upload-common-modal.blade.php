@if($showCommonUploadModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-zinc-900/40 backdrop-blur-xs transition-opacity" wire:click="closeCommonUploadModal"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-zinc-200">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-zinc-900" id="modal-title">Upload Common Document</h3>
                    <button wire:click="closeCommonUploadModal" class="text-zinc-400 hover:text-zinc-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Form Body -->
                <form wire:submit="uploadCommonDocument" class="p-6 space-y-4">
                    <!-- File Input -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 mb-1">File Document (PDF, Word, Excel up to 25MB)</label>
                        <input type="file" wire:model="uploadFile" class="block w-full text-xs text-zinc-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer border border-zinc-300 rounded-lg p-1.5">
                        @error('uploadFile') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="uploadFile" class="text-xs text-primary mt-1 font-medium">Uploading file preview...</div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 mb-1">Document Title</label>
                        <input type="text" wire:model="uploadTitle" placeholder="e.g. 2026 Faculty Manual Revision" class="w-full text-xs px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-900">
                        @error('uploadTitle') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Office & Category Selectors -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-zinc-700 mb-1">Originating Office</label>
                            <select wire:model="uploadOfficeId" class="w-full text-xs px-2.5 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-800">
                                @foreach($offices as $o)
                                    <option value="{{ $o->id }}">{{ $o->name }}</option>
                                @endforeach
                            </select>
                            @error('uploadOfficeId') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-zinc-700 mb-1">Document Category</label>
                            <select wire:model="uploadCategoryId" class="w-full text-xs px-2.5 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-800">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('uploadCategoryId') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 mb-1">Description (Optional)</label>
                        <textarea wire:model="uploadDescription" rows="2" placeholder="Brief context or summary of document..." class="w-full text-xs px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-900"></textarea>
                        @error('uploadDescription') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Modal Actions -->
                    <div class="pt-3 border-t border-zinc-100 flex items-center justify-end gap-2">
                        <button type="button" wire:click="closeCommonUploadModal" class="px-4 py-2 text-xs font-semibold text-zinc-600 hover:bg-zinc-100 rounded-lg transition">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 transition shadow-sm flex items-center gap-1.5">
                            <span wire:loading.remove wire:target="uploadCommonDocument">Save Document</span>
                            <span wire:loading wire:target="uploadCommonDocument">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
