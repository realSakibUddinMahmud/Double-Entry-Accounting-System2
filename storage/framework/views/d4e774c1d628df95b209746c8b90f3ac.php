<?php $__env->startSection('title', 'New Expenses'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>New Expense</h4>
            <h6>Record new expense transaction</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="<?php echo e(route('de-expense.index')); ?>" class="btn btn-primary">
            <i class="ti ti-list me-1"></i>List of Expenses
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('de-accounting::new-expense');

$__html = app('livewire')->mount($__name, $__params, 'lw-2870266584-0', $__slots ?? [], get_defined_vars());

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
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/packages/Hilinkz/DEAccounting/src/../resources/views/expenses/create.blade.php ENDPATH**/ ?>