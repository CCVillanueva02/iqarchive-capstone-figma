<x-layouts::app :title="__('General Documents')">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 flex flex-col gap-6">
        <!-- Top Header & Tabs -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#1b355a]">General Documents</h1>
                <p class="text-xs text-zinc-500 mt-1">Manage your general documents</p>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Toggle Tab Switcher -->
                <div class="bg-slate-100 border border-slate-200/60 rounded-lg p-0.5 flex gap-1 text-[11px]">
                    <button type="button" class="px-4 py-1.5 font-bold rounded-md bg-white border border-slate-200/50 shadow-2xs text-[#1b355a]">
                        General Documents
                    </button>
                    <button type="button" class="px-4 py-1.5 font-medium rounded-md text-zinc-500 hover:text-[#1b355a] transition">
                        Accreditation
                    </button>
                </div>

                <!-- Bell Notification Button -->
                <button type="button" class="relative p-2 rounded-lg bg-white border border-slate-200 text-zinc-500 hover:text-[#1b355a] transition shadow-3xs cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a9.04 9.04 0 01-2.037.228 9 9 0 01-2.037-.228m4.074 0A8.987 8.987 0 0113.5 18a8.987 8.987 0 01-2.25-.918m4.074 0c.385-.233.644-.64.644-1.12 0-1.242.781-2.28 1.975-2.679.487-.163.825-.63.825-1.144V9a3 3 0 00-3-3m-6 3v1.14c0 .513-.338.98-.824 1.144A4.502 4.502 0 004.5 13.5c0 .48.259.887.644 1.12m0 0a9.03 9.03 0 012.037-.228m-2.037.228A9.01 9.01 0 019 15.75c0 .034-.002.066-.007.098m0 0A3.375 3.375 0 019 18" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-orange-500 rounded-full border border-white"></span>
                </button>
            </div>
        </div>

        <!-- Filter Controls Container Card -->
        <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs">
            <div class="flex flex-col lg:flex-row gap-3 items-center justify-between">
                <!-- Select Filters -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 w-full lg:w-auto">
                    <!-- Doc Type Select -->
                    <div class="relative">
                        <select class="w-full lg:w-36 text-xs bg-[#f8fafc] border border-slate-200 rounded-lg px-3 py-2.5 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                            <option>Doc Type</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                            <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>

                    <!-- College/Office Select -->
                    <div class="relative">
                        <select class="w-full lg:w-40 text-xs bg-[#f8fafc] border border-slate-200 rounded-lg px-3 py-2.5 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                            <option>College/Office</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                            <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>

                    <!-- Date Select -->
                    <div class="relative">
                        <select class="w-full lg:w-32 text-xs bg-[#f8fafc] border border-slate-200 rounded-lg px-3 py-2.5 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                            <option>Date</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                            <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>

                    <!-- Status Select -->
                    <div class="relative">
                        <select class="w-full lg:w-32 text-xs bg-[#f8fafc] border border-slate-200 rounded-lg px-3 py-2.5 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                            <option>Status</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                            <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Search and Action button -->
                <div class="flex items-center gap-3 w-full lg:w-auto">
                    <!-- Search Input -->
                    <div class="relative w-full lg:w-[320px]">
                        <input 
                            type="text" 
                            placeholder="Search documents by title, type, or uploader..." 
                            class="w-full text-xs border border-slate-200 rounded-lg pl-8 pr-3 py-2.5 focus:outline-none focus:border-slate-300 bg-slate-50/50"
                        />
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-zinc-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Upload Button -->
                    <button type="button" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-xs font-bold px-4 py-2.5 rounded-lg flex items-center gap-1.5 shrink-0 shadow-2xs transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Upload Document
                    </button>
                </div>
            </div>
        </div>

        <!-- Document Categories Grid (5 columns on large screen, matching mockup) -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Category 1: Policies & Issuances -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Policies & Issuances</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Admin orders, office policies, notices</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 2: Instruments -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zM9 13h6M9 17h3" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Instruments</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Per-area accreditation guides, surveys</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 3: Memoranda -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Memoranda</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Internal circulars and memos</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 4: Correspondences -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Correspondences</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Letters to/from colleges, AACCUP, admin</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 5: Meeting Documents -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A2.25 2.25 0 0112.75 21.5h-1.5a2.25 2.25 0 01-2.25-2.263V19.13m0-3.078a9.001 9.001 0 01-5.603-.953 4.125 4.125 0 00-7.533 2.493M9.002 16.052a9.043 9.043 0 012.998.948m1.879-12.092A3 3 0 0115 6c0 .895-.39 1.7-1.02 2.25m-.74 11.25a9 9 0 003.56-1.785m-11.722 0a9 9 0 003.56 1.785m1.28-11.25a3 3 0 11-6 0 3 3 0 016 0zm9.75 0a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Meeting Documents</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Agenda, minutes, attendance sheets</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 6: Training Materials -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 019.918 5.84 50.45 50.45 0 00-2.658.814m-15.482 0l6.29 1.913a48.741 48.741 0 013.784 0l6.29-1.913m-12.458 0L3.75 9.75M12 12.75v-10.5" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Training Materials</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Orientation kits, workshop handouts</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 7: Announcements -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Announcements</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Advisories, schedule notices to colleges</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 8: Forms & Templates -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Forms & Templates</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Blank forms, endorsement templates</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 9: Reports & Evaluations -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0017.75 3.75H6.25A2.25 2.25 0 004 6v12A2.25 2.25 0 006.25 20.25z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Reports & Evaluations</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Annual reports, compliance summaries</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>

            <!-- Category 10: Other Documents -->
            <div class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between hover:shadow-2xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-19.5 0A2.25 2.25 0 004.5 15h15a2.25 2.25 0 002.25-2.25m-19.5 0v.25A2.25 2.25 0 004.5 15.25h15a2.25 2.25 0 002.25-2.25v-.25M9 3h6M12 3v6" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm text-[#1b355a] leading-tight">Other Documents</h3>
                    <p class="text-[11px] text-zinc-500 mt-1 leading-normal">Uncategorized files</p>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-bold text-[#1b355a]">3 documents</span>
                </div>
            </div>
        </div>

        <!-- Pagination Section Card -->
        <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs flex flex-row items-center justify-between mt-4">
            <span class="text-xs text-zinc-500 select-none">
                Showing 1-10 of 48 documents
            </span>

            <div class="flex items-center gap-1">
                <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-zinc-400 cursor-not-allowed" disabled>
                    Prev
                </button>
                <button type="button" class="px-3.5 py-1.5 rounded-lg bg-[#0b2545] text-white text-xs font-bold">
                    1
                </button>
                <button type="button" class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-xs text-zinc-600 font-semibold hover:bg-slate-50 transition cursor-pointer">
                    2
                </button>
                <button type="button" class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-xs text-zinc-600 font-semibold hover:bg-slate-50 transition cursor-pointer">
                    3
                </button>
                <span class="px-2 text-zinc-400 text-xs select-none">...</span>
                <button type="button" class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-xs text-zinc-600 font-semibold hover:bg-slate-50 transition cursor-pointer">
                    8
                </button>
                <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-zinc-600 hover:bg-slate-50 transition cursor-pointer">
                    Next
                </button>
            </div>
        </div>
    </div>
</x-layouts::app>
