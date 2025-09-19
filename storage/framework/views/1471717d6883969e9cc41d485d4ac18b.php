<?php $__env->startSection('title', 'Store'); ?>

<?php $__env->startSection('content'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-view')): ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Stores</h4>
            <h6>Manage your Store</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-create')): ?>
    <div class="page-btn">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-store">
            <i class="ti ti-circle-plus me-1"></i>Add Store
        </a>
    </div>
    <?php endif; ?>
</div>
<!-- /product list -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="search-set">
            <div class="search-input">
                <span class="btn-searchset">
                    <i class="ti ti-search fs-14 feather-search"></i>
                </span>
            </div>
        </div>
        <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
            <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
                    Status
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Active</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Inactive</a>
                    </li>
                </ul>
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
                        <th>Store</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($store->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td class="text-gray-9"><?php echo e($store->name); ?></td>
                            <td><?php echo e($store->address); ?></td>
                            <td><?php echo e($store->contact_no); ?></td>
                            <td>
                                <?php if($store->status): ?>
                                    <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                        <i class="ti ti-point-filled me-1"></i>Active
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                        <i class="ti ti-point-filled me-1"></i>Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-view')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#view-store"
                                       data-id="<?php echo e($store->id); ?>"
                                       data-name="<?php echo e($store->name); ?>"
                                       data-address="<?php echo e($store->address); ?>"
                                       data-contact_no="<?php echo e($store->contact_no); ?>"
                                       data-status="<?php echo e($store->status ? 'Active' : 'Inactive'); ?>"
                                       title="View Store">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#edit-store"
                                       data-id="<?php echo e($store->id); ?>"
                                       data-name="<?php echo e($store->name); ?>"
                                       data-address="<?php echo e($store->address); ?>"
                                       data-contact_no="<?php echo e($store->contact_no); ?>"
                                       data-status="<?php echo e($store->status ? 1 : 0); ?>"
                                       title="Edit Store">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#delete-modal"
                                       data-id="<?php echo e($store->id); ?>"
                                       title="Delete Store">
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
<!-- /product list -->

<!-- Include Modals Based on Permissions -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-create')): ?>
<?php echo $__env->make('admin.store.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-edit')): ?>
<?php echo $__env->make('admin.store.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-delete')): ?>
<?php echo $__env->make('admin.store.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-view')): ?>
<?php echo $__env->make('admin.store.view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php else: ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Access Denied</h4>
            <p>You don't have permission to view stores.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal
    var editModal = document.getElementById('edit-store');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var address = button.getAttribute('data-address');
            var contact_no = button.getAttribute('data-contact_no');
            var status = button.getAttribute('data-status');

            // Set the form action URL with the correct store ID
            document.getElementById('editStoreForm').action = "<?php echo e(url('stores')); ?>/" + id;

            document.getElementById('edit_store_name').value = name;
            document.getElementById('edit_store_address').value = address;
            document.getElementById('edit_store_contact_no').value = contact_no;
            document.getElementById('edit_store_status').checked = status == 1;
        });
    }

    // Delete Modal
    var deleteModal = document.getElementById('delete-modal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            // Set the form action URL with the correct store ID
            document.getElementById('deleteStoreForm').action = "<?php echo e(url('stores')); ?>/" + id;
        });
    }

    // View Modal
    var viewModal = document.getElementById('view-store');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            document.getElementById('view_store_name').textContent = button.getAttribute('data-name');
            document.getElementById('view_store_address').textContent = button.getAttribute('data-address');
            document.getElementById('view_store_contact_no').textContent = button.getAttribute('data-contact_no');
            document.getElementById('view_store_status').textContent = button.getAttribute('data-status');
        });
    }

    // Status Filter
    document.querySelectorAll('.dropdown-item.rounded-1').forEach(function(item) {
        item.addEventListener('click', function() {
            var filter = this.textContent.trim();
            document.querySelectorAll('tbody tr').forEach(function(row) {
                var statusCell = row.querySelector('td span.badge');
                if (!statusCell) return;
                var isActive = statusCell.textContent.trim() === 'Active';
                if (filter === 'Active' && !isActive) {
                    row.style.display = 'none';
                } else if (filter === 'Inactive' && isActive) {
                    row.style.display = 'none';
                } else {
                    row.style.display = '';
                }
            });
        });
    });
});
</script>

<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/store/index.blade.php ENDPATH**/ ?>