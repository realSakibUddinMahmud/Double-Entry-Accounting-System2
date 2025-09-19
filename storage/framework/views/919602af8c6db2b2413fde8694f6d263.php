<?php $__env->startSection('title', 'Suppliers'); ?>

<?php $__env->startSection('content'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-view')): ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Suppliers</h4>
            <h6>Manage your Suppliers</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-create')): ?>
    <div class="page-btn">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-supplier">
            <i class="ti ti-circle-plus me-1"></i>Add Supplier
        </a>
    </div>
    <?php endif; ?>
</div>
<!-- /supplier list -->
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
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($supplier->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td><?php echo e($supplier->name); ?></td>
                            <td><?php echo e($supplier->contact_person); ?></td>
                            <td><?php echo e($supplier->phone); ?></td>
                            <td><?php echo e($supplier->email); ?></td>
                            <td><?php echo e(number_format($supplier->total_paid, 2)); ?></td>
                            <td><?php echo e(number_format($supplier->total_due, 2)); ?></td>
                            <td>
                                <?php if($supplier->status == 'Archived' || $supplier->status == false): ?>
                                    <span class="badge bg-secondary">Archived</span>
                                <?php elseif($supplier->status == 'Active' || $supplier->status == true): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark">Unknown</span>
                                <?php endif; ?>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-show')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#view-supplier"
                                       data-id="<?php echo e($supplier->id); ?>"
                                       data-name="<?php echo e($supplier->name); ?>"
                                       data-contact_person="<?php echo e($supplier->contact_person); ?>"
                                       data-phone="<?php echo e($supplier->phone); ?>"
                                       data-email="<?php echo e($supplier->email); ?>"
                                       data-address="<?php echo e($supplier->address); ?>"
                                       data-status="<?php echo e($supplier->status); ?>"
                                       title="View Supplier">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#edit-supplier"
                                       data-id="<?php echo e($supplier->id); ?>"
                                       data-name="<?php echo e($supplier->name); ?>"
                                       data-contact_person="<?php echo e($supplier->contact_person); ?>"
                                       data-phone="<?php echo e($supplier->phone); ?>"
                                       data-email="<?php echo e($supplier->email); ?>"
                                       data-address="<?php echo e($supplier->address); ?>"
                                       title="Edit Supplier">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#delete-modal"
                                       data-id="<?php echo e($supplier->id); ?>"
                                       title="Delete Supplier">
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
<!-- /supplier list -->

<!-- Include Modals Based on Permissions -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-create')): ?>
<?php echo $__env->make('admin.suppliers.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-edit')): ?>
<?php echo $__env->make('admin.suppliers.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-delete')): ?>
<?php echo $__env->make('admin.suppliers.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-show')): ?>
<?php echo $__env->make('admin.suppliers.view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php else: ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Access Denied</h4>
            <p>You don't have permission to view suppliers.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal
    var editModal = document.getElementById('edit-supplier');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var contact_person = button.getAttribute('data-contact_person');
            var phone = button.getAttribute('data-phone');
            var email = button.getAttribute('data-email');
            var address = button.getAttribute('data-address');

            document.getElementById('editSupplierForm').action = "<?php echo e(url('suppliers')); ?>/" + id;

            document.getElementById('edit_supplier_name').value = name;
            document.getElementById('edit_supplier_contact_person').value = contact_person;
            document.getElementById('edit_supplier_phone').value = phone;
            document.getElementById('edit_supplier_email').value = email;
            document.getElementById('edit_supplier_address').value = address;
        });
    }

    // Delete Modal
    var deleteModal = document.getElementById('delete-modal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteSupplierForm').action = "<?php echo e(url('suppliers')); ?>/" + id;
        });
    }

    // View Modal
    var viewModal = document.getElementById('view-supplier');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            
            document.getElementById('view_supplier_name').textContent = button.getAttribute('data-name');
            document.getElementById('view_supplier_contact_person').textContent = button.getAttribute('data-contact_person');
            document.getElementById('view_supplier_phone').textContent = button.getAttribute('data-phone');
            document.getElementById('view_supplier_email').textContent = button.getAttribute('data-email');
            document.getElementById('view_supplier_address').textContent = button.getAttribute('data-address');
            document.getElementById('view_supplier_status').innerHTML =
        button.getAttribute('data-status') == 'Archived' || button.getAttribute('data-status') == '0'
            ? '<span class="badge bg-secondary">Archived</span>'
            : '<span class="badge bg-success">Active</span>';
        });
    }
});
</script>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/suppliers/index.blade.php ENDPATH**/ ?>