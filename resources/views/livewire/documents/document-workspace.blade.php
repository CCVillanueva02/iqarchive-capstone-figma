<div class="min-h-screen bg-zinc-50 flex flex-col">
    <!-- Status / Notification Alert Banner -->
    @if(session()->has('status'))
        <div class="bg-emerald-600 text-white px-6 py-2.5 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
            <button type="button" @click="$el.closest('div').remove()" class="text-white/80 hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    <!-- Workspace Header & Top Navigation -->
    @include('livewire.documents.partials.header')

    <!-- Active Tab Workspace Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto">
        @if($activeTab === 'common-documents' && $canAccessCommonDocs)
            @include('livewire.documents.partials.common-documents')
        @elseif($activeTab === 'program-accreditation')
            @include('livewire.documents.partials.program-accreditation')
        @elseif($activeTab === 'institutional-accreditation' && $canAccessInstitutionalDocs)
            @include('livewire.documents.partials.institutional-accreditation')
        @endif
    </main>

    <!-- Modals & Slide-Over Drawers -->
    @include('livewire.documents.partials.modals.upload-common-modal')
    @include('livewire.documents.partials.modals.upload-evidence-modal')
    @include('livewire.documents.partials.modals.detail-drawer')
</div>
