<?php # [BlazeFolded]:{flux::sidebar.header}:{C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\vendor\livewire\flux\src/../stubs/resources/views/flux/sidebar/header.blade.php}:{1787866982} ?>
<?php # [BlazeFolded]:{flux::sidebar}:{C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\vendor\livewire\flux\src/../stubs/resources/views/flux/sidebar/index.blade.php}:{1787866982} ?>


<div class="contents">
<?php ob_start(); ?><ui-sidebar-toggle class="z-20 fixed inset-0 bg-black/10 hidden data-flux-sidebar-on-mobile:not-data-flux-sidebar-collapsed-mobile:block" data-flux-sidebar-backdrop></ui-sidebar-toggle>

<ui-sidebar
    class="[grid-area:sidebar] z-1 flex flex-col gap-4 [:where(&amp;)]:w-64 p-4 data-flux-sidebar-collapsed-desktop:w-14 data-flux-sidebar-collapsed-desktop:px-2 data-flux-sidebar-collapsed-desktop:cursor-e-resize rtl:data-flux-sidebar-collapsed-desktop:cursor-w-resize max-lg:data-flux-sidebar-cloak:hidden data-flux-sidebar-on-mobile:data-flux-sidebar-collapsed-mobile:-translate-x-full data-flux-sidebar-on-mobile:data-flux-sidebar-collapsed-mobile:rtl:translate-x-full z-20! data-flux-sidebar-on-mobile:start-0! data-flux-sidebar-on-mobile:fixed! data-flux-sidebar-on-mobile:top-0! data-flux-sidebar-on-mobile:min-h-dvh! data-flux-sidebar-on-mobile:max-h-dvh! max-h-dvh overflow-y-auto overscroll-contain border-none text-white flex flex-col gap-0 p-0! min-h-screen h-screen no-scrollbar" style="background: linear-gradient(180deg, var(--color-primary-dark) 0%, var(--color-primary-hover) 100%) !important;" x-init="$el.classList.add(&#039;transition-transform&#039;)" x-data="{
        openSections: <?php echo e(json_encode($openSections)); ?>,
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
    }"     collapsible="mobile"          sticky     x-data
    data-flux-sidebar-cloak
    data-flux-sidebar
>
    <?php ob_start(); ?>

    <!-- Brand / Institution Header -->
    <?php ob_start(); ?><div class="flex items-center justify-between gap-2 min-h-10 flex flex-col gap-3 px-5 py-6 border-b border-white/10" data-flux-sidebar-header>
    <?php ob_start(); ?>
        <div class="flex items-center justify-start gap-3 mr-auto text-left w-full">
            <img src="/bulogo.png" alt="BU Logo" class="w-10 h-10 object-contain shrink-0 select-none" />
            <div class="flex flex-col">
                <span class="block font-bold text-heading tracking-[0.5px] leading-tight text-white">IQArchive</span>
                <span class="block text-label text-white/70 font-semibold uppercase tracking-wider mt-0.5 select-none">IQA Office &bull; BU</span>
            </div>
        </div>
    <?php echo trim(ob_get_clean()); ?>

</div><?php echo ltrim(ob_get_clean()); ?>

    <!-- Scrollable Navigation Area -->
    <div class="relative flex-1 min-h-0 flex flex-col">
        <div class="flex flex-col gap-1 flex-1 py-4 overflow-y-auto no-scrollbar relative">
            <!-- 1. Everyday Workspace Navigation -->
            <?php echo $__env->make('layouts.app.sidebar.workspace-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- 2. Operations & Coordination Navigation -->
            <?php echo $__env->make('layouts.app.sidebar.operations-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- 3. Central System Administration Navigation -->
            <?php echo $__env->make('layouts.app.sidebar.administration-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <!-- User Profile & Account Footer -->
    <?php echo $__env->make('layouts.app.sidebar.profile-footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo trim(ob_get_clean()); ?>

</ui-sidebar>
<?php echo ltrim(ob_get_clean()); ?>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/livewire/sidebar.blade.php ENDPATH**/ ?>