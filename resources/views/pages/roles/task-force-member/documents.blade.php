<x-layouts::app :title="__('Documents')">
    <div x-data="documentWorkspace()" class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen relative overflow-hidden">
        @include('pages.roles.task-force.partials.header')

        @include('pages.roles.task-force.partials.common-docs')

        @include('pages.roles.task-force.partials.accreditation')

        @include('pages.roles.task-force.partials.detail-drawer')
    </div>
</x-layouts::app>
