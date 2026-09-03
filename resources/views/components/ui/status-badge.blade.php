@props([
    'status' => 'pending',
    'label' => null,
])

@php
    $normalized = strtolower(trim((string) $status));

    $config = match($normalized) {
        'scheduled' => [
            'class' => 'bg-primary/10 text-primary border-primary/20',
            'dot' => 'bg-primary',
            'defaultLabel' => 'Scheduled',
        ],
        'in_progress', 'active', 'under_review' => [
            'class' => 'bg-sky-50 text-sky-700 border-sky-200',
            'dot' => 'bg-sky-500',
            'defaultLabel' => 'In Progress',
        ],
        'pending', 'submitted', 'pending_activation' => [
            'class' => 'bg-amber-50 text-amber-800 border-amber-200',
            'dot' => 'bg-amber-500',
            'defaultLabel' => 'Pending Review',
        ],
        'verified', 'approved', 'completed' => [
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'dot' => 'bg-emerald-500',
            'defaultLabel' => 'Verified',
        ],
        'needs_revision', 'revisions_requested' => [
            'class' => 'bg-brand-orange/10 text-brand-orange border-brand-orange/20',
            'dot' => 'bg-brand-orange',
            'defaultLabel' => 'Needs Revision',
        ],
        'rejected', 'cancelled', 'inactive', 'disbanded' => [
            'class' => 'bg-rose-50 text-rose-700 border-rose-200',
            'dot' => 'bg-rose-500',
            'defaultLabel' => 'Inactive',
        ],
        default => [
            'class' => 'bg-zinc-100 text-zinc-700 border-zinc-200',
            'dot' => 'bg-zinc-400',
            'defaultLabel' => ucwords(str_replace('_', ' ', $normalized)),
        ],
    };

    $displayLabel = $label ?? $config['defaultLabel'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-label font-bold border {$config['class']}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }} shrink-0"></span>
    <span class="truncate">{{ $displayLabel }}</span>
</span>
