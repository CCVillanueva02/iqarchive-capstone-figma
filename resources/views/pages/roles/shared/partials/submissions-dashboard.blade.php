<div x-data="submissionsWorkspace()" class="flex flex-col gap-6 relative w-full h-full">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-[#1b355a]">University Accreditation Monitoring</h2>
            <p class="text-sm text-zinc-500 mt-1">Track the accreditation status of academic programs across the university based on AACCUP monitoring.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="bg-[#1b355a] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-2xs hover:bg-[#112239] transition flex items-center gap-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Export Report
            </button>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-2 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-16 h-16 bg-blue-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Total Monitored</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </div>
            </div>
            <div class="relative z-10 flex items-end gap-2 mt-1">
                <span class="text-3xl font-black text-[#1b355a]" x-text="dashboardMetrics.total"></span>
            </div>
        </div>

        <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-2 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-16 h-16 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Timely / Active</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div class="relative z-10 flex items-end gap-2 mt-1">
                <span class="text-3xl font-black text-emerald-600" x-text="dashboardMetrics.timely"></span>
            </div>
        </div>

        <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-2 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-16 h-16 bg-rose-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Late / Expired</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" />
                    </svg>
                </div>
            </div>
            <div class="relative z-10 flex items-end gap-2 mt-1">
                <span class="text-3xl font-black text-rose-500" x-text="dashboardMetrics.late"></span>
            </div>
        </div>

        <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-2 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-16 h-16 bg-amber-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Due For Review</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div class="relative z-10 flex items-end gap-2 mt-1">
                <span class="text-3xl font-black text-amber-500" x-text="dashboardMetrics.due"></span>
            </div>
        </div>
    </div>

    <!-- Filters and Table -->
    <div class="flex-1 flex flex-col gap-4 min-w-0">
        <!-- Search and Filters -->
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs">
            <div class="relative flex-1 w-full max-w-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text"
                    x-model="searchQuery"
                    placeholder="Search by program or college name..."
                    class="w-full pl-10 pr-9 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-zinc-800 focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a] transition" />
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select x-model="collegeFilter" class="flex-1 md:flex-none px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-zinc-700 font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20">
                    <option value="all">All Colleges</option>
                    <template x-for="college in colleges" :key="college.id">
                        <option :value="college.id" x-text="college.name"></option>
                    </template>
                </select>
                <select x-model="statusFilter" class="flex-1 md:flex-none px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-zinc-700 font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20">
                    <option value="all">All Timeliness Status</option>
                    <option value="timely">Timely</option>
                    <option value="late">Late</option>
                    <option value="due">Due for Accreditation</option>
                </select>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-600">
                    <thead class="bg-slate-50 border-b border-slate-200/80 text-xs text-zinc-500 uppercase tracking-wider font-bold">
                        <tr>
                            <th scope="col" class="px-6 py-4">Program / College</th>
                            <th scope="col" class="px-6 py-4">Level / Rating</th>
                            <th scope="col" class="px-6 py-4">Latest Visit Date</th>
                            <th scope="col" class="px-6 py-4">Validity Duration</th>
                            <th scope="col" class="px-6 py-4">Remarks</th>
                            <th scope="col" class="px-6 py-4 text-center">Timeliness</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="prog in filteredPrograms" :key="prog.id">
                            <tr class="hover:bg-slate-50/50 transition cursor-pointer group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-[#1b355a] group-hover:text-blue-600 transition" x-text="prog.name"></div>
                                    <div class="text-[11px] font-semibold text-zinc-500 mt-1 uppercase tracking-wide" x-text="getCollegeName(prog.college)"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-zinc-700" x-text="prog.level"></div>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="text-[10px] uppercase font-bold text-zinc-400">Rating:</span>
                                        <span class="text-xs font-black text-[#1b355a]" x-text="prog.rating"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-zinc-600 font-medium flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-blue-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        <span x-text="prog.latestVisit"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-zinc-600 font-medium text-xs">
                                        <div class="flex items-center gap-1.5 mb-1">
                                            <span class="w-8 text-[10px] font-bold text-zinc-400">From</span>
                                            <span x-text="prog.validFrom"></span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-8 text-[10px] font-bold text-zinc-400">To</span>
                                            <span x-text="prog.validTo"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs text-zinc-600 line-clamp-2 max-w-[200px]" x-text="prog.remarks || '-'"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide border inline-flex items-center justify-center min-w-[70px]"
                                        :class="getStatusBadgeClass(prog.status)"
                                        x-text="prog.status">
                                    </span>
                                </td>
                            </tr>
                        </template>
                        
                        <template x-if="filteredPrograms.length === 0">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 text-zinc-400 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-zinc-700">No programs found</h3>
                                        <p class="text-xs text-zinc-500">Adjust your search or filters to see results.</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
