<?php $__env->startSection('title', 'Tax'); ?>

<?php $__env->startSection('content'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-view')): ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Taxes</h4>
            <h6>Manage your Taxes</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-create')): ?>
    <div class="page-btn">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-tax">
            <i class="ti ti-circle-plus me-1"></i>Add Tax
        </a>
    </div>
    <?php endif; ?>
</div>
<!-- /tax list -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="search-set">
            <div class="search-input">
                <span class="btn-searchset">
                    <i class="ti ti-search fs-14 feather-search"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table datatable">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th>Name</th>
                        <th>Rate (%)</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($tax->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td class="text-gray-9"><?php echo e($tax->name); ?></td>
                            <td><?php echo e($tax->rate); ?></td>
                            <td>
                                <?php if($tax->status): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-view')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#view-tax"
                                       data-id="<?php echo e($tax->id); ?>"
                                       data-name="<?php echo e($tax->name); ?>"
                                       data-rate="<?php echo e($tax->rate); ?>"
                                       data-status="<?php echo e($tax->status); ?>"
                                       title="View Tax">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#edit-tax"
                                       data-id="<?php echo e($tax->id); ?>"
                                       data-name="<?php echo e($tax->name); ?>"
                                       data-rate="<?php echo e($tax->rate); ?>"
                                       data-status="<?php echo e($tax->status); ?>"
                                       title="Edit Tax">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#delete-tax"
                                       data-id="<?php echo e($tax->id); ?>"
                                       title="Delete Tax">
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
<!-- /tax list -->

<!-- Include Modals Based on Permissions -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-create')): ?>
<?php echo $__env->make('admin.tax.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-edit')): ?>
<?php echo $__env->make('admin.tax.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-delete')): ?>
<?php echo $__env->make('admin.tax.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-view')): ?>
<?php echo $__env->make('admin.tax.view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php else: ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Access Denied</h4>
            <p>You don't have permission to view taxes.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal
    var editModal = document.getElementById('edit-tax');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var rate = button.getAttribute('data-rate');
            var status = button.getAttribute('data-status');

            document.getElementById('editTaxForm').action = "<?php echo e(url('taxes')); ?>/" + id;
            document.getElementById('edit_tax_name').value = name;
            document.getElementById('edit_tax_rate').value = rate;
            document.getElementById('edit_tax_status').value = status;
        });
    }

    // Delete Modal
    var deleteModal = document.getElementById('delete-tax');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteTaxForm').action = "<?php echo e(url('taxes')); ?>/" + id;
        });
    }

    // View Modal
    var viewModal = document.getElementById('view-tax');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            document.getElementById('view_tax_name').textContent = button.getAttribute('data-name');
            document.getElementById('view_tax_rate').textContent = button.getAttribute('data-rate');
            document.getElementById('view_tax_status').textContent = button.getAttribute('data-status') == 1 ? 'Active' : 'Inactive';
        });
    }
});
</script>






<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/tax/index.blade.php ENDPATH**/ ?>