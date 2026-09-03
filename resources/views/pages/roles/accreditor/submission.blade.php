<x-layouts::app :title="__('Submission Evaluation')">
    <div class="w-full flex flex-col bg-surface-subtle min-h-screen relative overflow-hidden font-sans">
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-6">
            <!-- Reviewer Session Information & Logout -->
            <div class="flex justify-between items-center border-b border-slate-200/60 pb-4 mb-2 select-none">
                <div class="flex items-center gap-2.5">
                    <img src="/bulogo.png" alt="BU Logo" class="w-8 h-8 object-contain shrink-0" />
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-primary-dark leading-none">BU IQArchive</span>
                        <span class="text-label-xs text-zinc-500 font-bold uppercase tracking-wider mt-1">Accreditation Audit Workspace</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold text-zinc-500">Reviewer: <strong class="text-primary-dark">{{ auth()->user()->name }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 bg-zinc-200 hover:bg-zinc-300 text-zinc-700 text-label font-bold rounded-lg transition cursor-pointer">
                            Log out
                        </button>
                    </form>
                </div>
            </div>

            <!-- Server-driven Program Accreditation Workspace -->
            <livewire:documents.document-workspace />
        </div>
    </div>
</x-layouts::app>
