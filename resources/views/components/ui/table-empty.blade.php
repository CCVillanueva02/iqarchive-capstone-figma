@props([
    'colspan' => 10,
    'title' => 'No records found',
    'message' => 'There are no items matching your current filters or search criteria.',
    'icon' => null,
])

<tr>
    <td colspan="{{ $colspan }}" class="py-12 px-6 text-center">
        <div class="flex flex-col items-center justify-center max-w-sm mx-auto text-center">
            <div class="w-12 h-12 rounded-full bg-surface-subtle border border-zinc-200 flex items-center justify-center text-zinc-400 mb-3">
                @if($icon)
                    {{ $icon }}
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                @endif
            </div>
            <h4 class="text-body font-bold text-zinc-800">{{ $title }}</h4>
            <p class="text-body-sm text-zinc-500 mt-1">{{ $message }}</p>
        </div>
    </td>
</tr>
