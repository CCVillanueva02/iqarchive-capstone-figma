<div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-3xs space-y-6">
    <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
        <div>
            <h3 class="text-sm font-bold text-zinc-900">Accreditation Compliance Reports</h3>
            <p class="text-xs text-zinc-500 mt-0.5">Summary of verified evidence documents and compliance status for {{ $selectedProgram?->name ?? 'Program' }}</p>
        </div>
        <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-semibold">
            {{ $evidenceDocuments->where('status', 'Verified')->count() }} of {{ $evidenceDocuments->count() }} Verified
        </span>
    </div>

    <!-- Compliance Document Table -->
    <x-ui.table :headers="['Requirement / Title', 'Criterion Code', 'Status', 'Date', 'Action']">
        @forelse($evidenceDocuments as $doc)
            @php
                $criterion = $doc->accreditationLinks->first()?->complianceRequirement?->criterion;
            @endphp
            <tr class="hover:bg-zinc-50/80 transition-colors">
                <td class="py-3 px-6">
                    <div class="flex items-center gap-2.5">
                        <span class="px-2 py-0.5 rounded text-label-xs font-black {{ $doc->file_extension === 'PDF' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-primary/10 text-primary border border-primary/20' }}">
                            {{ $doc->file_extension ?? 'FILE' }}
                        </span>
                        <div>
                            <button wire:click="viewDocumentDetails({{ $doc->id }})" class="text-xs font-bold text-zinc-900 hover:text-primary transition truncate block text-left">
                                {{ $doc->title }}
                            </button>
                            <span class="text-label-xs text-zinc-400">{{ $doc->file_size ?? 'N/A' }}</span>
                        </div>
                    </div>
                </td>

                <td class="py-3 px-6 text-xs font-semibold text-zinc-700">
                    {{ $criterion?->code ?? 'General Benchmark' }}
                </td>

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

                <td class="py-3 px-6 text-xs text-zinc-500">
                    {{ $doc->created_at?->format('M d, Y') ?? '—' }}
                </td>

                <td class="py-3 px-6 text-right">
                    <button wire:click="viewDocumentDetails({{ $doc->id }})" class="text-xs text-primary hover:underline font-semibold">
                        Review Details
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-8 text-center text-zinc-400 text-xs">
                    No compliance documents attached for this program yet.
                </td>
            </tr>
        @endforelse
    </x-ui.table>
</div>
