<?php $__env->startSection('title', 'Expenses'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Expenses</h4>
            <h6>Manage your expense records</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="<?php echo e(route('de-expense.create')); ?>" class="btn btn-primary">
            <i class="ti ti-circle-plus me-1"></i> New Expense
        </a>
    </div>
</div>

<div class="card card-body">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('de-accounting::journal-search-component');

$__html = app('livewire')->mount($__name, $__params, 'lw-2034825712-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5 class="card-title mb-0">Expense List</h5>
        <div class="ms-auto">
            <span class="text-muted">Total: <?php echo e($journals->total()); ?> expenses</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th class="text-center">Date</th>
                        <th class="text-left">Expense of</th>
                        <th class="text-left">Source Account</th>
                        <th class="text-left">Purpose</th>
                        <th class="text-left">Note</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($journals->firstItem() + $index); ?></td>
                            <td class="text-center"><?php echo e(date('d/m/Y', strtotime($journal->date))); ?></td>
                            <td class="text-left">
                                <?php echo e(class_basename($journal->journalable_alias)); ?> -
                                <?php echo e($journal->journalable->name ?? ($journal->journalable->title ?? 'N/A')); ?>

                            </td>
                            <td class="text-left">
                                Title: <?php echo e($journal->creditTransaction->account->title ?? 'N/A'); ?><br>
                                <?php if(!empty($journal->creditTransaction->account->account_no)): ?>
                                    No: <?php echo e($journal->creditTransaction->account->account_no); ?><br>
                                <?php endif; ?>
                                   
                            </td>
                            <td class="text-left">
                                Title: <?php echo e($journal->debitTransaction->account->title ?? 'N/A'); ?><br>
                                <?php if(!empty($journal->debitTransaction->account->account_no)): ?>
                                    No: <?php echo e($journal->debitTransaction->account->account_no); ?><br>
                                <?php endif; ?>
                                
                            </td>
                            <td class="text-left"><?php echo e($journal->note ?? null); ?></td>
                            <td class="text-right"><?php echo e($journal->amount); ?></td>
                            <td class="text-right">
                                <?php if($journal->files && $journal->files->count() > 0): ?>
                                    <button type="button" class="btn btn-sm btn-fa-paperclip"
                                        data-bs-toggle="modal"
                                        data-bs-target="#filesModal<?php echo e($journal->id); ?>">
                                        <i class="fas fa-paperclip text-success" aria-hidden="true"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-expense-delete')): ?>
                                    <button type="button" class="btn btn-sm btn-far-fa-trash-alt"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                        data-id="<?php echo e($journal->id); ?>">
                                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if (isset($component)) { $__componentOriginal1f9437379ffbb940ff05ba93353d3cd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.pagination','data' => ['paginator' => $journals,'infoText' => 'expenses']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($journals),'info-text' => 'expenses']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5)): ?>
<?php $attributes = $__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5; ?>
<?php unset($__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f9437379ffbb940ff05ba93353d3cd5)): ?>
<?php $component = $__componentOriginal1f9437379ffbb940ff05ba93353d3cd5; ?>
<?php unset($__componentOriginal1f9437379ffbb940ff05ba93353d3cd5); ?>
<?php endif; ?>
    </div>
</div>

<?php echo $__env->make('de-accounting::expenses.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('de-accounting::expenses.files-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/packages/Hilinkz/DEAccounting/src/../resources/views/expenses/index.blade.php ENDPATH**/ ?>