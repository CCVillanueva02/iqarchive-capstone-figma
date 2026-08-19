<x-layouts::app :title="__('Audit Trail')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-heading-lg font-bold text-primary-dark">Audit Trail</h1>
                <p class="text-body-sm text-zinc-500 mt-1">Workspace: IQA Staff</p>
            </div>
        </div>

        <livewire:iqa-admin.audit-trail />
    </div>
</x-layouts::app>
