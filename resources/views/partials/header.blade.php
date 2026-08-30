<!-- Top Navbar Banner -->
<header class="w-full bg-primary-dark text-white shadow-md font-sans relative">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo / Brand Section -->
        <div class="flex items-center gap-3 select-none">
            <img src="/bulogo.png" alt="Bicol University Logo" class="w-9 h-9 object-contain select-none shrink-0" />
            <span class="font-extrabold text-heading tracking-tight text-white">
                <span class="text-brand-orange">IQA</span>rchive
            </span>
        </div>

        <!-- Right Authentication / Controls Section -->
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-body font-bold text-white hover:text-zinc-200 transition select-none">
                <svg class="w-6 h-6 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Sign in</span>
            </a>
        </div>
    </div>
</header>