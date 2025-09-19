<?php $__env->startSection('title', 'Customers'); ?>

<?php $__env->startSection('content'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-view')): ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Customers</h4>
            <h6>Manage your Customers</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-create')): ?>
    <div class="page-btn">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-customer">
            <i class="ti ti-circle-plus me-1"></i>Add Customer
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- /customer list -->
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
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($customer->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td><?php echo e($customer->name); ?></td>
                            <td><?php echo e($customer->phone); ?></td>
                            <td><?php echo e($customer->email); ?></td>
                            <td><?php echo e(number_format($customer->total_paid, 2)); ?></td>
                            <td><?php echo e(number_format($customer->total_due, 2)); ?></td>
                            <td>
                                <?php if($customer->status == false): ?>
                                    <span class="badge bg-secondary">Archived</span>
                                <?php elseif($customer->status == true): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark">Unknown</span>
                                <?php endif; ?>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-show')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#view-customer"
                                       data-id="<?php echo e($customer->id); ?>"
                                       data-name="<?php echo e($customer->name); ?>"
                                       data-phone="<?php echo e($customer->phone); ?>"
                                       data-email="<?php echo e($customer->email); ?>"
                                       data-address="<?php echo e($customer->address); ?>"
                                       data-status="<?php echo e($customer->status); ?>"
                                       title="View Customer">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#edit-customer"
                                       data-id="<?php echo e($customer->id); ?>"
                                       data-name="<?php echo e($customer->name); ?>"
                                       data-phone="<?php echo e($customer->phone); ?>"
                                       data-email="<?php echo e($customer->email); ?>"
                                       data-address="<?php echo e($customer->address); ?>"
                                       title="Edit Customer">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#delete-modal"
                                       data-id="<?php echo e($customer->id); ?>"
                                       title="Delete Customer">
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
<!-- /customer list -->

<!-- Include Modals Based on Permissions -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-create')): ?>
<?php echo $__env->make('admin.customers.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-edit')): ?>
<?php echo $__env->make('admin.customers.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-delete')): ?>
<?php echo $__env->make('admin.customers.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-show')): ?>
<?php echo $__env->make('admin.customers.view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php else: ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Access Denied</h4>
            <p>You don't have permission to view customers.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal
    var editModal = document.getElementById('edit-customer');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var phone = button.getAttribute('data-phone');
            var email = button.getAttribute('data-email');
            var address = button.getAttribute('data-address');

            document.getElementById('editCustomerForm').action = "<?php echo e(url('customers')); ?>/" + id;

            document.getElementById('edit_customer_name').value = name;
            document.getElementById('edit_customer_phone').value = phone;
            document.getElementById('edit_customer_email').value = email;
            document.getElementById('edit_customer_address').value = address;
        });
    }

    // Delete Modal
    var deleteModal = document.getElementById('delete-modal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteCustomerForm').action = "<?php echo e(url('customers')); ?>/" + id;
        });
    }

    // View Modal
    var viewModal = document.getElementById('view-customer');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            
            document.getElementById('view_customer_name').textContent = button.getAttribute('data-name');
            document.getElementById('view_customer_phone').textContent = button.getAttribute('data-phone');
            document.getElementById('view_customer_email').textContent = button.getAttribute('data-email');
            document.getElementById('view_customer_address').textContent = button.getAttribute('data-address');
        });
    }
});
</script>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/customers/index.blade.php ENDPATH**/ ?>