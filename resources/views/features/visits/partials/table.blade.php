<x-ui.table
    :headers="['College & Program', 'Initiated Date', 'Target Visit Date', 'Current Stage', 'Timeline & Actions']"
    :pagination="$accreditations->hasPages() ? $accreditations->links() : null"
>
    @forelse($accreditations as $acc)
        @php
            $isCancelled = $acc->status === 'cancelled';
        @endphp
        <tr
            wire:click="openTimeline({{ $acc->id }})"
            class="hover:bg-zinc-50/80 transition-colors cursor-pointer group {{ $isCancelled ? 'bg-zinc-50/50 opacity-75' : '' }}"
        >
            {{-- College & Program --}}
            <td class="px-6 py-4.5">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-label-xs font-bold {{ $isCancelled ? 'bg-zinc-200 text-zinc-600' : 'bg-primary/10 text-primary border border-primary/15' }} shrink-0">
                        @if($acc->program->college && $acc->program->college->logo)
                            <img src="{{ $acc->program->college->logo }}" alt="Logo" class="w-4 h-4 object-contain shrink-0" onerror="this.style.display='none'">
                        @endif
                        {{ $acc->program->college->code ?? 'N/A' }}
                    </span>
                    <div class="flex flex-col">
                        <span class="font-bold {{ $isCancelled ? 'text-zinc-500 line-through' : 'text-primary-dark group-hover:text-brand-orange' }} transition-colors">
                            {{ $acc->program->name ?? 'N/A' }}
                        </span>
                        <span class="text-label-xs text-zinc-400 font-mono">
                            {{ $acc->program->code ?? '' }} &bull; {{ $acc->program->accreditation_level ?? 'Level Not Set' }}
                        </span>
                    </div>
                </div>
            </td>

            {{-- Initiated Date --}}
            <td class="px-6 py-4.5">
                <div class="flex flex-col">
                    <span class="font-semibold text-zinc-800 flex items-center gap-1.5 text-body-sm">
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $acc->created_at ? $acc->created_at->format('M d, Y') : 'N/A' }}
                    </span>
                    <span class="text-label-xs text-zinc-400">
                        {{ $acc->created_at ? $acc->created_at->diffForHumans() : '' }} &bull; {{ $acc->creator->name ?? 'IQA Staff' }}
                    </span>
                </div>
            </td>

            {{-- Target Visit Date --}}
            <td class="px-6 py-4.5">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg {{ $isCancelled ? 'bg-zinc-100 text-zinc-400' : 'bg-amber-50 text-amber-600 border border-amber-200/60' }} flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold {{ $isCancelled ? 'text-zinc-400 line-through' : 'text-zinc-900' }} text-body-sm">
                            {{ $acc->target_date ? \Carbon\Carbon::parse($acc->target_date)->format('M d, Y') : 'Date Pending' }}
                        </span>
                        @if($acc->target_date && !$isCancelled)
                            @php
                                $diff = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($acc->target_date), false);
                            @endphp
                            <span class="text-label-xs font-semibold {{ $diff < 0 ? 'text-rose-600 font-bold' : ($diff <= 30 ? 'text-amber-600' : 'text-emerald-600') }}">
                                {{ $diff < 0 ? abs($diff) . ' days ago' : ($diff === 0 ? 'Today!' : 'in ' . $diff . ' days') }}
                            </span>
                        @endif
                    </div>
                </div>
            </td>

            {{-- Current Stage --}}
            <td class="px-6 py-4.5">
                <x-ui.status-badge :status="$acc->status" />
            </td>

            {{-- Actions --}}
            <td class="px-6 py-4.5">
                <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                    <x-ui.button
                        variant="subtle"
                        size="sm"
                        wire:click="openTimeline({{ $acc->id }})"
                    >
                        Timeline View
                    </x-ui.button>

                    @if(in_array(auth()->user()->role ?? '', ['iqa-staff', 'iqa-admin', 'system-administrator']) && !$isCancelled && !in_array($acc->status, ['submitted', 'completed']))
                        <x-ui.button
                            variant="outline"
                            size="sm"
                            onclick="confirmCancel({{ $acc->id }}, '{{ addslashes($acc->program->name ?? 'this program') }}')"
                            class="text-rose-600 hover:bg-rose-50 border-rose-200"
                        >
                            Cancel
                        </x-ui.button>
                    @endif
                </div>
            </td>
        </tr>
    @empty
        <x-ui.table-empty
            :colspan="5"
            title="No accreditation visits found"
            message="No accreditation visit records match your current search query or stage filter."
        />
    @endforelse
</x-ui.table>
