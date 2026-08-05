<div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-[#002B61]">Accreditation Matrix Builder</h1>
            <p class="text-xs text-zinc-500 mt-1">Design the requirement grid by mapping AACCUP areas to required document tags.</p>
        </div>
        <button class="bg-[#0056b3] text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-md hover:bg-[#004085] transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            Save Matrix Template
        </button>
    </div>

    <!-- Main Form Content -->
    <div class="bg-white rounded-3xl shadow-3xs border border-slate-200/60 p-8 flex flex-col gap-8">
        
        <!-- Section 1: Basic Info -->
        <div class="flex flex-col gap-4 border-b border-slate-100 pb-8">
            <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">1. Matrix Configuration</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-700">Matrix Title</label>
                    <input type="text" value="AACCUP Master Matrix 2026" class="w-full rounded-xl border-slate-200 text-sm focus:ring-[#f27224] focus:border-[#f27224] shadow-2xs">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-700">Target Program Type</label>
                    <select class="w-full rounded-xl border-slate-200 text-sm focus:ring-[#f27224] focus:border-[#f27224] shadow-2xs">
                        <option>Undergraduate Programs</option>
                        <option>Graduate Programs</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 2: Area Mapping -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">2. Area & Parameter Mapping</h2>
                <button class="text-xs font-bold text-[#f27224] hover:text-[#d96520] transition">+ Add New Area</button>
            </div>

            <!-- Example Area Builder Block -->
            <div class="border border-slate-200/60 rounded-2xl p-6 bg-slate-50 flex flex-col gap-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 w-1/2">
                        <span class="bg-[#002B61] text-white text-[10px] font-bold px-2 py-1 rounded-md">AREA 1</span>
                        <input type="text" value="Vision, Mission, Goals, and Objectives" class="w-full bg-white rounded-lg border-slate-200 text-sm font-bold focus:ring-[#f27224] focus:border-[#f27224] shadow-2xs">
                    </div>
                    <button class="text-zinc-400 hover:text-red-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>

                <!-- Parameters inside Area -->
                <div class="flex flex-col gap-3 pl-8 border-l-2 border-slate-200 ml-4 mt-2">
                    <!-- Parameter Row 1 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-1 flex flex-col gap-2">
                            <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Parameter Name</label>
                            <input type="text" value="Statement of Vision and Mission" class="w-full bg-white rounded-lg border-slate-200 text-xs focus:ring-[#f27224] focus:border-[#f27224] shadow-2xs">
                        </div>
                        <div class="flex-1 flex flex-col gap-2">
                            <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Required Document Tags</label>
                            <div class="w-full bg-white border border-slate-200 rounded-lg p-2 min-h-[38px] flex items-center gap-2 shadow-2xs">
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full">#UniversityManual</span>
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full">#BoardResolution</span>
                                <input type="text" placeholder="Add tag..." class="border-none bg-transparent text-xs focus:ring-0 w-24 p-0">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Parameter Row 2 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-1 flex flex-col gap-2">
                            <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Parameter Name</label>
                            <input type="text" value="Dissemination and Acceptability" class="w-full bg-white rounded-lg border-slate-200 text-xs focus:ring-[#f27224] focus:border-[#f27224] shadow-2xs">
                        </div>
                        <div class="flex-1 flex flex-col gap-2">
                            <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Required Document Tags</label>
                            <div class="w-full bg-white border border-slate-200 rounded-lg p-2 min-h-[38px] flex items-center gap-2 shadow-2xs">
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full">#SurveyResults</span>
                                <input type="text" placeholder="Add tag..." class="border-none bg-transparent text-xs focus:ring-0 w-24 p-0">
                            </div>
                        </div>
                    </div>

                    <button class="self-start text-[10px] font-bold text-[#0056b3] hover:text-[#004085] transition mt-2">+ Add Parameter</button>
                </div>
            </div>
        </div>
    </div>
</div>
