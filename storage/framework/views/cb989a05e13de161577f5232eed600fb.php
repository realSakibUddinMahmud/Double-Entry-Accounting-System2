<?php $__env->startSection('title', 'Add Purchase'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="page-title">
        <h4>Add Purchase</h4>
        <h6>Create a new purchase</h6>
    </div>
    <div class="page-btn">
        <a href="<?php echo e(route('purchases.index')); ?>" class="btn btn-primary">
            <i class="ti ti-list me-1"></i>Purchase List
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.purchase-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-3000834422-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/purchase/create.blade.php ENDPATH**/ ?>