<?php $__env->startSection('title', 'Create Account'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Create Account</h4>
            <h6>Add a new account to your chart of accounts</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="<?php echo e(route('de-account.index')); ?>" class="btn btn-primary">
            <i class="ti ti-list me-1"></i>Chart of Accounts
        </a>
    </div>
</div>

<div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('de-accounting::create-account', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3261773274-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/packages/Hilinkz/DEAccounting/src/../resources/views/accounts/create.blade.php ENDPATH**/ ?>