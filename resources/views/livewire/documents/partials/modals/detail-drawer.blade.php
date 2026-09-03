@if($showDetailDrawer && $drawerDocument)
    <div class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="drawer-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-zinc-900/40 backdrop-blur-xs transition-opacity" wire:click="closeDetailDrawer"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md bg-white shadow-2xl border-l border-zinc-200 flex flex-col">
                <!-- Header -->
                <div class="p-6 border-b border-zinc-100 flex items-start justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <span class="px-2 py-0.5 rounded text-label-xs font-black {{ $drawerDocument->file_extension === 'PDF' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-primary/10 text-primary border border-primary/20' }}">
                            {{ $drawerDocument->file_extension ?? 'FILE' }}
                        </span>
                        <h3 class="text-sm font-bold text-zinc-900 mt-2 truncate" id="drawer-title">{{ $drawerDocument->title }}</h3>
                        <p class="text-xs text-zinc-400 mt-0.5">{{ $drawerDocument->file_size }} • Uploaded {{ $drawerDocument->created_at?->diffForHumans() }}</p>
                    </div>
                    <button wire:click="closeDetailDrawer" class="text-zinc-400 hover:text-zinc-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Body / Metadata -->
                <div class="p-6 space-y-6 flex-1 overflow-y-auto">
                    <!-- Status Section -->
                    <div class="p-4 bg-zinc-50 rounded-xl border border-zinc-200 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-zinc-500">Status</span>
                            @if($drawerDocument->status === 'Verified')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Verified
                                </span>
                            @elseif($drawerDocument->status === 'Pending')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    Pending Review
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    {{ $drawerDocument->status }}
                                </span>
                            @endif
                        </div>

                        <!-- Verification Controls for Authorized Reviewers -->
                        @if($isUnrestricted || Auth::user()->hasRole('college-head'))
                            <div class="pt-3 border-t border-zinc-200/60 flex items-center gap-2">
                                <span class="text-xs text-zinc-600 font-semibold">Change:</span>
                                <button wire:click="updateDocumentStatus({{ $drawerDocument->id }}, 'Verified')" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-label-xs font-bold rounded transition">
                                    Verify
                                </button>
                                <button wire:click="updateDocumentStatus({{ $drawerDocument->id }}, 'Needs Revision')" class="px-2.5 py-1 bg-amber-500 hover:bg-amber-600 text-white text-label-xs font-bold rounded transition">
                                    Needs Revision
                                </button>
                                <button wire:click="updateDocumentStatus({{ $drawerDocument->id }}, 'Rejected')" class="px-2.5 py-1 bg-rose-600 hover:bg-rose-700 text-white text-label-xs font-bold rounded transition">
                                    Reject
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Metadata Details -->
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-2 border-b border-zinc-100">
                            <span class="text-zinc-500 font-medium">Uploader:</span>
                            <span class="font-bold text-zinc-900">{{ $drawerDocument->uploader?->full_name ?? 'System' }}</span>
                        </div>

                        @if($drawerDocument->program)
                            <div class="flex justify-between py-2 border-b border-zinc-100">
                                <span class="text-zinc-500 font-medium">Program:</span>
                                <span class="font-bold text-zinc-900">{{ $drawerDocument->program->name }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-zinc-100">
                                <span class="text-zinc-500 font-medium">College:</span>
                                <span class="font-bold text-zinc-900">{{ $drawerDocument->program->college?->name }}</span>
                            </div>
                        @else
                            <div class="flex justify-between py-2 border-b border-zinc-100">
                                <span class="text-zinc-500 font-medium">Office:</span>
                                <span class="font-bold text-zinc-900">{{ $drawerDocument->office?->name ?? 'General' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-zinc-100">
                                <span class="text-zinc-500 font-medium">Category:</span>
                                <span class="font-bold text-zinc-900">{{ $drawerDocument->category?->name ?? 'General' }}</span>
                            </div>
                        @endif

                        @if($drawerDocument->description)
                            <div class="py-2 border-b border-zinc-100 space-y-1">
                                <span class="text-zinc-500 font-medium block">Annotation / Context:</span>
                                <p class="text-zinc-700 leading-relaxed bg-zinc-50 p-2.5 rounded-lg border border-zinc-200/80">{{ $drawerDocument->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-6 border-t border-zinc-100 bg-zinc-50 flex items-center justify-between gap-3">
                    @if($isUnrestricted || $drawerDocument->uploaded_by === Auth::id())
                        <button wire:click="deleteDocument({{ $drawerDocument->id }})" wire:confirm="Are you sure you want to delete this document?" class="px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition">
                            Delete Document
                        </button>
                    @else
                        <div></div>
                    @endif

                    <a href="{{ Storage::url($drawerDocument->file_path) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download File
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
