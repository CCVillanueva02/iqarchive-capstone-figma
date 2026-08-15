<!-- LEVEL 4D: NARRATIVE PROFILE VIEW -->
<div x-show="accredCategory === 'Narrative Profile'"
     x-transition class="flex flex-col gap-5 w-full">

    <!-- Context Header Bar -->
    <template x-if="accredProgram !== null">
        <div class="bg-white border border-slate-200/60 rounded-xl px-5 py-3 shadow-3xs flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs font-bold text-[#1b355a]">
                <span class="px-2 py-0.5 bg-violet-50 text-violet-700 rounded border border-violet-200" x-text="accredProgram.code"></span>
                <span x-text="accredProgram.name"></span>
                <span class="text-zinc-400 font-normal">•</span>
                <span class="text-zinc-500 font-medium" x-text="accredProgram.college"></span>
                <span class="ml-2 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-violet-100 text-violet-700">AACCUP Level 3 Narrative Profile</span>
            </div>
            <button type="button" @click="clearProgram()" class="text-xs font-bold text-violet-600 hover:underline cursor-pointer">
                Switch Program
            </button>
        </div>
    </template>

    <!-- Area Selector Horizontal Tablist -->
    <div class="flex overflow-x-auto gap-3 pb-2 w-full select-none">
        <template x-for="area in npAreas" :key="area.id">
            <button type="button"
                class="flex-1 shrink-0 min-w-[200px] bg-white rounded-xl border p-4 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-24"
                :class="npActiveAreaId === area.id ? 'border-[#1b355a] ring-1 ring-[#1b355a]/30 shadow-xs bg-slate-50/50' : 'border-slate-200/60 hover:border-slate-350'"
                @click="npActiveAreaId = area.id">
                <div>
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block" x-text="area.code"></span>
                    <span class="text-sm font-bold text-[#1b355a] mt-1 leading-tight line-clamp-2 block" x-text="area.title"></span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <template x-if="npDocContents[area.id] && npDocContents[area.id].lastSaved">
                        <span class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            Edited & Saved
                        </span>
                    </template>
                    <template x-if="!npDocContents[area.id] || !npDocContents[area.id].lastSaved">
                        <span class="text-[10px] font-bold text-zinc-400">Template Ready</span>
                    </template>
                    <template x-if="npDocGoogleUrls[area.id]">
                        <span class="text-[10px] font-bold text-blue-600 flex items-center gap-0.5">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                            Linked
                        </span>
                    </template>
                </div>
            </button>
        </template>
    </div>

    <!-- Active Area Template Card -->
    <template x-if="npActiveAreaId">
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden">
            <!-- Card Header -->
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <span class="text-[10px] font-bold text-violet-600 uppercase tracking-widest block" x-text="npAreas.find(a => a.id === npActiveAreaId)?.code"></span>
                    <h3 class="text-base font-extrabold text-[#1b355a] mt-0.5" x-text="'Narrative Profile – ' + npAreas.find(a => a.id === npActiveAreaId)?.title"></h3>
                </div>
                
                <!-- Workspace Mode Selector & Action Buttons -->
                <div class="flex items-center gap-2.5 flex-wrap">
                    <!-- Google Docs Link Input Trigger -->
                    <div class="flex items-center bg-white border border-slate-200 rounded-xl px-2.5 py-1 shadow-3xs text-xs">
                        <svg class="w-4 h-4 text-blue-500 mr-1.5 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        <input type="url"
                            placeholder="Paste Google Docs link..."
                            x-model="npDocGoogleUrls[npActiveAreaId]"
                            class="outline-none text-xs text-zinc-700 w-44 placeholder:text-zinc-400">
                        <template x-if="npDocGoogleUrls[npActiveAreaId]">
                            <a :href="npDocGoogleUrls[npActiveAreaId]" target="_blank" class="ml-1 text-blue-600 hover:text-blue-800" title="Open in Google Docs">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                            </a>
                        </template>
                    </div>

                    <button type="button"
                        @click="printDocument(npDocContents[npActiveAreaId]?.content || getDefaultNPTemplate(npActiveAreaId), 'Narrative Profile – ' + (npAreas.find(a => a.id === npActiveAreaId)?.title || ''))"
                        class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-[#1b355a] font-bold text-xs rounded-xl transition cursor-pointer shadow-3xs flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                        Print
                    </button>
                    
                    <button type="button"
                        @click="openNPEditor(npActiveAreaId)"
                        class="px-4 py-2 bg-[#1b355a] hover:bg-[#152a48] text-white font-bold text-xs rounded-xl shadow-3xs transition cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        Open Google Docs Editor
                    </button>
                </div>
            </div>

            <!-- Live Google Docs Embedded View IF Link Provided -->
            <template x-if="npDocGoogleUrls[npActiveAreaId]">
                <div class="p-4 bg-slate-100 border-b border-slate-200">
                    <div class="w-full bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm h-[650px] relative">
                        <iframe :src="getGoogleEmbedUrl(npDocGoogleUrls[npActiveAreaId])" class="w-full h-full border-0" allow="clipboard-read; clipboard-write"></iframe>
                    </div>
                </div>
            </template>

            <!-- Document Preview Section (Floating Paper Aesthetic) -->
            <div class="p-8 bg-slate-100/70 flex justify-center">
                <div class="w-full max-w-3xl bg-white rounded-lg border border-slate-200 shadow-md p-10 font-serif text-sm text-zinc-800 leading-relaxed relative cursor-pointer hover:border-blue-400 transition group"
                    @click="openNPEditor(npActiveAreaId)">
                    
                    <div class="relative prose max-w-none" x-html="npDocContents[npActiveAreaId] ? npDocContents[npActiveAreaId].content : getDefaultNPTemplate(npActiveAreaId)"></div>

                    <!-- Interactive Hover Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-slate-900/10 backdrop-blur-[1px] rounded-lg">
                        <div class="flex items-center gap-2 bg-[#1b355a] text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-xl transform scale-95 group-hover:scale-100 transition duration-150">
                            <svg class="w-4 h-4 text-blue-400" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                            Click to Open Full Document Editor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

</div>

<!-- =====================================================================
     NARRATIVE PROFILE: GOOGLE DOCS WORKSPACE MODAL & FULLSCREEN
     ===================================================================== -->
<div x-show="npEditorOpen"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-98"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-98"
     :class="editorIsFullscreen ? 'fixed inset-0 z-[9999] bg-white w-screen h-screen flex flex-col p-0' : 'fixed inset-0 z-[600] bg-slate-900/60 backdrop-blur-xs flex flex-col items-center justify-center p-2 sm:p-4'"
     @keydown.escape.window="if(npEditorOpen && !editorIsFullscreen) closeNPEditor(); if(editorIsFullscreen) editorIsFullscreen = false;">

    <!-- Editor Container -->
    <div :class="editorIsFullscreen ? 'w-full h-full flex flex-col overflow-hidden bg-white' : 'bg-white rounded-2xl shadow-2xl border border-slate-200/90 w-full max-w-6xl h-[95vh] flex flex-col overflow-hidden relative'">
        
        <!-- ── 1. Google Docs Header Bar ── -->
        <div class="bg-white border-b border-slate-200 px-4 py-2 flex items-center justify-between gap-4 shrink-0 select-none">
            <!-- Left: Document Icon, Title & Real-Time Auto-Save Status -->
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <h2 class="text-sm font-extrabold text-[#1b355a] truncate" x-text="npEditorAreaId ? ('Narrative Profile – ' + npAreas.find(a => a.id === npEditorAreaId)?.title) : ''"></h2>
                        <span class="text-xs px-2 py-0.5 bg-slate-100 text-slate-600 rounded font-medium" x-text="npEditorAreaId ? npAreas.find(a => a.id === npEditorAreaId)?.code : ''"></span>
                    </div>
                    
                    <!-- Auto-Save Status Indicator -->
                    <div class="flex items-center gap-2 mt-0.5">
                        <template x-if="autoSaveStatus === 'saving'">
                            <span class="text-[11px] font-semibold text-amber-600 flex items-center gap-1">
                                <svg class="animate-spin w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Saving changes...
                            </span>
                        </template>
                        <template x-if="autoSaveStatus === 'saved'">
                            <span class="text-[11px] font-medium text-emerald-600 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5"><path fill-rule="evenodd" d="M5.5 17a4.5 4.5 0 01-1.44-8.765 4.5 4.5 0 018.302-3.046 3.5 3.5 0 014.504 4.272A4 4 0 0115 17H5.5zm3.75-5.25l3.5-3.5-1.06-1.06-2.44 2.44-1.44-1.44-1.06 1.06 2.5 2.5z" clip-rule="evenodd" /></svg>
                                All changes auto-saved to drive • <span class="text-zinc-400" x-text="lastSavedTime"></span>
                            </span>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right: Action Controls (Full-Screen Toggle, Save, Print, Close) -->
            <div class="flex items-center gap-2 shrink-0">
                <!-- Fullscreen Toggle Button -->
                <button type="button"
                    @click="toggleEditorFullscreen()"
                    :title="editorIsFullscreen ? 'Exit Full Screen' : 'Distraction-Free Full Screen Mode'"
                    class="p-2 rounded-xl border border-slate-200 hover:bg-slate-100 text-zinc-700 transition cursor-pointer flex items-center gap-1.5 text-xs font-bold">
                    <template x-if="!editorIsFullscreen">
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
                            <span class="hidden md:inline">Full Screen</span>
                        </div>
                    </template>
                    <template x-if="editorIsFullscreen">
                        <div class="flex items-center gap-1 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" /></svg>
                            <span class="hidden md:inline">Exit Full Screen</span>
                        </div>
                    </template>
                </button>

                <!-- Save Now Button -->
                <button type="button" @click="saveNPEditor()" class="px-3.5 py-2 bg-[#1b355a] hover:bg-[#152a48] text-white font-bold text-xs rounded-xl transition cursor-pointer shadow-3xs flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a3.75 3.75 0 00-.1.811V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.611l-2.4-7.539a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" /></svg>
                    Save
                </button>

                <!-- Print Button -->
                <button type="button" @click="printCurrentEditor('np-editor-sheet', 'Narrative Profile – ' + (npAreas.find(a => a.id === npEditorAreaId)?.title || ''))" class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-[#1b355a] font-bold text-xs rounded-xl transition cursor-pointer shadow-3xs flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                    Print
                </button>

                <!-- Close Button -->
                <button type="button" @click="closeNPEditor()" class="p-2 bg-slate-100 hover:bg-slate-200 text-zinc-600 rounded-xl transition cursor-pointer" title="Close Editor">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        <!-- ── 2. Google Docs Ribbon Toolbar & Table Management ── -->
        <div class="bg-slate-50 border-b border-slate-200 px-4 py-1.5 flex items-center gap-1.5 flex-wrap shrink-0 select-none">
            <!-- Undo / Redo -->
            <button type="button" @click="execDocCmd('undo'); triggerAutoSave('np')" title="Undo (Ctrl+Z)" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg>
            </button>
            <button type="button" @click="execDocCmd('redo'); triggerAutoSave('np')" title="Redo (Ctrl+Y)" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3" /></svg>
            </button>
            
            <div class="w-px h-5 bg-slate-300 mx-0.5"></div>

            <!-- Font Family -->
            <select @change="execDocCmd('fontName', $event.target.value); triggerAutoSave('np')" class="text-xs border border-slate-200 rounded-lg px-2 py-1 bg-white text-zinc-700 font-medium cursor-pointer focus:outline-none h-7.5">
                <option value="Times New Roman">Times New Roman</option>
                <option value="Arial">Arial</option>
                <option value="Georgia">Georgia</option>
                <option value="Calibri">Calibri</option>
                <option value="Courier New">Courier New</option>
                <option value="Inter">Inter</option>
            </select>

            <!-- Font Size -->
            <select @change="execDocCmd('fontSize', $event.target.value); triggerAutoSave('np')" class="text-xs border border-slate-200 rounded-lg px-2 py-1 bg-white text-zinc-700 font-medium cursor-pointer focus:outline-none h-7.5">
                <option value="2">10pt</option>
                <option value="3" selected>12pt (Normal)</option>
                <option value="4">14pt (Subheading)</option>
                <option value="5">18pt (Heading)</option>
                <option value="6">24pt (Title)</option>
                <option value="7">36pt (Banner)</option>
            </select>

            <!-- Paragraph Block Style -->
            <select @change="execDocCmd('formatBlock', $event.target.value); triggerAutoSave('np')" class="text-xs border border-slate-200 rounded-lg px-2 py-1 bg-white text-zinc-700 font-medium cursor-pointer focus:outline-none h-7.5">
                <option value="p">Normal text</option>
                <option value="h1">Heading 1</option>
                <option value="h2">Heading 2</option>
                <option value="h3">Heading 3</option>
                <option value="blockquote">Quote block</option>
            </select>

            <div class="w-px h-5 bg-slate-300 mx-0.5"></div>

            <!-- Formatting: Bold, Italic, Underline, Strike -->
            <button type="button" @click="execDocCmd('bold'); triggerAutoSave('np')" title="Bold (Ctrl+B)" class="px-2 py-1 rounded-lg hover:bg-slate-200 text-zinc-800 font-bold text-xs transition cursor-pointer">B</button>
            <button type="button" @click="execDocCmd('italic'); triggerAutoSave('np')" title="Italic (Ctrl+I)" class="px-2 py-1 rounded-lg hover:bg-slate-200 text-zinc-800 italic font-serif text-xs transition cursor-pointer">I</button>
            <button type="button" @click="execDocCmd('underline'); triggerAutoSave('np')" title="Underline (Ctrl+U)" class="px-2 py-1 rounded-lg hover:bg-slate-200 text-zinc-800 underline text-xs transition cursor-pointer">U</button>
            <button type="button" @click="execDocCmd('strikeThrough'); triggerAutoSave('np')" title="Strikethrough" class="px-2 py-1 rounded-lg hover:bg-slate-200 text-zinc-800 line-through text-xs transition cursor-pointer">S</button>

            <!-- Colors -->
            <label title="Text Color" class="p-1 rounded-lg hover:bg-slate-200 transition cursor-pointer flex items-center gap-1 text-xs font-bold text-zinc-700">
                <span>A</span>
                <input type="color" value="#1a1a1a" @change="execDocCmd('foreColor', $event.target.value); triggerAutoSave('np')" class="w-4 h-4 rounded cursor-pointer border-0 p-0 bg-transparent">
            </label>
            <label title="Highlight Color" class="p-1 rounded-lg hover:bg-slate-200 transition cursor-pointer flex items-center gap-1 text-xs text-zinc-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" /></svg>
                <input type="color" value="#fef08a" @change="execDocCmd('hiliteColor', $event.target.value); triggerAutoSave('np')" class="w-4 h-4 rounded cursor-pointer border-0 p-0 bg-transparent">
            </label>

            <div class="w-px h-5 bg-slate-300 mx-0.5"></div>

            <!-- Alignment -->
            <button type="button" @click="execDocCmd('justifyLeft'); triggerAutoSave('np')" title="Align Left" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" /></svg>
            </button>
            <button type="button" @click="execDocCmd('justifyCenter'); triggerAutoSave('np')" title="Align Center" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M7.5 17.25h9" /></svg>
            </button>
            <button type="button" @click="execDocCmd('justifyRight'); triggerAutoSave('np')" title="Align Right" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-7.5 5.25h7.5" /></svg>
            </button>
            <button type="button" @click="execDocCmd('justifyFull'); triggerAutoSave('np')" title="Justify" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>

            <div class="w-px h-5 bg-slate-300 mx-0.5"></div>

            <!-- Lists & Indent -->
            <button type="button" @click="execDocCmd('insertUnorderedList'); triggerAutoSave('np')" title="Bulleted List" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
            </button>
            <button type="button" @click="execDocCmd('insertOrderedList'); triggerAutoSave('np')" title="Numbered List" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.131a2 2 0 010 4H4.094c-.117 0-.232-.009-.344-.026M3.75 9.776a2 2 0 010 3.948M3.75 9.776V6a2 2 0 114 0v3.776M3.75 13.724V18a2 2 0 11-4 0v-4.276" /></svg>
            </button>

            <div class="w-px h-5 bg-slate-300 mx-0.5"></div>

            <!-- ── ADVANCED TABLE MANAGEMENT TOOLS ── -->
            <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-lg p-0.5 shadow-3xs" x-data="{ tableMenuOpen: false }" @click.outside="tableMenuOpen = false">
                <!-- Insert Table (New) -->
                <button type="button" @click="insertDocumentTable('np-editor-sheet'); triggerAutoSave('np')" title="Insert 3x3 Table" class="px-2 py-1 hover:bg-slate-100 rounded text-zinc-700 text-xs font-semibold flex items-center gap-1 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /></svg>
                    Table
                </button>

                <!-- Quick Row & Column Modifiers -->
                <button type="button" @click="insertTableRow('np-editor-sheet', 'below')" title="Add Row Below" class="px-1.5 py-1 hover:bg-slate-100 rounded text-zinc-700 text-xs font-semibold transition cursor-pointer flex items-center gap-0.5">
                    <span class="text-[10px]">+Row</span>
                </button>
                <button type="button" @click="deleteTableRow('np-editor-sheet')" title="Delete Current Row" class="px-1.5 py-1 hover:bg-red-50 hover:text-red-600 rounded text-zinc-600 text-xs font-semibold transition cursor-pointer flex items-center gap-0.5">
                    <span class="text-[10px]">-Row</span>
                </button>
                <button type="button" @click="insertTableColumn('np-editor-sheet', 'right')" title="Add Column Right" class="px-1.5 py-1 hover:bg-slate-100 rounded text-zinc-700 text-xs font-semibold transition cursor-pointer flex items-center gap-0.5">
                    <span class="text-[10px]">+Col</span>
                </button>
                <button type="button" @click="deleteTableColumn('np-editor-sheet')" title="Delete Current Column" class="px-1.5 py-1 hover:bg-red-50 hover:text-red-600 rounded text-zinc-600 text-xs font-semibold transition cursor-pointer flex items-center gap-0.5">
                    <span class="text-[10px]">-Col</span>
                </button>
            </div>

            <!-- Insert Image -->
            <label title="Insert Picture" class="px-2 py-1 bg-white hover:bg-slate-200 border border-slate-200 rounded-lg text-zinc-700 text-xs font-semibold flex items-center gap-1 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                Picture
                <input type="file" accept="image/*" class="hidden" @change="insertDocumentImage($event, 'np-editor-sheet')">
            </label>

            <!-- Clear formatting -->
            <button type="button" @click="execDocCmd('removeFormat'); triggerAutoSave('np')" title="Clear Formatting" class="p-1.5 rounded-lg hover:bg-slate-200 text-zinc-700 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.21-.211.498-.33.795-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" /></svg>
            </button>
        </div>

        <!-- ── 3. Interactive Floating Paper Canvas (Directly Clickable & Editable) ── -->
        <div class="flex-1 overflow-y-auto bg-slate-200/90 py-8 px-4 flex justify-center cursor-text"
             @click="document.getElementById('np-editor-sheet')?.focus()">
            <div :class="editorIsFullscreen ? 'w-full max-w-5xl' : 'w-full max-w-4xl'">
                <div id="np-editor-sheet"
                     contenteditable="true"
                     spellcheck="true"
                     tabindex="0"
                     class="bg-white shadow-2xl rounded-sm outline-none focus:outline-none cursor-text transition"
                     style="min-height: 1056px; padding: 72px 96px; font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.8; color: #1a1a1a;"
                     @input="triggerAutoSave('np')"
                     @keydown.ctrl.s.prevent="saveNPEditor()"
                     @keydown.meta.s.prevent="saveNPEditor()">
                </div>
            </div>
        </div>

        <!-- ── 4. Bottom Status Bar ── -->
        <div class="bg-white border-t border-slate-200 px-5 py-2 flex items-center justify-between text-xs text-zinc-500 shrink-0 select-none">
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1.5 text-emerald-600 font-medium">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                    Continuous Auto-Save Active
                </span>
                <span class="text-zinc-300">•</span>
                <span>Click directly on the page to type • Table management available in ribbon</span>
            </div>
            <div class="text-[11px] text-zinc-400">
                AACCUP Level 3 Narrative Profile Workspace
            </div>
        </div>

    </div>
</div>
