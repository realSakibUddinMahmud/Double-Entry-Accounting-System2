<?php $__env->startSection('title', 'Add Stock Adjustment'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="page-title">
        <h4>Add Stock Adjustment</h4>
        <h6>Create a new stock adjustment entry</h6>
    </div>
    <div class="page-btn">
        <a href="<?php echo e(route('stock-adjustments.index')); ?>" class="btn btn-primary">
            <i class="ti ti-list me-1"></i> Stock Adjustment List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.stock-adjustment-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-2933886537-0', $__slots ?? [], get_defined_vars());

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
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/stock-adjustment/create.blade.php ENDPATH**/ ?>