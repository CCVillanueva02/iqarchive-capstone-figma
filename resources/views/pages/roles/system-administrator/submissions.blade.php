<x-layouts::app :title="__('Submissions')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#1b355a]">Submissions</h1>
                <p class="text-xs text-zinc-500 mt-1">Workspace: System Administrator</p>
            </div>
        </div>

        @include('pages.roles.shared.partials.submissions-dashboard')
    </div>

    @vite('resources/js/iqa-submissions.js')
</x-layouts::app>
