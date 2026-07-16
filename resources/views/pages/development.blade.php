<x-layouts::app :title="__('Under Development')">
    <div class="flex flex-col items-center justify-center text-center p-12 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-2xs min-h-[400px] gap-4">
        <div class="w-16 h-16 rounded-full bg-orange-50 dark:bg-orange-950/20 text-orange-500 flex items-center justify-center mb-2 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.67 2.67 0 1113.5 17.25l-5.83-5.83m5.83 5.83l-5.83-5.83m.001 0a2.67 2.67 0 11-3.75 3.75l5.83-5.83m-5.83 5.83L3 21M9 3H3v6M21 9h-6V3m6 6l-6-6" />
            </svg>
        </div>
        <flux:heading size="lg" class="font-extrabold text-zinc-900 dark:text-white">Page is under development</flux:heading>
        <flux:text class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm">
            This module is currently being built. A custom design will be implemented here based on your references.
        </flux:text>
        <flux:button href="{{ route('documents.index') }}" variant="primary" class="bg-orange-500 hover:bg-orange-600 border-none text-xs font-semibold mt-2">
            Back to Documents
        </flux:button>
    </div>
</x-layouts::app>
