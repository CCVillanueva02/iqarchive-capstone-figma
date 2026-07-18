<!-- Top Navbar -->
<header class="w-full max-w-7xl mx-auto px-6 py-5 flex items-center justify-between font-sans">
    <div class="flex items-center gap-3">
        <img src="/bulogo.png" alt="Bicol University Logo" class="w-10 h-10 object-contain select-none shrink-0" />
        <div>
            <span class="font-extrabold text-lg text-[#002B61] tracking-tight select-none">IQArchive</span>
            <span class="block text-[10px] text-zinc-400 font-semibold uppercase tracking-wider -mt-1 select-none">IQA Office &bull; BU</span>
        </div>
    </div>

    <nav class="flex items-center gap-4">
        @auth
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4.5 py-2.5 border border-transparent text-xs font-bold rounded-xl bg-[#f27224] hover:bg-[#d65f1a] text-white transition duration-200 shadow-3xs cursor-pointer select-none">
            Go to Dashboard
        </a>
        @else
        <a href="{{ route('login') }}" class="inline-flex items-center px-4.5 py-2.5 border border-slate-200 text-xs font-bold rounded-xl text-[#002B61] hover:bg-slate-50 hover:border-slate-350 transition duration-200 cursor-pointer select-none">
            Log In
        </a>
        @endauth
    </nav>
</header>