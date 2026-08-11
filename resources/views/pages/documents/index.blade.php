<x-layouts::app :title="__('Documents')">
    <div x-data="documentWorkspace({ 
        userId: {{ auth()->id() }}, 
        userRole: '{{ auth()->user()->role }}', 
        activeTab: '{{ request()->query('tab', 'common-documents') }}' 
    })" class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen relative overflow-hidden">
        @include('pages.documents.partials.header')

        @include('pages.documents.partials.common-documents')

        @include('pages.documents.partials.program-accreditation')

        @include('pages.documents.partials.institutional-accreditation')

        @include('pages.documents.partials.detail-drawer')
    </div>
</x-layouts::app>
