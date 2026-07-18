<x-layouts::app :title="__('Documents')">
    <div x-data="documentWorkspace()" class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen relative overflow-hidden">
        @include('pages.roles.iqa-admin.partials.header')

        @include('pages.roles.iqa-admin.partials.common-docs')

        @include('pages.roles.iqa-admin.partials.accreditation')

        @include('pages.roles.iqa-admin.partials.detail-drawer')
    </div>

    @vite('resources/js/iqa-documents.js')
</x-layouts::app>
