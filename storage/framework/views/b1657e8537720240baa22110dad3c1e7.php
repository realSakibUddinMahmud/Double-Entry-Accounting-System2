<?php $__env->startSection('title', 'Stock Adjustments'); ?>

<?php $__env->startSection('content'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-view')): ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>All Stock Adjustments</h4>
            <h6>Manage your Stock Adjustments</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-create')): ?>
    <div class="page-btn">
        <a href="<?php echo e(route('stock-adjustments.create')); ?>" class="btn btn-primary">
            <i class="ti ti-circle-plus me-1"></i>Add Stock Adjustment
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- /stock adjustment list -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="ms-auto search-set">
            <div class="search-input">
                <span class="btn-searchset">
                    <i class="ti ti-search fs-14 feather-search"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table datatable table-sm">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th>Date</th>
                        <th>Store</th>
                        <th>Note</th>
                        <th>User</th>
                        <th>Adjusted At</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $stockAdjustments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adjustment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($adjustment->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($adjustment->date)->format('d/m/Y')); ?></td>
                            <td><?php echo e(optional($adjustment->store)->name ?? '-'); ?></td>
                            <td><?php echo e($adjustment->note); ?></td>
                            <td><?php echo e(optional($adjustment->user)->name ?? '-'); ?></td>
                            <td><?php echo e($adjustment->created_at->format('d/m/Y H:i')); ?></td>
                            <td class="action-table-data">
                                <div class="edit-delete-action d-flex align-items-center">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-show')): ?>
                                    <a class="me-2 p-2"
                                       href="<?php echo e(route('stock-adjustments.show', $adjustment->id)); ?>"
                                       title="View Adjustment">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="<?php echo e(route('stock-adjustments.edit', $adjustment->id)); ?>"
                                       title="Edit">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#deleteStockAdjustmentModal"
                                       data-id="<?php echo e($adjustment->id); ?>"
                                       title="Delete">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /stock adjustment list -->

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-delete')): ?>
<?php echo $__env->make('admin.stock-adjustment.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php else: ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Access Denied</h4>
            <p>You don't have permission to view stock adjustments.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Delete Modal
    var deleteModal = document.getElementById('deleteStockAdjustmentModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteStockAdjustmentForm').action = "<?php echo e(url('stock-adjustments')); ?>/" + id;
        });
    }
});
</script>
<?php $__env->stopPush(); ?>






<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/stock-adjustment/index.blade.php ENDPATH**/ ?>