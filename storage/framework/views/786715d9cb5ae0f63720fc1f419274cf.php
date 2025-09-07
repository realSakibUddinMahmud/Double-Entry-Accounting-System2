<?php $__env->startSection('title', 'Sales'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>All Sales</h4>
            <h6>Manage your Sales</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-create')): ?>
    <div class="page-btn">
        <a href="<?php echo e(route('sales.create')); ?>" class="btn btn-primary" title="Add New Sale">
            <i class="ti ti-circle-plus me-1"></i>Add Sale
        </a>
    </div>
    <?php endif; ?>
</div>
<!-- /sales list -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Search & Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('sales.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search Invoice ID</label>
                <input type="text" name="search" class="form-control" placeholder="Search by invoice ID (u_id)..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select">
                    <option value="">All Customers</option>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->id); ?>" <?php echo e(request('customer_id') == $customer->id ? 'selected' : ''); ?>>
                            <?php echo e($customer->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Store</label>
                <select name="store_id" class="form-select">
                    <option value="">All Stores</option>
                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($store->id); ?>" <?php echo e(request('store_id') == $store->id ? 'selected' : ''); ?>>
                            <?php echo e($store->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Payment Status</label>
                <select name="payment_status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Paid" <?php echo e(request('payment_status') == 'Paid' ? 'selected' : ''); ?>>Paid</option>
                    <option value="Partial" <?php echo e(request('payment_status') == 'Partial' ? 'selected' : ''); ?>>Partial</option>
                    <option value="Pending" <?php echo e(request('payment_status') == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date Range</label>
                <div class="row g-2">
                    <div class="col-6">
                        <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>" placeholder="From">
                    </div>
                    <div class="col-6">
                        <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>" placeholder="To">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-search me-1"></i>Search
                </button>
                <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-secondary">
                    <i class="ti ti-refresh me-1"></i>Clear Filters
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5 class="card-title mb-0">Sales List</h5>
        <div class="ms-auto">
            <span class="text-muted">Total: <?php echo e($sales->total()); ?> sales</span>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th>Invoice ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Store</th>
                        <th>Total Amount</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Payment Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($sale->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td><?php echo e($sale->u_id ?? $sale->id); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y')); ?></td>
                            <td><?php echo e(optional($sale->customer)->name ?? '-'); ?></td>
                            <td><?php echo e(optional($sale->store)->name ?? '-'); ?></td>
                            <td><?php echo e(number_format($sale->total_amount, 2)); ?></td>
                            <td><?php echo e(number_format($sale->paid_amount, 2)); ?></td>
                            <td><?php echo e(number_format($sale->due_amount, 2)); ?></td>
                            <td>
                                <?php if($sale->payment_status == 'Paid'): ?>
                                    <span class="badge bg-success">Paid</span>
                                <?php elseif($sale->payment_status == 'Partial'): ?>
                                    <span class="badge bg-warning">Partial</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action d-flex align-items-center">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-show')): ?>
                                    <a class="me-2 p-2"
                                       href="<?php echo e(route('sales.show', $sale->id)); ?>"
                                       title="View Invoice">
                                        <i class="ti ti-file-invoice"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="<?php echo e(route('sales.edit', $sale->id)); ?>"
                                       title="Edit Sale">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-payment-view')): ?>
                                    <a class="me-2 p-2"
                                       href="<?php echo e(route('sales.payments', $sale->id)); ?>"
                                       title="Manage Payments">
                                        <i class="ti ti-currency-dollar"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#deleteSaleModal"
                                       data-id="<?php echo e($sale->id); ?>"
                                       title="Delete Sale">
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
        
        <!-- Pagination -->
        <?php if (isset($component)) { $__componentOriginal1f9437379ffbb940ff05ba93353d3cd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.pagination','data' => ['paginator' => $sales,'infoText' => 'sales']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sales),'info-text' => 'sales']); ?>
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
<!-- /sales list -->

<?php echo $__env->make('admin.sale.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Delete Modal
    var deleteModal = document.getElementById('deleteSaleModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteSaleForm').action = "<?php echo e(url('sales')); ?>/" + id;
        });
    }
});
</script>
<?php $__env->stopPush(); ?>






<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/sale/index.blade.php ENDPATH**/ ?>