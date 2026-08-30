<!-- Core Accreditation Instruments & Document Repositories Matrix -->
<div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs flex flex-col gap-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div>
            <h2 class="text-heading-sm font-extrabold text-primary">Accreditation Instruments &amp; Repositories</h2>
            <p class="text-body-sm text-zinc-500 mt-0.5">Primary documentation pillars for program accreditation compliance.</p>
        </div>
        @if($this->isInstrumentVerified)
            <a href="{{ route('documents.task-force-member', ['tab' => 'program-accreditation']) }}" 
                class="text-body-sm font-bold text-primary hover:text-primary-hover transition flex items-center gap-1 shrink-0">
                <span>Open All Repositories</span>
                <x-lucide-arrow-right class="w-4 h-4" />
            </a>
        @else
            <span class="text-label-xs font-bold text-amber-800 bg-amber-100 px-3 py-1.5 rounded-xl flex items-center gap-1.5 shrink-0">
                <x-lucide-lock class="w-3.5 h-3.5 text-amber-700" />
                <span>Locked · Awaiting Dean Setup</span>
            </span>
        @endif
    </div>

    <!-- 5 Core Instruments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <!-- 1. Supporting Documents (Area I to X) -->
        <div class="md:col-span-2 border border-slate-200/80 rounded-2xl p-5 flex flex-col justify-between hover:border-primary-light hover:shadow-xs transition bg-surface-subtle/20 gap-4 {{ !$this->isInstrumentVerified ? 'opacity-70 bg-slate-50/60' : '' }}">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <div class="flex items-start gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                        <x-lucide-files class="w-6 h-6 text-primary" />
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-body font-extrabold text-primary">Supporting Documents (Area I – X)</h3>
                            <span class="px-2 py-0.5 rounded-full text-label-xs font-bold bg-surface-subtle text-primary-dark border border-primary/15 uppercase">
                                Primary Evidence
                            </span>
                        </div>
                        <p class="text-body-sm text-zinc-600 mt-1 leading-relaxed">
                            Checklist criteria link inputs for Systems (Inputs &amp; Processes), Implementation, Outcomes, and Best Practices across all 10 evaluation areas.
                        </p>
                    </div>
                </div>
                <span class="text-body-sm font-extrabold text-primary shrink-0">
                    {{ $stats['verifiedDocs'] }} / {{ $stats['totalDocs'] }} Verified
                </span>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-3 gap-3 pt-2 border-t border-primary/10">
                <div class="p-2.5 bg-white rounded-xl border border-slate-200/70 text-center">
                    <span class="text-label-xs text-zinc-400 font-bold uppercase block">Total Attached</span>
                    <span class="text-body font-black text-primary">{{ $stats['totalDocs'] }} Files</span>
                </div>
                <div class="p-2.5 bg-white rounded-xl border border-slate-200/70 text-center">
                    <span class="text-label-xs text-zinc-400 font-bold uppercase block">Dean Verified</span>
                    <span class="text-body font-black text-emerald-600">{{ $stats['verifiedDocs'] }}</span>
                </div>
                <div class="p-2.5 bg-white rounded-xl border border-slate-200/70 text-center">
                    <span class="text-label-xs text-zinc-400 font-bold uppercase block">Needs Revision</span>
                    <span class="text-body font-black {{ $stats['flaggedDocs'] > 0 ? 'text-rose-600' : 'text-zinc-700' }}">{{ $stats['flaggedDocs'] }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center gap-2 text-label-xs text-zinc-500 font-bold">
                    <span>Readiness:</span>
                    <span class="text-primary font-black">{{ $stats['readinessPct'] }}%</span>
                </div>
                @if($this->isInstrumentVerified)
                    <a href="{{ route('documents.task-force-member', ['tab' => 'program-accreditation', 'category' => 'Supporting Documents']) }}" 
                        class="px-4 py-2 bg-primary hover:bg-primary-hover text-white text-body-sm font-bold rounded-xl shadow-3xs transition flex items-center gap-2 cursor-pointer">
                        <x-lucide-folder-up class="w-4 h-4" />
                        <span>Open Supporting Documents</span>
                    </a>
                @else
                    <button type="button" disabled class="px-4 py-2 bg-slate-200 text-slate-500 text-body-sm font-bold rounded-xl cursor-not-allowed flex items-center gap-2">
                        <x-lucide-lock class="w-4 h-4" />
                        <span>Locked (Pending Dean Setup)</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- 2. Self-Survey Matrix & Instrument -->
        <div class="border border-slate-200/80 rounded-2xl p-5 flex flex-col justify-between hover:border-amber-300 hover:shadow-xs transition bg-amber-50/20 gap-4 {{ !$this->isInstrumentVerified ? 'opacity-70 bg-slate-50/60' : '' }}">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <x-lucide-clipboard-check class="w-5 h-5 text-amber-700" />
                </div>
                <div>
                    <h3 class="text-body font-extrabold text-primary">Self-Survey Documents</h3>
                    <p class="text-xs text-zinc-600 mt-1 leading-relaxed">
                        Internal QA self-evaluation spreadsheets, numerical rating guides (1.0 to 5.0), and diagnostic compliance scoring.
                    </p>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-label-xs font-bold text-amber-800 bg-amber-100/80 px-2.5 py-1 rounded-lg">
                    Rating Matrix
                </span>
                @if($this->isInstrumentVerified)
                    <a href="{{ route('documents.task-force-member', ['tab' => 'program-accreditation', 'category' => 'Self-Survey Documents']) }}" 
                        class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-lg shadow-3xs transition flex items-center gap-1.5 cursor-pointer">
                        <span>Open Self-Survey</span>
                        <x-lucide-arrow-right class="w-3.5 h-3.5" />
                    </a>
                @else
                    <button type="button" disabled class="px-3.5 py-1.5 bg-slate-200 text-slate-500 text-xs font-bold rounded-lg cursor-not-allowed flex items-center gap-1.5">
                        <x-lucide-lock class="w-3.5 h-3.5" />
                        <span>Locked</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- 3. Compliance Reports -->
        <div class="border border-slate-200/80 rounded-2xl p-5 flex flex-col justify-between hover:border-emerald-300 hover:shadow-xs transition bg-emerald-50/20 gap-4 {{ !$this->isInstrumentVerified ? 'opacity-70 bg-slate-50/60' : '' }}">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <x-lucide-file-badge class="w-5 h-5 text-emerald-700" />
                </div>
                <div>
                    <h3 class="text-body font-extrabold text-primary">Compliance Reports</h3>
                    <p class="text-xs text-zinc-600 mt-1 leading-relaxed">
                        Official compliance logs, previous AACCUP recommendations, corrective action plans, and accreditation certificates.
                    </p>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-label-xs font-bold text-emerald-800 bg-emerald-100/80 px-2.5 py-1 rounded-lg">
                    Compliance Repository
                </span>
                @if($this->isInstrumentVerified)
                    <a href="{{ route('documents.task-force-member', ['tab' => 'program-accreditation', 'category' => 'Compliance Reports']) }}" 
                        class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-3xs transition flex items-center gap-1.5 cursor-pointer">
                        <span>Open Reports</span>
                        <x-lucide-arrow-right class="w-3.5 h-3.5" />
                    </a>
                @else
                    <button type="button" disabled class="px-3.5 py-1.5 bg-slate-200 text-slate-500 text-xs font-bold rounded-lg cursor-not-allowed flex items-center gap-1.5">
                        <x-lucide-lock class="w-3.5 h-3.5" />
                        <span>Locked</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- 4. Program Performance Portfolio (PPP) -->
        <div class="border border-slate-200/80 rounded-2xl p-5 flex flex-col justify-between hover:border-teal-300 hover:shadow-xs transition bg-teal-50/20 gap-4 {{ !$this->isInstrumentVerified ? 'opacity-70 bg-slate-50/60' : '' }}">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center shrink-0">
                    <x-lucide-layout-panel-top class="w-5 h-5 text-teal-700" />
                </div>
                <div>
                    <h3 class="text-body font-extrabold text-primary">Program Performance Profile</h3>
                    <p class="text-xs text-zinc-600 mt-1 leading-relaxed">
                        Executive statistical profile, student enrollment, graduation ratios, licensure examination performance, and faculty data.
                    </p>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-label-xs font-bold text-teal-800 bg-teal-100/80 px-2.5 py-1 rounded-lg">
                    Executive Profile
                </span>
                @if($this->isInstrumentVerified)
                    <a href="{{ route('documents.task-force-member', ['tab' => 'program-accreditation', 'category' => 'PPP']) }}" 
                        class="px-3.5 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-lg shadow-3xs transition flex items-center gap-1.5 cursor-pointer">
                        <span>Open PPP</span>
                        <x-lucide-arrow-right class="w-3.5 h-3.5" />
                    </a>
                @else
                    <button type="button" disabled class="px-3.5 py-1.5 bg-slate-200 text-slate-500 text-xs font-bold rounded-lg cursor-not-allowed flex items-center gap-1.5">
                        <x-lucide-lock class="w-3.5 h-3.5" />
                        <span>Locked</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- 5. Narrative Profile -->
        <div class="border border-slate-200/80 rounded-2xl p-5 flex flex-col justify-between hover:border-purple-300 hover:shadow-xs transition bg-purple-50/20 gap-4 {{ !$this->isInstrumentVerified ? 'opacity-70 bg-slate-50/60' : '' }}">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                    <x-lucide-notebook-pen class="w-5 h-5 text-purple-700" />
                </div>
                <div>
                    <h3 class="text-body font-extrabold text-primary">Narrative Profile</h3>
                    <p class="text-xs text-zinc-600 mt-1 leading-relaxed">
                        Qualitative area-by-area narrative documentation, institutional context, and descriptive performance justifications.
                    </p>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-label-xs font-bold text-purple-800 bg-purple-100/80 px-2.5 py-1 rounded-lg">
                    In-App Narrative
                </span>
                @if($this->isInstrumentVerified)
                    <a href="{{ route('documents.task-force-member', ['tab' => 'program-accreditation', 'category' => 'Narrative Profile']) }}" 
                        class="px-3.5 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-lg shadow-3xs transition flex items-center gap-1.5 cursor-pointer">
                        <span>Open Narrative</span>
                        <x-lucide-arrow-right class="w-3.5 h-3.5" />
                    </a>
                @else
                    <button type="button" disabled class="px-3.5 py-1.5 bg-slate-200 text-slate-500 text-xs font-bold rounded-lg cursor-not-allowed flex items-center gap-1.5">
                        <x-lucide-lock class="w-3.5 h-3.5" />
                        <span>Locked</span>
                    </button>
                @endif
            </div>
        </div>

    </div>
</div>
