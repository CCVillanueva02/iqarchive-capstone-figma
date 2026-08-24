<!-- Dean Feedback / Revisions Required Banner -->
@if($flaggedDocs->isNotEmpty() || $acc->status === 'document_preparation')
    @php
        $latestFlag = $recentReviews->where('decision', 'needs_revision')->first();
    @endphp

    @if($flaggedDocs->isNotEmpty())
        <div class="bg-gradient-to-r from-amber-500/10 via-amber-50/80 to-white border-l-4 border-amber-500 rounded-2xl p-5 shadow-3xs flex flex-col md:flex-row md:items-center justify-between gap-4 border border-amber-200/60">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                    <x-lucide-alert-triangle class="w-5 h-5 text-amber-700" />
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <h2 class="text-body font-extrabold text-amber-950">
                            Action Required: {{ $flaggedDocs->count() }} Evidence File{{ $flaggedDocs->count() > 1 ? 's' : '' }} Need Revision
                        </h2>
                        <span class="px-2 py-0.5 rounded text-label-xs font-bold bg-amber-200 text-amber-900 uppercase">
                            Dean Feedback
                        </span>
                    </div>
                    @if($latestFlag && $latestFlag->remarks)
                        <p class="text-body-sm text-amber-900 leading-relaxed font-medium">
                            <span class="font-bold">Latest Dean Note:</span> "{{ $latestFlag->remarks }}"
                        </p>
                    @else
                        <p class="text-body-sm text-amber-800 leading-relaxed">
                            The College Dean has flagged evidence items that require updated versions, official signatures, or proper documentation.
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('documents.task-force-member') }}" 
                    class="px-4 py-2 rounded-xl text-body-sm font-bold bg-amber-600 hover:bg-amber-700 text-white shadow-3xs transition cursor-pointer flex items-center gap-1.5 whitespace-nowrap">
                    <x-lucide-file-edit class="w-4 h-4" />
                    <span>Resolve Flagged Items</span>
                </a>
            </div>
        </div>
    @elseif($acc->status === 'dean_verification')
        <div class="bg-purple-50/80 border border-purple-200 rounded-2xl p-4 shadow-3xs flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                <x-lucide-shield-check class="w-4 h-4" />
            </div>
            <div class="text-body-sm text-purple-900">
                <strong>Repository Under Dean Review:</strong> Evidence has been submitted for Stage 6 Dean Verification. New uploads are paused during review.
            </div>
        </div>
    @endif
@endif
