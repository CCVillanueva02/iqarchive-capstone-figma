<!-- Recent Feedback & Quick Guides -->
<div class="flex flex-col gap-6 w-full">
    <!-- Recent Dean Reviews / Activity Feed -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h2 class="text-heading-sm font-extrabold text-primary">Dean Feedback Feed</h2>
            <span class="text-label-xs font-bold text-zinc-400">Latest Updates</span>
        </div>

        <div class="flex flex-col gap-3">
            @forelse($recentReviews as $review)
                <div class="p-3.5 rounded-xl border border-slate-200/70 bg-slate-50/40 flex flex-col gap-1.5 shadow-3xs">
                    <div class="flex items-center justify-between">
                        @if($review->decision === 'verified')
                            <span class="px-2 py-0.5 rounded-full text-label-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                                <x-lucide-check-circle-2 class="w-3 h-3 text-emerald-600" />
                                <span>Verified</span>
                            </span>
                        @elseif($review->decision === 'needs_revision')
                            <span class="px-2 py-0.5 rounded-full text-label-xs font-bold bg-rose-100 text-rose-800 border border-rose-200 flex items-center gap-1">
                                <x-lucide-alert-circle class="w-3 h-3 text-rose-600" />
                                <span>Needs Revision</span>
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-label-xs font-bold bg-slate-100 text-zinc-700">
                                {{ ucfirst($review->decision) }}
                            </span>
                        @endif
                        <span class="text-label-xs text-zinc-400">
                            {{ $review->reviewed_at ? $review->reviewed_at->diffForHumans() : 'Recently' }}
                        </span>
                    </div>

                    <span class="text-body-sm font-bold text-primary truncate block mt-0.5">
                        {{ $review->document?->title ?? 'Evidence File' }}
                    </span>

                    @if($review->remarks)
                        <p class="text-xs text-zinc-600 italic bg-white p-2 rounded-lg border border-slate-100 leading-relaxed">
                            "{{ $review->remarks }}"
                        </p>
                    @endif
                </div>
            @empty
                <div class="p-6 text-center text-zinc-400 text-body-sm italic bg-slate-50 rounded-xl">
                    No Dean reviews recorded yet.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick QA Accreditation Resources Card -->
    <div class="bg-linear-to-br from-primary-dark to-primary rounded-2xl p-6 text-white shadow-3xs flex flex-col gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                <x-lucide-book-open class="w-5 h-5 text-brand-orange" />
            </div>
            <div>
                <h3 class="text-heading-sm font-extrabold text-white">Accreditation Guidelines</h3>
                <p class="text-label text-white/70">AACCUP Level Standards &amp; QA Checklists</p>
            </div>
        </div>

        <p class="text-xs text-white/80 leading-relaxed">
            Ensure all uploaded files are official PDF documents containing required Board Resolutions, syllabi signatures, or departmental endorsements.
        </p>

        <div class="pt-2 border-t border-white/10 flex flex-col gap-2">
            <a href="{{ route('documents.task-force-member') }}" 
                class="w-full py-2.5 px-4 rounded-xl bg-brand-orange hover:bg-brand-orange-hover text-white text-center text-body-sm font-bold shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                <x-lucide-upload class="w-4 h-4" />
                <span>Go to Document Workspace</span>
            </a>
        </div>
    </div>
</div>
