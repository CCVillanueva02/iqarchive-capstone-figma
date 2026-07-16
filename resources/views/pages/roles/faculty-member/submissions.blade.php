<x-layouts::app :title="__('Submissions')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#1b355a]">Submissions</h1>
                <p class="text-xs text-zinc-500 mt-1">Workspace: BU Faculty Member</p>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center text-center p-12 bg-white border border-slate-200/60 rounded-2xl shadow-3xs min-h-[400px] gap-4">
            <div class="w-16 h-16 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center mb-2 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <flux:heading size="lg" class="font-extrabold text-zinc-900">Welcome, {{ auth()->user()->name }}!</flux:heading>
            <flux:text class="text-sm text-zinc-500 max-w-md">
                You have accessed the <strong>Submissions</strong> workspace for the <strong>BU Faculty Member</strong>. This page is currently under development.
            </flux:text>
        </div>
    </div>
</x-layouts::app>