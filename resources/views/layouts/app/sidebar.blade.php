<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f4f6fa] antialiased text-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="!bg-[#0b2545] border-none text-white flex flex-col gap-0 !p-0 min-h-screen h-screen">
            <flux:sidebar.header class="flex flex-col gap-3 px-6 py-5 border-b border-[#1b355a]/30">
                <!-- Circular/Square Logo with "IQ" -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#2563eb] text-white font-black text-sm tracking-tighter shrink-0 select-none">
                        IQ
                    </div>
                    <div class="text-left">
                        <span class="block font-bold text-sm text-white leading-none">IQArchive</span>
                        <span class="block text-[9px] text-[#93c5fd] font-bold uppercase tracking-wider mt-1 select-none">IQA OFFICE &bull; BU</span>
                    </div>
                </div>
            </flux:sidebar.header>

            @php
                $role = auth()->user()->role;
            @endphp
            <!-- Navigation Links -->
            <div class="flex flex-col gap-1.5 flex-1 px-4 py-6">
                <!-- Dashboard -->
                <a href="{{ route('dashboard.' . $role) }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'bg-[#133054] text-white border-l-4 border-[#f27224]' : 'text-[#94a3b8] hover:text-white hover:bg-[#133054]/30' }}" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-current">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Document -->
                <a href="{{ route('documents.' . $role) }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('documents.' . $role) ? 'bg-[#133054] text-white border-l-4 border-[#f27224]' : 'text-[#94a3b8] hover:text-white hover:bg-[#133054]/30' }}" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-current">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-19.5 0A2.25 2.25 0 004.5 15h15a2.25 2.25 0 002.25-2.25m-19.5 0v.25A2.25 2.25 0 004.5 15.25h15a2.25 2.25 0 002.25-2.25v-.25M9 3h6M12 3v6" />
                    </svg>
                    <span>Document</span>
                </a>

                <!-- Submissions -->
                <a href="{{ route('submissions.' . $role) }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('submissions.' . $role) ? 'bg-[#133054] text-white border-l-4 border-[#f27224]' : 'text-[#94a3b8] hover:text-white hover:bg-[#133054]/30' }}" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-current">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Submissions</span>
                </a>

                <!-- Reports -->
                <a href="{{ route('reports.' . $role) }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('reports.' . $role) ? 'bg-[#133054] text-white border-l-4 border-[#f27224]' : 'text-[#94a3b8] hover:text-white hover:bg-[#133054]/30' }}" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-current">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                    <span>Reports</span>
                </a>

                <!-- Settings -->
                <a href="{{ route('settings.' . $role) }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('settings.' . $role) ? 'bg-[#133054] text-white border-l-4 border-[#f27224]' : 'text-[#94a3b8] hover:text-white hover:bg-[#133054]/30' }}" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-current">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.645-.869l.214-1.28z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Settings</span>
                </a>
            </div>

            @php
                $user = auth()->user();
                $roleLabel = match($user?->role) {
                    'system-administrator' => 'System Admin',
                    'iqa-admin' => 'IQA Admin',
                    'iqa-member' => 'IQA Staff',
                    'accreditor' => 'Accreditor',
                    'university-administrator' => 'BU Admin/Exec',
                    'task-force' => 'Task Force',
                    'program-chair' => 'Program Chair',
                    'faculty-member' => 'Faculty Member',
                    default => 'User'
                };
            @endphp

            <!-- Profile Dropdown Component matching Mockup -->
            <flux:dropdown position="top" align="start" class="w-full">
                <button type="button" class="w-[calc(100%-32px)] text-left p-3 bg-[#133054] hover:bg-[#183a64] cursor-pointer rounded-xl mx-4 mb-6 flex items-center gap-3 transition focus:outline-none border-none">
                    <div class="w-9 h-9 rounded-full bg-[#f27224] text-white font-bold flex items-center justify-center text-xs shrink-0 select-none">
                        {{ $user?->initials() }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-bold text-white truncate">{{ $user?->name }}</div>
                        <div class="text-[10px] text-[#93c5fd] truncate">{{ $roleLabel }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-[#93c5fd] ml-auto shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                    </svg>
                </button>

                <flux:menu>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer text-xs"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden !bg-[#0b2545] text-white border-none">
            <flux:sidebar.toggle class="lg:hidden text-white" icon="bars-2" inset="left" />
            <flux:spacer />
            <span class="text-sm font-bold text-white">IQArchive</span>
            <flux:spacer />
            <!-- Simple Logout for Mobile -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-semibold text-zinc-300 hover:text-white p-2">Log out</button>
            </form>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
