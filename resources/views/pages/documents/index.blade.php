<x-layouts::app :title="__('Documents')">
    @php
        $userRole = auth()->user()->role;
        $canSeeCommonDocs = in_array($userRole, ['iqa-admin', 'iqa-member', 'task-force', 'task-force-member']) || auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('iqa-member') || auth()->user()->hasRole('task-force');
        $defaultTab = $canSeeCommonDocs ? 'common-documents' : 'program-accreditation';
        $activeTab = request()->query('tab', $defaultTab);
        if (!$canSeeCommonDocs && $activeTab === 'common-documents') {
            $activeTab = 'program-accreditation';
        }
    @endphp
    <div x-data="documentWorkspace({ 
        userId: {{ auth()->id() }}, 
        userRole: '{{ auth()->user()->role }}', 
        activeTab: '{{ $activeTab }}' 
    })" class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen relative overflow-hidden">
        @include('pages.documents.partials.header')

        @if ($canSeeCommonDocs)
        @include('pages.documents.partials.common-documents')
        @endif

        @include('pages.documents.partials.program-accreditation')

        @include('pages.documents.partials.institutional-accreditation')

        @include('pages.documents.partials.detail-drawer')
    </div>
</x-layouts::app>
