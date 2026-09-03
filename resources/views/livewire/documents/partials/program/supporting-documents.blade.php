<div class="space-y-6">
    <!-- Area Navigation Strip -->
    @if($instrument && $instrument->areas->isNotEmpty())
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
            @foreach($instrument->areas as $area)
                <button wire:click="selectArea({{ $area->id }})"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all border shrink-0 flex items-center gap-2 {{ $activeAreaId === $area->id ? 'bg-primary text-white border-primary shadow-xs' : 'bg-white text-zinc-700 border-zinc-200 hover:border-zinc-300 hover:bg-zinc-50' }}">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-label-xs {{ $activeAreaId === $area->id ? 'bg-white/20 text-white' : 'bg-zinc-100 text-zinc-600' }}">
                        {{ $loop->iteration }}
                    </span>
                    <span>{{ $area->code }}: {{ Str::limit($area->name, 24) }}</span>
                </button>
            @endforeach
        </div>
    @endif

    <!-- Main Workspace Grid: Parameters Sidebar + Evidence Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Parameters Navigation Sidebar -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-zinc-200 shadow-3xs p-4 space-y-3">
            <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-500">Parameters</h3>
                <span class="text-xs font-semibold text-primary bg-primary/10 px-2 py-0.5 rounded">
                    {{ $activeArea?->code ?? 'Area' }}
                </span>
            </div>

            <div class="space-y-1.5">
                @if($activeArea && $activeArea->parameters->isNotEmpty())
                    @foreach($activeArea->parameters as $param)
                        <button wire:click="selectParameter({{ $param->id }})"
                            class="w-full text-left p-3 rounded-xl text-xs font-semibold transition-all border {{ $activeParameterId === $param->id ? 'bg-primary/5 text-primary border-primary/30 shadow-xs' : 'text-zinc-700 border-transparent hover:bg-zinc-50 hover:border-zinc-200' }}">
                            <div class="flex items-center justify-between">
                                <span class="font-bold">{{ $param->code }}</span>
                                <span class="text-label-xs text-zinc-400">{{ $param->criteria->count() }} criteria</span>
                            </div>
                            <p class="text-label-xs font-normal text-zinc-600 mt-1 line-clamp-2">{{ $param->name }}</p>
                        </button>
                    @endforeach
                @else
                    <p class="text-xs text-zinc-400 py-4 text-center">No parameters found for this area.</p>
                @endif
            </div>
        </div>

        <!-- Evidence & Criteria Panel -->
        <div class="lg:col-span-8 space-y-4">
            <!-- Section Tabs Bar (Systems, Implementation, Outcomes) -->
            <div class="flex items-center gap-2 border-b border-zinc-200 pb-2">
                @foreach(['systems' => 'Systems', 'implementation' => 'Implementation', 'outcomes' => 'Outcomes', 'best_practices' => 'Best Practices'] as $sKey => $sLabel)
                    <button wire:click="selectSection('{{ $sKey }}')"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $activeSection === $sKey ? 'bg-zinc-900 text-white' : 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100' }}">
                        {{ $sLabel }}
                    </button>
                @endforeach
            </div>

            <!-- Active Criteria & Upload Triggers -->
            @php
                $criteria = match($activeSection) {
                    'systems' => $activeParameter?->systemsCriteria ?? collect(),
                    'implementation' => $activeParameter?->implementationCriteria ?? collect(),
                    'outcomes' => $activeParameter?->outcomesCriteria ?? collect(),
                    default => $activeParameter?->bestPracticesCriteria ?? collect(),
                };
            @endphp

            <div class="space-y-3">
                @forelse($criteria as $crit)
                    <div class="bg-white rounded-xl border border-zinc-200 p-4 shadow-3xs space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-2.5">
                                <span class="px-2 py-0.5 rounded text-xs font-black bg-zinc-100 text-zinc-800 border border-zinc-200 shrink-0">
                                    {{ $crit->code }}
                                </span>
                                <div>
                                    <p class="text-xs font-bold text-zinc-900">{{ $crit->statement }}</p>
                                    @if($crit->description)
                                        <p class="text-xs text-zinc-500 mt-0.5">{{ $crit->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <button wire:click="openEvidenceUploadModal({{ $crit->id }}, '{{ $crit->code }}')"
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-primary/10 text-primary hover:bg-primary/20 text-xs font-semibold shrink-0 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Attach Evidence
                            </button>
                        </div>

                        <!-- Attached Evidence Documents for this Criterion -->
                        @php
                            $attachedDocs = $evidenceDocuments->filter(function($doc) use ($crit) {
                                return $doc->accreditationLinks->contains(fn($link) => $link->complianceRequirement?->instrument_criterion_id === $crit->id);
                            });
                        @endphp

                        @if($attachedDocs->isNotEmpty())
                            <div class="pt-2 border-t border-zinc-100 space-y-2">
                                @foreach($attachedDocs as $adoc)
                                    <x-ui.document-chip
                                        :title="$adoc->title"
                                        :size="$adoc->file_size"
                                        :type="$adoc->file_extension"
                                        :date="$adoc->created_at?->format('M d, Y')"
                                        :uploader="$adoc->uploader?->full_name"
                                        :status="$adoc->status"
                                        :downloadUrl="Storage::url($adoc->file_path)"
                                        wire:click="viewDocumentDetails({{ $adoc->id }})"
                                        class="cursor-pointer"
                                    />
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <!-- Fallback: Display general uploaded documents for this program -->
                    <div class="bg-white rounded-xl border border-zinc-200 p-6 text-center shadow-3xs">
                        <p class="text-xs text-zinc-500">No specific benchmark criteria configured for this section.</p>
                        <button wire:click="openEvidenceUploadModal" class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Upload General Program Evidence
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
