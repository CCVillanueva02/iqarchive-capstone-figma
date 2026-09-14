<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    <?php echo e(filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel')); ?>

</title>

<link rel="icon" href="/bulogo.png" type="image/png">
<link rel="apple-touch-icon" href="/bulogo.png">

<?php echo app('Illuminate\Foundation\Vite')->fonts(); ?>

<?php echo $__env->yieldPushContent('head_scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/partials/head.blade.php ENDPATH**/ ?>