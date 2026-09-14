<?php # [BlazeFolded]:{flux::main}:{C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\vendor\livewire\flux\src/../stubs/resources/views/flux/main.blade.php}:{1787866982} ?>
<?php # [BlazeFolded]:{flux::main}:{C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\vendor\livewire\flux\src/../stubs/resources/views/flux/main.blade.php}:{1787866982} ?>
<?php
$role = auth()->user()?->role;
$htmlClass = 'light';
$bodyClass = 'min-h-screen bg-surface-subtle antialiased text-zinc-800';
?>

<?php if (isset($component)) { $__componentOriginala7f46ca1379c3a168bff16d7bc003f1e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala7f46ca1379c3a168bff16d7bc003f1e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::html','data' => ['title' => $title ?? null,'htmlClass' => $htmlClass,'bodyClass' => $bodyClass]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::html'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? null),'html-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($htmlClass),'body-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bodyClass)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($role === 'accreditor'): ?>
        <!-- Blank layout for External Evaluator Accreditors (No Sidebar, No Header/Footer) -->
        <main class="w-full min-h-screen bg-surface-subtle">
            <?php echo e($slot); ?>

        </main>
    <?php elseif(in_array($role, ['iqa-staff', 'iqa-admin', 'system-administrator', 'university-administrator', 'task-force-member', 'college-head'])): ?>
        <?php if (isset($component)) { $__componentOriginal23399719f391f3076fe3bf0929a84741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23399719f391f3076fe3bf0929a84741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($role === 'system-administrator'): ?>
            <div class="sticky top-0 z-50 bg-emerald-600 border-b border-emerald-700 text-white text-xs font-semibold py-2 px-6 flex items-center justify-between shadow-xs select-none">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-300"></span>
                    </span>
                    <span>Logged in as <strong>System Administrator</strong> &bull; Superuser Mode</span>
                </div>
                <div class="text-label-xs bg-white/20 px-2 py-0.5 rounded font-mono uppercase tracking-wider">
                    System Admin Panel
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0" data-flux-main>
    <?php ob_start(); ?>
                <?php echo e($slot); ?>

            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23399719f391f3076fe3bf0929a84741)): ?>
<?php $attributes = $__attributesOriginal23399719f391f3076fe3bf0929a84741; ?>
<?php unset($__attributesOriginal23399719f391f3076fe3bf0929a84741); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23399719f391f3076fe3bf0929a84741)): ?>
<?php $component = $__componentOriginal23399719f391f3076fe3bf0929a84741; ?>
<?php unset($__componentOriginal23399719f391f3076fe3bf0929a84741); ?>
<?php endif; ?>

        <?php app("livewire")->forceAssetInjection(); ?><div x-persist="<?php echo e('sidebar-loader'); ?>">
            <div x-data="{
                    loading: false,
                    startTime: 0,
                    timer: null,
                    safetyTimer: null,
                    showLoader() {
                        if (this.timer) clearTimeout(this.timer);
                        if (this.safetyTimer) clearTimeout(this.safetyTimer);
                        this.startTime = Date.now();
                        this.loading = true;
                        this.safetyTimer = setTimeout(() => {
                            this.loading = false;
                        }, 3000);
                    },
                    hideLoader() {
                        if (this.safetyTimer) clearTimeout(this.safetyTimer);
                        const elapsed = Date.now() - this.startTime;
                        const remaining = Math.max(0, 400 - elapsed);
                        this.timer = setTimeout(() => {
                            this.loading = false;
                        }, remaining);
                    }
                 }"
                 x-init="
                    document.addEventListener('pointerdown', (e) => {
                        if (e.target.closest('a[wire\\:navigate]')) {
                            showLoader();
                        }
                    }, true);
                    document.addEventListener('click', (e) => {
                        if (e.target.closest('a[wire\\:navigate]')) {
                            showLoader();
                        }
                    }, true);
                    document.addEventListener('livewire:navigating', () => showLoader());
                    document.addEventListener('livewire:navigated', () => hideLoader());
                 "
                 x-show="loading"
                 x-cloak
                 x-transition:enter="transition-opacity ease-out duration-75"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-y-0 right-0 left-0 lg:left-64 z-9999 flex items-center justify-center bg-surface-subtle select-none"
                 style="display: none;">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xl flex flex-col items-center gap-4 max-w-xs w-full mx-4">
                    <!-- Animated Dual-Ring Spinner -->
                    <div class="relative w-12 h-12 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full border-3 border-slate-100"></div>
                        <div class="absolute inset-0 rounded-full border-3 border-primary-dark border-t-transparent animate-spin"></div>
                        <div class="absolute w-7 h-7 rounded-full border-2 border-brand-orange border-b-transparent animate-spin" style="animation-direction: reverse; animation-duration: 0.6s;"></div>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <span class="text-xs font-extrabold text-primary-dark tracking-wider uppercase">Loading Workspace</span>
                        <span class="text-label text-zinc-400 font-medium mt-0.5">Please wait...</span>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal6dc4121bc431495fca9ae0c45cebd96e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6dc4121bc431495fca9ae0c45cebd96e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0  min-h-[calc(100vh-64px)] flex flex-col justify-between p-0!" data-flux-main>
    <?php ob_start(); ?>
                <div class="flex-1 w-full app-layout-content">
                    <?php echo e($slot); ?>

                </div>
                <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6dc4121bc431495fca9ae0c45cebd96e)): ?>
<?php $attributes = $__attributesOriginal6dc4121bc431495fca9ae0c45cebd96e; ?>
<?php unset($__attributesOriginal6dc4121bc431495fca9ae0c45cebd96e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6dc4121bc431495fca9ae0c45cebd96e)): ?>
<?php $component = $__componentOriginal6dc4121bc431495fca9ae0c45cebd96e; ?>
<?php unset($__componentOriginal6dc4121bc431495fca9ae0c45cebd96e); ?>
<?php endif; ?>

        <style>
            /* Override child min-h-screen inside layout container to prevent layout height overflow */
            .app-layout-content > div {
                min-height: auto !important;
            }
        </style>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala7f46ca1379c3a168bff16d7bc003f1e)): ?>
<?php $attributes = $__attributesOriginala7f46ca1379c3a168bff16d7bc003f1e; ?>
<?php unset($__attributesOriginala7f46ca1379c3a168bff16d7bc003f1e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala7f46ca1379c3a168bff16d7bc003f1e)): ?>
<?php $component = $__componentOriginala7f46ca1379c3a168bff16d7bc003f1e; ?>
<?php unset($__componentOriginala7f46ca1379c3a168bff16d7bc003f1e); ?>
<?php endif; ?><?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/layouts/app.blade.php ENDPATH**/ ?>