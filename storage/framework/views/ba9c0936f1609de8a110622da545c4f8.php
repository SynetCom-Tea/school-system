<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('enseignement.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('enseignement::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MAHAMADOU\OneDrive\Documents\projet_synetcom\system_1\school\school-system\Modules\Enseignement\Resources\views\index.blade.php ENDPATH**/ ?>