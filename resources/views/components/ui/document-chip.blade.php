@props([
    'title' => 'Document',
    'size' => null,
    'type' => 'PDF',
    'date' => null,
    'uploader' => null,
    'status' => null,
    'downloadUrl' => null,
    'viewUrl' => null,
])

@php
    $typeNormalized = strtoupper(trim((string) $type));
    $typeBadgeColor = match($typeNormalized) {
        'PDF' => 'bg-rose-50 text-rose-700 border-rose-200',
        'DOC', 'DOCX' => 'bg-primary/10 text-primary border-primary/20',
        'XLS', 'XLSX' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        default => 'bg-zinc-100 text-zinc-700 border-zinc-200',
    };
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-between p-3.5 bg-white rounded-xl border border-zinc-200/80 shadow-3xs hover:border-zinc-300 transition gap-4']) }}>
    <div class="flex items-center gap-3 min-w-0">
        <span class="px-2 py-1 rounded-md text-label-xs font-black border {{ $typeBadgeColor }} shrink-0">
            {{ $typeNormalized }}
        </span>

        <div class="min-w-0">
            <h5 class="text-body-sm font-bold text-zinc-900 truncate" title="{{ $title }}">{{ $title }}</h5>
            <div class="flex items-center gap-2 text-label-xs text-zinc-400 mt-0.5">
                @if($size)
                    <span>{{ $size }}</span>
                @endif
                @if($size && $date)
                    <span>•</span>
                @endif
                @if($date)
                    <span>{{ $date }}</span>
                @endif
                @if($uploader)
                    <span>• by <span class="text-zinc-600 font-medium">{{ $uploader }}</span></span>
                @endif
            </div>
        </div>
    </div>

    <div class="flex items-center gap-2 shrink-0">
        @if($status)
            <x-ui.status-badge :status="$status" />
        @endif

        @if($viewUrl)
            <a href="{{ $viewUrl }}" target="_blank" class="p-1.5 text-zinc-500 hover:text-primary hover:bg-zinc-100 rounded-lg transition" title="Preview">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </a>
        @endif

        @if($downloadUrl)
            <a href="{{ $downloadUrl }}" class="p-1.5 text-zinc-500 hover:text-primary hover:bg-zinc-100 rounded-lg transition" title="Download">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
            </a>
        @endif

        {{ $slot }}
    </div>
</div>
