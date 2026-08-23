<flux:sidebar sticky collapsible="mobile" class="border-none text-white flex flex-col gap-0 p-0! min-h-screen h-screen no-scrollbar" style="background: linear-gradient(180deg, var(--color-primary-dark) 0%, var(--color-primary-hover) 100%) !important;">
    <flux:sidebar.header class="flex flex-col gap-3 px-5 py-6 border-b border-white/10">
        <div class="flex items-center justify-start gap-3 mr-auto text-left w-full">
            <img src="/bulogo.png" alt="BU Logo" class="w-10 h-10 object-contain shrink-0 select-none" />
            <div class="flex flex-col">
                <span class="block font-bold text-heading tracking-[0.5px] leading-tight text-white">IQArchive</span>
                <span class="block text-label text-white/70 font-semibold uppercase tracking-wider mt-0.5 select-none">IQA Office &bull; BU</span>
            </div>
        </div>
    </flux:sidebar.header>

    @php
    $role = auth()->user()->role;
    if (in_array($role, ['iqa-admin', 'iqa-member'])) {
    $role = 'iqa-staff';
    }
    @endphp

    <!-- Wrapper for Scrollable Nav Area & Low-Opacity Chevron Indicator -->
    <div class="relative flex-1 min-h-0 flex flex-col">
        <div x-data="{
                 hasMoreBelow: false,
                 checkScroll() {
                     const el = this.$el;
                     const isOverflowing = el.scrollHeight > el.clientHeight;
                     const isAtBottom = el.scrollTop + el.clientHeight >= el.scrollHeight - 4;
                     this.hasMoreBelow = isOverflowing && !isAtBottom;
                 },
                 restoreScroll() {
                     const stored = sessionStorage.getItem('sidebar_scroll_top');
                     if (stored !== null) {
                         this.$el.scrollTop = parseInt(stored, 10);
                     }
                     this.checkScroll();
                 },
                 saveScroll() {
                     sessionStorage.setItem('sidebar_scroll_top', this.$el.scrollTop);
                     this.checkScroll();
                 }
             }"
            x-init="
                 restoreScroll();
                 this.$nextTick(() => restoreScroll());
                 document.addEventListener('livewire:navigated', () => restoreScroll());
             "
            x-ref="scrollContainer"
            @scroll.debounce.50ms="saveScroll()"
            @resize.window.debounce.100ms="checkScroll()"
            class="flex flex-col gap-1.5 flex-1 py-6 overflow-y-auto no-scrollbar relative">

            <div class="px-6 pb-1">
                <span class="text-label-xs font-bold uppercase tracking-[1.5px] text-white/40">Accreditation</span>
            </div>
            @if (in_array($role, ['iqa-staff', 'system-administrator', 'task-force-member', 'college-head']))

            <!-- Dashboard -->
            <a href="{{ route('dashboard.' . $role) }}" class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="16" width="7" height="5"></rect>
                </svg>
                <span>Dashboard</span>
            </a>
            @endif

            @if (in_array($role, ['task-force-member', 'college-head', 'iqa-staff', 'system-administrator']))
            @php
            $canSeeCommonDocs = in_array($role, ['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);
            $canSeeInstitutionalDocs = in_array($role, ['iqa-staff', 'system-administrator']);
            $defaultTabForRole = 'common-documents';
            $currentDocTab = $currentDocTab ?? request()->query('tab', $defaultTabForRole);
            @endphp

            <!-- Documents Tab & Subtabs (Collapsible) -->
            <div class="flex flex-col" x-data="{ docsOpen: {{ request()->routeIs('documents.' . $role) ? 'true' : 'false' }} }">
                <!-- Documents toggle button (does NOT navigate, just toggles submenu) -->
                <button type="button"
                    @click="docsOpen = !docsOpen"
                    class="group flex items-center justify-between px-6 py-3.5 border-l-4 text-body font-semibold transition-all cursor-pointer {{ request()->routeIs('documents.' . $role) ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}">
                    <div class="flex items-center gap-3.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <span>Documents</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        class="transition-transform duration-200"
                        :class="docsOpen ? 'rotate-180 text-white' : 'text-white/40 group-hover:text-white/70'">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>

                <!-- Documents Subtabs (collapsible) -->
                <div x-show="docsOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    x-cloak
                    class="flex flex-col py-3 bg-black/15">

                    <!-- Vertical connecting line container -->
                    <div class="relative pl-10.5 pr-4 flex flex-col gap-0">
                        <!-- The vertical line -->
                        <div class="absolute left-7.5 top-5.5 bottom-5.5 w-[1.5px] bg-white/15"></div>

                        @if ($canSeeCommonDocs)
                        <!-- Common Documents -->
                        <a href="{{ route('documents.' . $role, ['tab' => 'common-documents']) }}"
                            class="relative flex items-center gap-3 px-4 py-3 rounded-lg text-body-sm transition-all {{ ($currentDocTab === 'common-documents' && request()->routeIs('documents.' . $role)) ? 'bg-white/12 text-emerald-400 font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                            wire:navigate>
                            <!-- Dot on the line -->
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-1.75 h-1.75 rounded-full border-[1.5px] {{ ($currentDocTab === 'common-documents' && request()->routeIs('documents.' . $role)) ? 'bg-emerald-400 border-emerald-400' : 'bg-white/20 border-white/30' }}"></span>
                            <!-- Icon -->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ ($currentDocTab === 'common-documents' && request()->routeIs('documents.' . $role)) ? 'text-emerald-400' : 'text-white/40' }}">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                            <span>Common Documents</span>
                        </a>
                        @endif

                        <!-- Program Accreditation -->
                        <a href="{{ route('documents.' . $role, ['tab' => 'program-accreditation']) }}"
                            class="relative flex items-center gap-3 px-4 py-3 rounded-lg text-body-sm transition-all {{ ($currentDocTab === 'program-accreditation' && request()->routeIs('documents.' . $role)) ? 'bg-white/12 text-emerald-400 font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                            wire:navigate>
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-1.75 h-1.75 rounded-full border-[1.5px] {{ ($currentDocTab === 'program-accreditation' && request()->routeIs('documents.' . $role)) ? 'bg-emerald-400 border-emerald-400' : 'bg-white/20 border-white/30' }}"></span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ ($currentDocTab === 'program-accreditation' && request()->routeIs('documents.' . $role)) ? 'text-emerald-400' : 'text-white/40' }}">
                                <path d="M3 21h18"></path>
                                <path d="M5 21V7l7-4 7 4v14"></path>
                                <path d="M9 21v-4h6v4"></path>
                                <path d="M10 10h4"></path>
                            </svg>
                            <span>Program Accreditation</span>
                        </a>

                        @if ($canSeeInstitutionalDocs)
                        <!-- Institutional Accreditation -->
                        <a href="{{ route('documents.' . $role, ['tab' => 'institutional-accreditation']) }}"
                            class="relative flex items-center gap-3 px-4 py-3 rounded-lg text-body-sm transition-all {{ ($currentDocTab === 'institutional-accreditation' && request()->routeIs('documents.' . $role)) ? 'bg-white/12 text-emerald-400 font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                            wire:navigate>
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-1.75 h-1.75 rounded-full border-[1.5px] {{ ($currentDocTab === 'institutional-accreditation' && request()->routeIs('documents.' . $role)) ? 'bg-emerald-400 border-emerald-400' : 'bg-white/20 border-white/30' }}"></span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ ($currentDocTab === 'institutional-accreditation' && request()->routeIs('documents.' . $role)) ? 'text-emerald-400' : 'text-white/40' }}">
                                <rect x="4" y="10" width="16" height="11" rx="1"></rect>
                                <path d="M8 10V6a4 4 0 0 1 8 0v4"></path>
                                <path d="M8 14h2"></path>
                                <path d="M14 14h2"></path>
                                <path d="M8 18h2"></path>
                                <path d="M14 18h2"></path>
                            </svg>
                            <span>Institutional Accreditation</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif


            <!-- Monitoring Tab & Subtabs (Collapsible) -->
            @if (in_array($role, ['task-force-member', 'college-head', 'iqa-staff']))
            <div class="flex flex-col" x-data="{ monOpen: {{ request()->routeIs('monitoring.*') ? 'true' : 'false' }} }">
                <button type="button"
                    @click="monOpen = !monOpen"
                    class="group flex items-center justify-between px-6 py-3.5 border-l-4 text-body font-semibold transition-all cursor-pointer {{ request()->routeIs('monitoring.*') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}">
                    <div class="flex items-center gap-3.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span>Monitoring</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        class="transition-transform duration-200"
                        :class="monOpen ? 'rotate-180 text-white' : 'text-white/40 group-hover:text-white/70'">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>

                <!-- Monitoring Subtabs -->
                <div x-show="monOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    x-cloak
                    class="flex flex-col py-3 bg-black/15">

                    <div class="relative pl-10.5 pr-4 flex flex-col gap-0">
                        <!-- Vertical connecting line -->
                        <div class="absolute left-7.5 top-5.5 bottom-5.5 w-[1.5px] bg-white/15"></div>

                        @php
                        $currentMonTab = request()->query('tab', 'dashboard');
                        @endphp

                        <!-- Dashboard Overview -->
                        <a href="{{ route('monitoring.index', ['tab' => 'dashboard']) }}"
                            class="relative flex items-center gap-3 px-4 py-3 rounded-lg text-body-sm transition-all {{ ($currentMonTab === 'dashboard' && request()->routeIs('monitoring.*')) ? 'bg-white/12 text-emerald-400 font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                            wire:navigate>
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-1.75 h-1.75 rounded-full border-[1.5px] {{ ($currentMonTab === 'dashboard' && request()->routeIs('monitoring.*')) ? 'bg-emerald-400 border-emerald-400' : 'bg-white/20 border-white/30' }}"></span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ ($currentMonTab === 'dashboard' && request()->routeIs('monitoring.*')) ? 'text-emerald-400' : 'text-white/40' }}">
                                <rect x="3" y="3" width="7" height="9"></rect>
                                <rect x="14" y="3" width="7" height="5"></rect>
                                <rect x="14" y="12" width="7" height="9"></rect>
                                <rect x="3" y="16" width="7" height="5"></rect>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- Summary Report -->
                        <a href="{{ route('monitoring.index', ['tab' => 'summary']) }}"
                            class="relative flex items-center gap-3 px-4 py-3 rounded-lg text-body-sm transition-all {{ ($currentMonTab === 'summary' && request()->routeIs('monitoring.*')) ? 'bg-white/12 text-emerald-400 font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                            wire:navigate>
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-1.75 h-1.75 rounded-full border-[1.5px] {{ ($currentMonTab === 'summary' && request()->routeIs('monitoring.*')) ? 'bg-emerald-400 border-emerald-400' : 'bg-white/20 border-white/30' }}"></span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ ($currentMonTab === 'summary' && request()->routeIs('monitoring.*')) ? 'text-emerald-400' : 'text-white/40' }}">
                                <path d="M3 3v18h18"></path>
                                <path d="m19 9-5 5-4-4-3 3"></path>
                            </svg>
                            <span>Summary Report</span>
                        </a>

                        <!-- Programs -->
                        <a href="{{ route('monitoring.index', ['tab' => 'programs']) }}"
                            class="relative flex items-center gap-3 px-4 py-3 rounded-lg text-body-sm transition-all {{ ($currentMonTab === 'programs' && request()->routeIs('monitoring.*')) ? 'bg-white/12 text-emerald-400 font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                            wire:navigate>
                            <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-1.75 h-1.75 rounded-full border-[1.5px] {{ ($currentMonTab === 'programs' && request()->routeIs('monitoring.*')) ? 'bg-emerald-400 border-emerald-400' : 'bg-white/20 border-white/30' }}"></span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ ($currentMonTab === 'programs' && request()->routeIs('monitoring.*')) ? 'text-emerald-400' : 'text-white/40' }}">
                                <path d="M8 6h13"></path>
                                <path d="M8 12h13"></path>
                                <path d="M8 18h13"></path>
                                <path d="M3 6h.01"></path>
                                <path d="M3 12h.01"></path>
                                <path d="M3 18h.01"></path>
                            </svg>
                            <span>Programs</span>
                        </a>
                    </div>
                </div>
            </div>
            @endif







            <!-- Accreditation Visits -->
            @if (in_array($role, ['iqa-staff']))
            <a href="{{ route('visits.index') }}" class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body font-semibold transition-all {{ request()->routeIs('visits.*') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <path d="m9 16 2 2 4-4"></path>
                </svg>
                <span>Record a Visit</span>
            </a>
            @endif

            <!-- Task Forces -->
            @if (in_array($role, ['iqa-staff', 'university-administrator', 'college-head', 'system-administrator']))
            <a href="{{ route('task-forces.index') }}" class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body font-semibold transition-all {{ request()->routeIs('task-forces.*') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Task Forces</span>
            </a>
            @endif


            <!-- Accounts -->
            @if (in_array($role, ['iqa-staff', 'system-administrator']))
            <a href="{{ route('accounts.' . $role) }}" class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body font-semibold transition-all {{ request()->routeIs('accounts.' . $role) ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Accounts</span>
            </a>
            @endif

            <!-- University Executive: Analytics -->
            @if (in_array($role, ['university-administrator', 'system-administrator', 'iqa-staff']))
            <div class="px-6 pt-2 pb-1">
                <span class="text-label-xs font-bold uppercase tracking-[1.5px] text-white/40">Overview</span>
            </div>

            <!-- Audit Trail -->
            @if (in_array($role, ['system-administrator', 'iqa-staff']))
            @php
            $auditTrailRoute = ($role === 'iqa-staff') ? route('audit-trail.iqa-staff') : route('reports.system-administrator');
            $isAuditTrailActive = request()->routeIs('audit-trail.*') || request()->routeIs('reports.system-administrator');
            @endphp
            <a href="{{ $auditTrailRoute }}" class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body font-semibold transition-all {{ $isAuditTrailActive ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>Audit Trail</span>
            </a>
            @endif

            <a href="{{ route('analytics.university-administrator') }}" class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body font-semibold transition-all {{ request()->routeIs('analytics.university-administrator') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                </svg>
                <span>Analytics</span>
            </a>

            <!-- University Executive: Reports -->
            <a href="{{ route('reports.university-administrator') }}" class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body font-semibold transition-all {{ request()->routeIs('reports.university-administrator') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Reports</span>
            </a>
            @endif

            <!-- Configuration Section -->
            @if (in_array($role, ['iqa-staff', 'system-administrator', 'university-administrator']))
            <div class="px-6 pt-3 pb-1">
                <span class="text-label-xs font-bold uppercase tracking-[1.5px] text-white/40">Configuration</span>
            </div>

            <!-- Colleges & Programs -->
            <a href="{{ route('configuration.colleges-programs') }}" class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body font-semibold transition-all {{ request()->routeIs('configuration.colleges-programs') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
                <span>Colleges &amp; Programs</span>
            </a>

            <!-- Reserved Slot: Instruments (Future Rubrics/Instruments Builder) -->
            <div class="group flex items-center justify-between px-6 py-3.5 border-l-4 border-l-transparent text-white/30 cursor-not-allowed select-none" title="Accreditation Instrument Builder (Coming Soon)">
                <div class="flex items-center gap-3.5">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <path d="m9 15 2 2 4-4"></path>
                    </svg>
                    <span>Instruments</span>
                </div>
                <span class="text-label-xs px-2 py-0.5 rounded-full bg-white/10 text-white/40 font-bold uppercase tracking-wider">Soon</span>
            </div>
            @endif

        </div>

        <!-- Subtle Low-Opacity Downward Chevron Overflow Indicator -->
        <button type="button"
            x-show="hasMoreBelow"
            x-cloak
            x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="$refs.scrollContainer.scrollBy({ top: 120, behavior: 'smooth' })"
            title="Scroll down for more"
            aria-label="Scroll down for more items"
            class="absolute bottom-2 left-1/2 -translate-x-1/2 p-1.5 rounded-full bg-white/5 border border-white/10 text-white/40 hover:text-white/80 hover:bg-white/15 transition-all cursor-pointer z-20 pointer-events-auto select-none group">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-y-0.5">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
    </div>


    @php
    $user = auth()->user();
    $roleLabel = match($user?->role) {
    'system-administrator' => 'System Admin',
    'iqa-staff', 'iqa-admin', 'iqa-member' => 'IQA Member',
    'accreditor' => 'Accreditor',
    'university-administrator' => 'BU Executive',
    'task-force-member', 'task-force' => 'Task Force Member',
    'college-head' => 'College Head',
    default => 'User'
    };
    $userAssignedRoles = $user ? $user->assignedRoles() : collect();
    @endphp

    <!-- Profile Dropdown Component matching Mockup -->
    <div class="px-5 py-5 border-t border-white/10 mt-auto">
        <flux:dropdown position="top" align="start" class="w-full">
            <button type="button" class="w-full text-left p-3 bg-white/8 hover:bg-white/15 border border-white/5 cursor-pointer rounded-xl flex items-center gap-3 transition focus:outline-none">
                @if($user?->avatar_url)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-9.5 h-9.5 rounded-full object-cover border-2 border-white shrink-0 select-none" />
                @else
                <div class="w-9.5 h-9.5 rounded-full bg-brand-orange border-2 border-white text-white font-bold flex items-center justify-center text-body-sm shrink-0 select-none">
                    {{ $user?->initials() }}
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="text-body-sm font-bold text-white truncate">{{ $user?->name }}</div>
                    <div class="text-label text-white/60 truncate flex items-center gap-1">
                        <span>{{ $roleLabel }}</span>
                        @if($userAssignedRoles->count() > 1)
                        <span class="text-label-xs bg-brand-orange px-1.5 py-0.2 rounded text-white font-bold">Multi</span>
                        @endif
                    </div>
                </div>
            </button>

            <flux:menu>
                @if($userAssignedRoles->count() > 1)
                <div class="px-2 py-1">
                    <span class="text-label font-bold uppercase tracking-wider text-zinc-400">Switch Role View</span>
                </div>
                @foreach($userAssignedRoles as $r)
                @php
                $code = $r->role_name;
                $title = match($code) {
                'system-administrator' => 'System Administrator',
                'iqa-staff', 'iqa-admin', 'iqa-member' => 'IQA Member',
                'accreditor' => 'AACCUP Accreditor',
                'university-administrator' => 'BU Executive',
                'college-head' => 'College Head (Dean)',
                'task-force-member', 'task-force' => 'Task Force Member',
                default => ucwords(str_replace('-', ' ', $code))
                };
                $isActiveRole = ($code === $user?->role);
                @endphp
                <form method="POST" action="{{ route('switch-role') }}" class="w-full">
                    @csrf
                    <input type="hidden" name="role" value="{{ $code }}" />
                    <button type="submit" class="w-full text-left px-2 py-1.5 rounded-lg flex items-center justify-between text-body-sm font-medium hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors {{ $isActiveRole ? 'text-brand-orange font-bold bg-orange-50/50' : 'text-zinc-700 dark:text-zinc-300' }}">
                        <span>{{ $title }}</span>
                        @if($isActiveRole)
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-label-xs font-bold bg-brand-orange text-white">Active</span>
                        @endif
                    </button>
                </form>
                @endforeach
                <flux:menu.separator />
                @endif

                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate class="text-xs cursor-pointer">
                    {{ __('Settings') }}
                </flux:menu.item>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer text-xs">
                        {{ __('Log out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </div>
</flux:sidebar>



<!-- Mobile User Menu -->
<flux:header class="lg:hidden bg-primary-dark! text-white border-none">
    <flux:sidebar.toggle class="lg:hidden text-white" icon="bars-2" inset="left" />
    <flux:spacer />
    <span class="text-body font-bold text-white">IQArchive</span>
    <flux:spacer />
    <!-- Simple Logout for Mobile -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-body-sm font-semibold text-zinc-300 hover:text-white p-2">Log out</button>
    </form>
</flux:header>

{{ $slot }}