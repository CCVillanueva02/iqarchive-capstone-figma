<div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-3xs space-y-6">
    <div class="border-b border-zinc-100 pb-4">
        <h3 class="text-sm font-bold text-zinc-900">Program Narrative Profile</h3>
        <p class="text-xs text-zinc-500 mt-0.5">Overview of {{ $selectedProgram?->name ?? 'the selected academic program' }}</p>
    </div>

    @if($selectedProgram)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Academic Information -->
            <div class="space-y-4 bg-zinc-50 p-4 rounded-xl border border-zinc-200">
                <h4 class="text-xs font-bold text-zinc-900 uppercase tracking-wider">Academic Details</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-zinc-200/60">
                        <span class="text-zinc-500">Program Name:</span>
                        <span class="font-semibold text-zinc-800">{{ $selectedProgram->name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-zinc-200/60">
                        <span class="text-zinc-500">College:</span>
                        <span class="font-semibold text-zinc-800">{{ $selectedProgram->college?->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-zinc-200/60">
                        <span class="text-zinc-500">Program Code:</span>
                        <span class="font-semibold text-zinc-800">{{ $selectedProgram->code ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Accreditation Status -->
            @php
                $latestAccred = $selectedProgram->accreditations()->latest()->first();
            @endphp
            <div class="space-y-4 bg-zinc-50 p-4 rounded-xl border border-zinc-200">
                <h4 class="text-xs font-bold text-zinc-900 uppercase tracking-wider">Accreditation Cycle</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-zinc-200/60">
                        <span class="text-zinc-500">Status:</span>
                        <span class="font-semibold text-primary">{{ $latestAccred?->status ?? 'Not in cycle' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-zinc-200/60">
                        <span class="text-zinc-500">Current Level:</span>
                        <span class="font-semibold text-zinc-800">{{ $latestAccred?->level ?? 'Level I Candidate' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-zinc-200/60">
                        <span class="text-zinc-500">Scheduled Visit:</span>
                        <span class="font-semibold text-zinc-800">{{ $latestAccred?->visit_date?->format('M d, Y') ?? 'TBA' }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($selectedProgram->description)
            <div class="bg-zinc-50 p-4 rounded-xl border border-zinc-200 space-y-2">
                <h4 class="text-xs font-bold text-zinc-900 uppercase tracking-wider">Program Description & VMGO Alignment</h4>
                <p class="text-xs text-zinc-700 leading-relaxed">{{ $selectedProgram->description }}</p>
            </div>
        @endif
    @else
        <p class="text-xs text-zinc-400 py-6 text-center">Please select an academic program to view its narrative profile.</p>
    @endif
</div>
