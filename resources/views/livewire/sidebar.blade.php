{{--
    IQArchive Navigation: Persistent Livewire Sidebar View
    Houses the desktop workstation sidebar navigation shell with reactive SPA state.
    Binds section toggles to backend session persistence via $wire.toggleSection(),
    and reactively syncs route highlighting on livewire:navigated without DOM re-render.
--}}

<div class="contents">
<flux:sidebar
    x-data="{
        openSections: {{ json_encode($openSections) }},
        currentPath: window.location.pathname,
        currentSearch: window.location.search,
        init() {
            document.addEventListener('livewire:navigated', () => {
                this.currentPath = window.location.pathname;
                this.currentSearch = window.location.search;
            });
        },
        isOpen(section) {
            return this.openSections.includes(section);
        },
        toggle(section) {
            if (this.isOpen(section)) {
                this.openSections = this.openSections.filter(s => s !== section);
            } else {
                this.openSections.push(section);
            }
            $wire.toggleSection(section);
        },
        isRoute(path) {
            return this.currentPath === path || this.currentPath.startsWith(path + '/');
        },
        isDocTab(tab) {
            if (!this.currentPath.includes('/documents')) return false;
            if (tab === 'common-documents') {
                return this.currentSearch.includes('tab=common-documents') || !this.currentSearch.includes('tab=');
            }
            return this.currentSearch.includes('tab=' + tab);
        },
        isMonTab(tab) {
            if (!this.currentPath.includes('/monitoring')) return false;
            if (tab === 'dashboard') {
                return this.currentSearch.includes('tab=dashboard') || !this.currentSearch.includes('tab=');
            }
            return this.currentSearch.includes('tab=' + tab);
        }
    }"
    sticky
    collapsible="mobile"
    class="border-none text-white flex flex-col gap-0 p-0! min-h-screen h-screen no-scrollbar"
    style="background: linear-gradient(180deg, var(--color-primary-dark) 0%, var(--color-primary-hover) 100%) !important;">

    <!-- Brand / Institution Header -->
    <flux:sidebar.header class="flex flex-col gap-3 px-5 py-6 border-b border-white/10">
        <div class="flex items-center justify-start gap-3 mr-auto text-left w-full">
            <img src="/bulogo.png" alt="BU Logo" class="w-10 h-10 object-contain shrink-0 select-none" />
            <div class="flex flex-col">
                <span class="block font-bold text-heading tracking-[0.5px] leading-tight text-white">IQArchive</span>
                <span class="block text-label text-white/70 font-semibold uppercase tracking-wider mt-0.5 select-none">IQA Office &bull; BU</span>
            </div>
        </div>
    </flux:sidebar.header>

    <!-- Scrollable Navigation Area -->
    <div class="relative flex-1 min-h-0 flex flex-col">
        <div class="flex flex-col gap-1 flex-1 py-4 overflow-y-auto no-scrollbar relative">
            <!-- 1. Everyday Workspace Navigation -->
            @include('layouts.app.sidebar.workspace-nav')

            <!-- 2. Operations & Coordination Navigation -->
            @include('layouts.app.sidebar.operations-nav')

            <!-- 3. Central System Administration Navigation -->
            @include('layouts.app.sidebar.administration-nav')
        </div>
    </div>

    <!-- User Profile & Account Footer -->
    @include('layouts.app.sidebar.profile-footer')
</flux:sidebar>
</div>
