<?php $__env->startSection('title', 'Unit'); ?>

<?php $__env->startSection('content'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-view')): ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Units</h4>
            <h6>Manage your Units</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-create')): ?>
    <div class="page-btn">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUnitModal">
            <i class="ti ti-circle-plus me-1"></i>Add Unit
        </a>
    </div>
    <?php endif; ?>
</div>
<!-- /unit list -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Search & Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('units.index')); ?>" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search Unit Name</label>
                <input type="text" name="search" class="form-control" placeholder="Search by unit name..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Parent Unit</label>
                <select name="parent_id" class="form-select">
                    <option value="">All Units</option>
                    <option value="none" <?php echo e(request('parent_id') === 'none' ? 'selected' : ''); ?>>No Parent (Base)</option>
                    <?php $__currentLoopData = $parentUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentUnit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($parentUnit->id); ?>" <?php echo e(request('parent_id') == $parentUnit->id ? 'selected' : ''); ?>>
                            <?php echo e($parentUnit->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-search me-1"></i>Search
                </button>
                <a href="<?php echo e(route('units.index')); ?>" class="btn btn-secondary">
                    <i class="ti ti-refresh me-1"></i>Clear Filters
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5 class="card-title mb-0">Unit List</h5>
        <div class="ms-auto">
            <span class="text-muted">Total: <?php echo e($units->total()); ?> units</span>
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
                        <th>Name</th>
                        <th>Symbol</th>
                        <th>Base</th>
                        <th>Conversion Factor</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($unit->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td class="text-gray-9">
                                <?php echo e($unit->name); ?>

                            </td>
                            <td>
                                <?php echo e($unit->symbol ?? '-'); ?>

                            </td>
                            <td>
                                <?php echo e(optional($unit->parent)->name ?? '-'); ?>

                            </td>
                            <td>
                                <?php echo e($unit->conversion_factor ?? '-'); ?>

                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-view')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#viewUnitModal"
                                       data-id="<?php echo e($unit->id); ?>"
                                       data-name="<?php echo e($unit->name); ?>"
                                       data-symbol="<?php echo e($unit->symbol); ?>"
                                       data-parent_id="<?php echo e($unit->parent_id); ?>"
                                       data-parent="<?php echo e(optional($unit->parent)->name); ?>"
                                       data-conversion_factor="<?php echo e($unit->conversion_factor); ?>"
                                       data-created_at="<?php echo e($unit->created_at); ?>"
                                       title="View Unit">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#editUnitModal"
                                       data-id="<?php echo e($unit->id); ?>"
                                       data-name="<?php echo e($unit->name); ?>"
                                       data-symbol="<?php echo e($unit->symbol); ?>"
                                       data-parent_id="<?php echo e($unit->parent_id); ?>"
                                       data-conversion_factor="<?php echo e($unit->conversion_factor); ?>"
                                       title="Edit Unit">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#deleteUnitModal"
                                       data-id="<?php echo e($unit->id); ?>"
                                       title="Delete Unit">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.pagination','data' => ['paginator' => $units,'infoText' => 'units']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($units),'info-text' => 'units']); ?>
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
<!-- /unit list -->

<!-- Include Modals Based on Permissions -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-create')): ?>
<?php echo $__env->make('admin.unit.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-edit')): ?>
<?php echo $__env->make('admin.unit.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-delete')): ?>
<?php echo $__env->make('admin.unit.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-view')): ?>
<?php echo $__env->make('admin.unit.view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php else: ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Access Denied</h4>
            <p>You don't have permission to view units.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal
    var editModal = document.getElementById('editUnitModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var symbol = button.getAttribute('data-symbol');
            var parent_id = button.getAttribute('data-parent_id');
            var conversion_factor = button.getAttribute('data-conversion_factor');

            document.getElementById('editUnitForm').action = "<?php echo e(url('units')); ?>/" + id;
            document.getElementById('edit_unit_name').value = name;
            document.getElementById('edit_unit_symbol').value = symbol;
            document.getElementById('edit_unit_parent_id').value = parent_id;
            document.getElementById('edit_unit_conversion_factor').value = conversion_factor;
        });
    }

    // Delete Modal
    var deleteModal = document.getElementById('deleteUnitModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteUnitForm').action = "<?php echo e(url('units')); ?>/" + id;
        });
    }

    // View Modal
    var viewModal = document.getElementById('viewUnitModal');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            document.getElementById('view_unit_name').textContent = button.getAttribute('data-name');
            document.getElementById('view_unit_symbol').textContent = button.getAttribute('data-symbol');
            document.getElementById('view_unit_parent').textContent = button.getAttribute('data-parent');
            document.getElementById('view_unit_conversion_factor').textContent = button.getAttribute('data-conversion_factor');
            document.getElementById('view_unit_created_at').textContent = button.getAttribute('data-created_at');
        });
    }
});
</script>






<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/unit/index.blade.php ENDPATH**/ ?>