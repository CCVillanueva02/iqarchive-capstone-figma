<x-layouts::html :title="$title ?? null" html-class="light" body-class="min-h-screen bg-slate-50 antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center p-6 md:p-10">
            {{ $slot }}
        </div>

</x-layouts::html>
