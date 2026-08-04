<x-layouts::app :title="__('Documents')">
    <div x-data="documentWorkspace()" class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen relative overflow-hidden">
        @include('pages.roles.system-administrator.partials.header')

        @include('pages.roles.system-administrator.partials.common-docs')

        @include('pages.roles.system-administrator.partials.accreditation')

        @include('pages.roles.system-administrator.partials.detail-drawer')
    </div>
</x-layouts::app>