<?php # [BlazeFolded]:{flux::sidebar.toggle}:{C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\vendor\livewire\flux\src/../stubs/resources/views/flux/sidebar/toggle.blade.php}:{1787866982} ?>
<?php # [BlazeFolded]:{flux::spacer}:{C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\vendor\livewire\flux\src/../stubs/resources/views/flux/spacer.blade.php}:{1787866982} ?>
<?php # [BlazeFolded]:{flux::spacer}:{C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\vendor\livewire\flux\src/../stubs/resources/views/flux/spacer.blade.php}:{1787866982} ?>
<?php # [BlazeFolded]:{flux::header}:{C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\vendor\livewire\flux\src/../stubs/resources/views/flux/header.blade.php}:{1787866980} ?>


<?php app("livewire")->forceAssetInjection(); ?><div x-persist="<?php echo e('sidebar'); ?>">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('sidebar', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3593531032-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
</div>

<!-- Mobile Navigation Header -->
<?php ob_start(); ?><header class="[grid-area:header] z-10 min-h-14 flex items-center px-6 lg:px-8 lg:hidden bg-primary-dark! text-white border-none" data-flux-header>
            <?php ob_start(); ?>
    <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg w-10 inline-flex -ms-2.5 bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white      shrink-0 lg:hidden text-white" data-flux-button="data-flux-button" x-data="" x-on:click="$dispatch('flux-sidebar-toggle')" aria-label="Toggle sidebar" data-flux-sidebar-toggle="data-flux-sidebar-toggle">
        <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 6.75A.75.75 0 0 1 2.75 6h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 6.75Zm0 6.5a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
</svg>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
    <?php ob_start(); ?><div class="flex-1" data-flux-spacer></div>
<?php echo ltrim(ob_get_clean()); ?>
    <span class="text-body font-bold text-white">IQArchive</span>
    <?php ob_start(); ?><div class="flex-1" data-flux-spacer></div>
<?php echo ltrim(ob_get_clean()); ?>
    <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="text-body-sm font-semibold text-zinc-300 hover:text-white p-2">Log out</button>
    </form>
<?php echo trim(ob_get_clean()); ?>

    </header>
<?php echo ltrim(ob_get_clean()); ?>

<?php echo e($slot); ?><?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/layouts/app/sidebar.blade.php ENDPATH**/ ?>