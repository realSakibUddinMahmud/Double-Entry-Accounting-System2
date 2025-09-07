<?php $__env->startSection('title', 'Add Sale'); ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-create')): ?>
    <?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div class="page-title">
            <h4>Add Sale</h4>
            <h6>Create a new sale</h6>
        </div>
        <div class="page-btn">
            <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-primary">
                <i class="ti ti-list me-1"></i>Sales List
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.sale-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-4016789324-0', $__slots ?? [], get_defined_vars());

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
<?php else: ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="page-title">
        <h4>Access Denied</h4>
        <h6>You don't have permission to create sales</h6>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/sale/create.blade.php ENDPATH**/ ?>