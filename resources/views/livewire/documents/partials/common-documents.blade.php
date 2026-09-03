<div class="p-6 space-y-6">
    <!-- Filter & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-zinc-200 shadow-3xs">
        <div class="flex flex-wrap items-center gap-3 flex-1">
            <!-- Search Input -->
            <div class="relative w-full max-w-xs">
                <input wire:model.live.debounce.300ms="searchQuery" type="text" placeholder="Search title or uploader..."
                    class="w-full pl-9 pr-3 py-1.5 text-xs bg-zinc-50 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-900 placeholder:text-zinc-400">
                <svg class="w-4 h-4 text-zinc-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <!-- Office Filter -->
            <select wire:model.live="selectedOfficeId" class="text-xs bg-zinc-50 border border-zinc-300 rounded-lg px-2.5 py-1.5 text-zinc-700">
                <option value="">All Offices</option>
                @foreach($offices as $office)
                    <option value="{{ $office->id }}">{{ $office->name }}</option>
                @endforeach
            </select>

            <!-- Category Filter -->
            <select wire:model.live="selectedCategoryId" class="text-xs bg-zinc-50 border border-zinc-300 rounded-lg px-2.5 py-1.5 text-zinc-700">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <!-- Status Filter -->
            <select wire:model.live="statusFilter" class="text-xs bg-zinc-50 border border-zinc-300 rounded-lg px-2.5 py-1.5 text-zinc-700">
                <option value="all">All Statuses</option>
                <option value="Verified">Verified</option>
                <option value="Pending">Pending</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>

        <!-- Upload Button -->
        <button wire:click="openCommonUploadModal" class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 shadow-sm transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Upload Common Document
        </button>
    </div>

    <!-- Documents Table -->
    <x-ui.table :headers="['Document', 'Office / Category', 'Uploader', 'Status', 'Date', 'Actions']" :pagination="$commonDocuments->hasPages() ? $commonDocuments->links() : null">
        @forelse($commonDocuments as $doc)
            <tr class="hover:bg-zinc-50/80 transition-colors">
                <!-- Document Info -->
                <td class="py-3 px-6">
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-0.5 rounded text-label-xs font-black shrink-0 {{ $doc->file_extension === 'PDF' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-primary/10 text-primary border border-primary/20' }}">
                            {{ $doc->file_extension ?? 'PDF' }}
                        </span>
                        <div class="min-w-0 max-w-xs">
                            <button wire:click="viewDocumentDetails({{ $doc->id }})" class="text-body-sm font-semibold text-zinc-900 hover:text-primary transition truncate block text-left">
                                {{ $doc->title }}
                            </button>
                            <span class="text-xs text-zinc-400">{{ $doc->file_size ?? 'N/A' }}</span>
                        </div>
                    </div>
                </td>

                <!-- Office / Category -->
                <td class="py-3 px-6">
                    <div class="text-xs font-medium text-zinc-800">{{ $doc->office?->name ?? 'General Office' }}</div>
                    <div class="text-xs text-zinc-500">{{ $doc->category?->name ?? 'Uncategorized' }}</div>
                </td>

                <!-- Uploader -->
                <td class="py-3 px-6">
                    <div class="text-xs text-zinc-700 font-medium">{{ $doc->uploader?->full_name ?? 'System' }}</div>
                </td>

                <!-- Status -->
                <td class="py-3 px-6">
                    @if($doc->status === 'Verified')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-label-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Verified
                        </span>
                    @elseif($doc->status === 'Pending')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-label-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                            Pending Review
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-label-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                            {{ $doc->status ?? 'Draft' }}
                        </span>
                    @endif
                </td>

                <!-- Date -->
                <td class="py-3 px-6 text-xs text-zinc-500">
                    {{ $doc->created_at?->format('M d, Y') ?? '—' }}
                </td>

                <!-- Actions -->
                <td class="py-3 px-6 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button wire:click="viewDocumentDetails({{ $doc->id }})" class="p-1.5 text-zinc-500 hover:text-primary rounded-lg hover:bg-zinc-100 transition" title="View Details">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" download class="p-1.5 text-zinc-500 hover:text-primary rounded-lg hover:bg-zinc-100 transition" title="Download">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="py-12 text-center text-zinc-500">
                    <svg class="w-10 h-10 mx-auto text-zinc-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-sm font-semibold text-zinc-700">No common documents found</p>
                    <p class="text-xs text-zinc-400 mt-0.5">Try refining your search query or filters.</p>
                </td>
            </tr>
        @endforelse
    </x-ui.table>
</div>
