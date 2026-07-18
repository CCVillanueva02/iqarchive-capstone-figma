<x-layouts::html :title="'Bicol University IQA Office'" html-class="light" body-class="bg-[#FDFDFC] antialiased text-zinc-800 font-sans min-h-screen flex flex-col justify-between">
        <!-- Top Navbar -->
        <header class="w-full max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 border border-slate-200 text-[#586A85]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V8.25M15.75 21V8.25M8.25 21V8.25M3 9L12 3L21 9M19.5 21V12M4.5 21V12M2.25 21h19.5" />
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-lg text-[#1b355a] tracking-tight">IQArchive</span>
                    <span class="block text-[10px] text-zinc-400 font-medium uppercase tracking-wider -mt-1">IQA Office</span>
                </div>
            </div>

            <nav class="flex items-center gap-4">
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg bg-[#f27224] text-white hover:bg-[#d65f1a] transition shadow-2xs"
                    >
                        Go to Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center px-4 py-2 border border-zinc-200 text-sm font-semibold rounded-lg text-[#1b355a] hover:bg-slate-50 transition"
                    >
                        Log In
                    </a>
                @endauth
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="flex-1 flex flex-col items-center justify-center max-w-5xl mx-auto px-6 py-12 text-center gap-8">
            <div class="flex flex-col items-center gap-4">
                <flux:badge color="orange" size="sm" class="font-bold uppercase tracking-wider px-3 py-1">BICOL UNIVERSITY</flux:badge>
                
                <h1 class="text-4xl md:text-6xl font-extrabold text-[#1b355a] tracking-tight max-w-4xl leading-tight">
                    Document Management & Monitoring System
                </h1>
                
                <p class="text-base md:text-lg text-zinc-500 max-w-2xl leading-relaxed mt-2">
                    A secure and smart archiving hub for the Internal Quality Assurance Office. Powered by automatic Tesseract OCR text extraction and role-based accreditation monitoring.
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

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full mt-12 text-left">
                <!-- Feature 1 -->
                <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-2xs hover:shadow-xs transition duration-200">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-[#1b355a] mb-2">OCR Searchable Files</h3>
                    <p class="text-xs text-zinc-500 leading-relaxed">Scanned files are processed automatically through Tesseract OCR, enabling full-text keyword searches across the entire archive.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-2xs hover:shadow-xs transition duration-200">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-[#1b355a] mb-2">Compliance Checklists</h3>
                    <p class="text-xs text-zinc-500 leading-relaxed">Dynamic instrument tracking guides faculty program chairs and task forces to submit all required files for accreditation schedules.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-2xs hover:shadow-xs transition duration-200">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 12.408l1.5 1.5 3-3m-9.75-3l1.5 1.5 3-3M3.75 6H7.5m-.75 3h3.75M3 21h18M3 3h18" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-[#1b355a] mb-2">Full Security & Auditing</h3>
                    <p class="text-xs text-zinc-500 leading-relaxed">Every account creation, login event, document upload, and review decision is cryptographically tracked in the non-repudiation logs.</p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full max-w-7xl mx-auto px-6 py-6 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between text-xs text-zinc-400 gap-4 mt-12">
            <div>
                &copy; {{ date('Y') }} Bicol University — Internal Quality Assurance Office
            </div>
            <div class="flex gap-4">
                <span class="hover:underline cursor-pointer">Security Protocol</span>
                <span class="hover:underline cursor-pointer">User Access Policy</span>
            </div>
        </footer>
</x-layouts::html>
