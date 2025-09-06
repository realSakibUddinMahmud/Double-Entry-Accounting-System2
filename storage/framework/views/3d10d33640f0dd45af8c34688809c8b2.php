<?php $__env->startSection('title', 'Brand'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Brands</h4>
            <h6>Manage your Brand</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-create')): ?>
    <div class="page-btn">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-brand">
            <i class="ti ti-circle-plus me-1"></i>Add Brand
        </a>
    </div>
    <?php endif; ?>
</div>
<!-- /brand list -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Search & Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('brands.index')); ?>" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Search Brand Name</label>
                <input type="text" name="search" class="form-control" placeholder="Search by brand name..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-search me-1"></i>Search
                </button>
                <a href="<?php echo e(route('brands.index')); ?>" class="btn btn-secondary">
                    <i class="ti ti-refresh me-1"></i>Clear Filters
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5 class="card-title mb-0">Brand List</h5>
        <div class="ms-auto">
            <span class="text-muted">Total: <?php echo e($brands->total()); ?> brands</span>
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
                        <th>Logo</th>
                        <th>Brand</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($brand->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td>
                                <?php if($brand->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . $brand->logo)); ?>" alt="Logo" style="height:32px; width:32px; object-fit:cover; border-radius:50%;">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('admin/no-image.png')); ?>" alt="No Image" style="height:32px; width:32px; object-fit:cover; border-radius:50%;">
                                <?php endif; ?>
                            </td>
                            <td class="text-gray-9"><?php echo e($brand->name); ?></td>
                            <td><?php echo e($brand->slug); ?></td>
                            <td><?php echo e($brand->description); ?></td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-view')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#view-brand"
                                       data-id="<?php echo e($brand->id); ?>"
                                       data-name="<?php echo e($brand->name); ?>"
                                       data-slug="<?php echo e($brand->slug); ?>"
                                       data-logo="<?php echo e($brand->logo); ?>"
                                       data-description="<?php echo e($brand->description); ?>">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#edit-brand"
                                       data-id="<?php echo e($brand->id); ?>"
                                       data-name="<?php echo e($brand->name); ?>"
                                       data-slug="<?php echo e($brand->slug); ?>"
                                       data-logo="<?php echo e($brand->logo); ?>"
                                       data-description="<?php echo e($brand->description); ?>">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#delete-modal"
                                       data-id="<?php echo e($brand->id); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.pagination','data' => ['paginator' => $brands,'infoText' => 'brands']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($brands),'info-text' => 'brands']); ?>
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
<!-- /brand list -->

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-create')): ?>
<?php echo $__env->make('admin.brand.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-edit')): ?>
<?php echo $__env->make('admin.brand.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-delete')): ?>
<?php echo $__env->make('admin.brand.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-view')): ?>
<?php echo $__env->make('admin.brand.view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal
    var editModal = document.getElementById('edit-brand');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var slug = button.getAttribute('data-slug');
            var logo = button.getAttribute('data-logo');
            var description = button.getAttribute('data-description');
            var status = button.getAttribute('data-status');

            document.getElementById('editBrandForm').action = "<?php echo e(url('brands')); ?>/" + id;

            document.getElementById('edit_brand_name').value = name;
            document.getElementById('edit_brand_slug').value = slug;
            document.getElementById('edit_brand_logo').value = logo;
            document.getElementById('edit_brand_description').value = description;
            document.getElementById('edit_brand_status').checked = status == 1;
        });
    }

    // Delete Modal
    var deleteModal = document.getElementById('delete-modal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteBrandForm').action = "<?php echo e(url('brands')); ?>/" + id;
        });
    }

    // View Modal
    var viewModal = document.getElementById('view-brand');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var logo = button.getAttribute('data-logo');
            var logoImg = document.getElementById('view_brand_logo');
            var logoLog = document.getElementById('view_brand_logo_log');
            if (logo) {
                logoImg.src = "<?php echo e(asset('storage')); ?>/" + logo;
                logoLog.style.display = "none";
            } else {
                logoImg.src = "<?php echo e(asset('admin/no-image.png')); ?>";
                logoLog.textContent = "No logo available for this brand.";
                logoLog.style.display = "block";
            }
            document.getElementById('view_brand_name').textContent = button.getAttribute('data-name');
            document.getElementById('view_brand_slug').textContent = button.getAttribute('data-slug');
            document.getElementById('view_brand_description').textContent = button.getAttribute('data-description');
            document.getElementById('view_brand_status').textContent = button.getAttribute('data-status');
        });
    }

    // Status Filter
    document.querySelectorAll('.dropdown-item.rounded-1').forEach(function(item) {
        item.addEventListener('click', function() {
            var filter = this.textContent.trim();
            document.querySelectorAll('tbody tr').forEach(function(row) {
                var statusCell = row.querySelector('td span.badge');
                if (!statusCell) {
                    row.style.display = '';
                    return;
                }
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






<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/brand/index.blade.php ENDPATH**/ ?>