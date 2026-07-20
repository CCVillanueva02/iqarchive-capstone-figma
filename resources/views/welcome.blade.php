<x-layouts::html :title="'Bicol University IQA Office'" html-class="light" body-class="bg-[#FDFDFC] antialiased text-zinc-800 font-sans min-h-screen flex flex-col justify-between">
        @include('partials.header')

        <!-- Hero Section -->
        <main class="flex-1 flex flex-col items-center justify-center max-w-5xl mx-auto px-6 py-12 text-center gap-8 min-h-[80vh]">
            <div class="flex flex-col items-center gap-4">
                <flux:badge color="orange" size="sm" class="font-bold uppercase tracking-wider px-3 py-1">BICOL UNIVERSITY</flux:badge>
                
                <h1 class="text-4xl md:text-6xl font-extrabold text-[#1b355a] tracking-tight max-w-4xl leading-tight">
                    Document Management & Monitoring System
                </h1>
                
                <p class="text-base md:text-lg text-zinc-500 max-w-2xl leading-relaxed mt-2">
                    A centralized, secure repository maintained by the Internal Quality Assurance Office to safeguard Bicol University's accreditation documentation and compliance records for years to come.
                </p>

                <!-- Orange Divider -->
                <div class="w-24 h-[4px] bg-[#f27224] mt-4 rounded-full"></div>
            </div>

            <!-- Call to Actions -->
            <div class="flex flex-col sm:flex-row gap-4 mt-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-[#f27224] hover:bg-[#d65f1a] text-white font-bold rounded-xl transition shadow-md text-sm">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-[#f27224] hover:bg-[#d65f1a] text-white font-bold rounded-xl transition shadow-md text-sm">
                        Access IQArchive Login
                    </a>
                @endauth
            </div>

        </main>

        @include('partials.footer')
</x-layouts::html>
