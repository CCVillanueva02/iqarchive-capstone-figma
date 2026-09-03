<!-- Main Review Workspace: Parameters & Criteria Checklist -->
<div class="flex flex-col lg:flex-row gap-5 items-start w-full">
    <!-- Left Pane: Parameters Available in Active Area -->
    <div class="w-full lg:w-72 shrink-0 flex flex-col gap-3 bg-white border border-zinc-200/80 rounded-2xl p-4 shadow-3xs">
        <div class="flex items-center justify-between px-1">
            <span class="text-body-sm font-bold text-primary-dark">Parameters</span>
            <span class="text-label-xs font-semibold text-zinc-400">{{ $activeArea?->code }}</span>
        </div>

        <div class="flex flex-col gap-1.5">
            @if($activeArea && $activeArea->parameters->isNotEmpty())
                @foreach($activeArea->parameters as $param)
                    @php
                        $isParamActive = $activeParameterId === $param->id;
                        $paramDocs = $allProgramDocs->filter(function($doc) use ($param) {
                            foreach ($doc->accreditationLinks as $link) {
                                $crit = $link->complianceRequirement?->criterion;
                                if ($crit && $crit->instrument_parameter_id === $param->id) {
                                    return true;
                                }
                            }
                            return false;
                        });
                        $pTotal = $paramDocs->count();
                        $pVerified = $paramDocs->where('status', 'verified')->count();
                    @endphp
                    <button type="button"
                        wire:click="selectParameter({{ $param->id }})"
                        class="w-full text-left p-3 rounded-xl text-body-sm font-semibold flex flex-col gap-1 transition cursor-pointer relative overflow-hidden {{ $isParamActive ? 'bg-surface-subtle text-primary border-l-4 border-primary pl-2.5 shadow-3xs' : 'text-zinc-600 hover:bg-surface-subtle hover:text-primary pl-3.5 border-l-4 border-transparent' }}">
                        <div class="flex items-center justify-between w-full">
                            <span class="font-bold text-primary text-label-xs uppercase tracking-wide">{{ $param->code }}</span>
                            <span class="text-label-xs font-bold {{ $pTotal > 0 && $pVerified === $pTotal ? 'text-emerald-600' : 'text-zinc-400' }}">
                                {{ $pVerified }}/{{ $pTotal }}
                            </span>
                        </div>
                        <span class="text-xs font-bold leading-snug mt-0.5 text-primary-dark line-clamp-2">{{ $param->name }}</span>
                    </button>
                @endforeach
            @else
                <div class="p-3 text-label-xs text-zinc-400 italic">No parameters defined.</div>
            @endif
        </div>
    </div>

    <!-- Right Pane: Section Navigation & Criteria Checklist Review -->
    <div class="flex-1 bg-white border border-zinc-200/80 rounded-2xl p-6 shadow-3xs flex flex-col gap-6 w-full">
        <!-- Parameter Title Header -->
        <div class="flex flex-col gap-3 pb-4 border-b border-zinc-100">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-label-xs font-bold text-primary uppercase tracking-wider">{{ $activeArea?->code }} · {{ $activeParameter?->code }}</span>
                    <h2 class="text-heading-sm font-extrabold text-primary-dark mt-1">{{ $activeParameter?->name }}</h2>
                </div>
            </div>

            <!-- Section Navigation Tabs -->
            <div class="flex border-b border-zinc-200 gap-6 text-body-sm font-bold -mb-4 pt-2 overflow-x-auto">
                @foreach(['systems' => 'Systems - Inputs & Processes', 'implementation' => 'Implementation', 'outcomes' => 'Outcomes', 'bestpractices' => 'Best Practices'] as $secKey => $secLabel)
                    <button type="button"
                        wire:click="selectSection('{{ $secKey }}')"
                        class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap {{ $activeSection === $secKey ? 'border-brand-orange text-primary font-black' : 'border-transparent text-zinc-400 hover:text-zinc-600' }}">
                        {{ $secLabel }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Criteria List -->
        <div class="flex flex-col gap-4">
            @forelse($criteria as $criterion)
                @php
                    $critDocs = $allProgramDocs->filter(function($doc) use ($criterion) {
                        foreach ($doc->accreditationLinks as $link) {
                            $req = $link->complianceRequirement;
                            if ($req && ($req->instrument_criterion_id === $criterion->id || $req->criterion?->id === $criterion->id)) {
                                return true;
                            }
                        }
                        return false;
                    });
                @endphp
                <div class="border border-zinc-200/90 rounded-2xl p-5 flex flex-col gap-4 bg-surface-subtle/40 shadow-3xs">
                    <!-- Criterion Header -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <span class="text-xs font-extrabold text-primary bg-primary/10 border border-primary/15 px-3 py-1 rounded-full shrink-0">
                                {{ $criterion->code }}
                            </span>
                            <div>
                                <p class="text-body-sm font-bold text-zinc-900 leading-relaxed">{{ $criterion->statement }}</p>
                                @if(!empty($criterion->required_tags))
                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                        @foreach($criterion->required_tags as $tag)
                                            <span class="px-2 py-0.5 rounded-md text-label-xs font-semibold bg-zinc-100 text-zinc-600 border border-zinc-200">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Linked Documents List -->
                    <div class="pl-0 sm:pl-10 flex flex-col gap-2.5">
                        <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider">
                            Attached Evidence ({{ $critDocs->count() }})
                        </span>

                        @forelse($critDocs as $doc)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 bg-white border border-zinc-200/80 rounded-xl text-body-sm gap-3 shadow-3xs">
                                <div class="flex items-center gap-3 min-w-0">
                                    <x-lucide-file-text class="w-5 h-5 text-rose-500 shrink-0" />
                                    <div class="min-w-0">
                                        <span class="font-bold text-zinc-900 block truncate">{{ $doc->title }}</span>
                                        <span class="text-label-xs text-zinc-400 mt-0.5 block">
                                            Uploaded by {{ $doc->uploader?->name ?? 'Task Force' }} · {{ $doc->created_at ? $doc->created_at->format('M d, Y') : 'Recent' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 shrink-0">
                                    <x-ui.status-badge :status="$doc->status" />

                                    <!-- Action Buttons -->
                                    @if($doc->status !== 'verified')
                                        <x-ui.button
                                            type="button"
                                            variant="primary"
                                            size="sm"
                                            wire:click="verifyDocument({{ $doc->id }})"
                                            class="bg-emerald-600 hover:bg-emerald-700"
                                        >
                                            <x-slot:icon>
                                                <x-lucide-check class="w-3.5 h-3.5 mr-1" />
                                            </x-slot:icon>
                                            Verify
                                        </x-ui.button>
                                    @endif

                                    <x-ui.button
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        wire:click="openFlagModal({{ $doc->id }})"
                                        class="hover:bg-rose-50 hover:text-rose-700 hover:border-rose-200 text-zinc-600"
                                    >
                                        <x-slot:icon>
                                            <x-lucide-flag class="w-3.5 h-3.5 mr-1 text-rose-500" />
                                        </x-slot:icon>
                                        Flag
                                    </x-ui.button>
                                </div>
                            </div>
                        @empty
                            <div class="p-3 bg-zinc-50 border border-dashed border-zinc-200 rounded-xl text-center text-label-xs text-zinc-400 font-medium">
                                No evidence files uploaded for this criterion yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="p-8 text-center bg-zinc-50 border border-zinc-200 rounded-2xl text-zinc-500 text-body-sm">
                    No criteria found in this section.
                </div>
            @endforelse
        </div>
    </div>
</div>
