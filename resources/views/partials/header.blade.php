<!-- Top Navbar Banner -->
<header class="w-full bg-[#002B61] text-white shadow-md font-sans relative">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo / Brand Section -->
        <a href="#home" class="flex items-center gap-3 cursor-pointer select-none">
            <img src="/bulogo.png" alt="Bicol University Logo" class="w-9 h-9 object-contain select-none shrink-0" />
            <div>
                <span class="font-extrabold text-lg tracking-tight block leading-tight">
                    <span class="text-[#f27224]">IQA</span>rchive
                </span>
                <span class="block text-[9px] text-zinc-300 font-semibold uppercase tracking-wider -mt-0.5">
                    Bicol University
                </span>
            </div>
        </a>

        <!-- Center Navigation Links -->
        <nav class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center gap-2">
            <a href="#home" class="bg-white/10 text-white px-3.5 py-1.5 rounded-lg text-xs font-bold transition hover:bg-white/20 select-none">
                Home
            </a>
            <a href="#accreditations" class="text-zinc-200 hover:text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold transition hover:bg-white/5 select-none">
                Accreditations
            </a>
            <a href="#faq" class="text-zinc-200 hover:text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold transition hover:bg-white/5 select-none">
                FAQ
            </a>
            <a href="#help-center" class="text-zinc-200 hover:text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold transition hover:bg-white/5 select-none">
                Help Center
            </a>
        </nav>

        <!-- Right Authentication / Controls Section -->
        <div class="flex items-center gap-4">
            
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white hover:text-zinc-200 transition select-none">
                    <svg class="w-4 h-4 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Go to Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white hover:text-zinc-200 transition select-none">
                    <svg class="w-4 h-4 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Sign in</span>
                </a>
            @endauth

        </div>
    </div>
</header>