<?php $__env->startSection('title', 'Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Categories</h4>
            <h6>Manage your Categories</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-create')): ?>
    <div class="page-btn">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category">
            <i class="ti ti-circle-plus me-1"></i>Add Category
        </a>
    </div>
    <?php endif; ?>
</div>
<!-- /category list -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Search & Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('categories.index')); ?>" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search Category Name</label>
                <input type="text" name="search" class="form-control" placeholder="Search by category name..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-select">
                    <option value="">All Categories</option>
                    <option value="none" <?php echo e(request('parent_id') === 'none' ? 'selected' : ''); ?>>No Parent (Root)</option>
                    <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($parentCategory->id); ?>" <?php echo e(request('parent_id') == $parentCategory->id ? 'selected' : ''); ?>>
                            <?php echo e($parentCategory->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-search me-1"></i>Search
                </button>
                <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-secondary">
                    <i class="ti ti-refresh me-1"></i>Clear Filters
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5 class="card-title mb-0">Category List</h5>
        <div class="ms-auto">
            <span class="text-muted">Total: <?php echo e($categories->total()); ?> categories</span>
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
                        <th>Category</th>
                        <th>Parent</th>
                        <th>Created At</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($category->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td class="text-gray-9">
                                <?php echo e($category->name); ?>

                            </td>
                            <td>
                                <?php echo e(optional($category->parent)->name ?? '-'); ?>

                            </td>
                            <td>
                                <?php echo e($category->created_at ? $category->created_at->format('d-m-Y') : '-'); ?>

                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-view')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#view-category"
                                       data-id="<?php echo e($category->id); ?>"
                                       data-name="<?php echo e($category->name); ?>"
                                       data-parent_id="<?php echo e($category->parent_id); ?>"
                                       data-parent="<?php echo e(optional($category->parent)->name); ?>"
                                       data-created_at="<?php echo e($category->created_at); ?>"
                                       data-path="<?php echo e($category->ancestors->pluck('name')->implode(' > ')); ?><?php echo e($category->ancestors->count() ? ' > ' : ''); ?><?php echo e($category->name); ?>">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#edit-category"
                                       data-id="<?php echo e($category->id); ?>"
                                       data-name="<?php echo e($category->name); ?>"
                                       data-parent_id="<?php echo e($category->parent_id); ?>">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#delete-modal"
                                       data-id="<?php echo e($category->id); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.pagination','data' => ['paginator' => $categories,'infoText' => 'categories']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories),'info-text' => 'categories']); ?>
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
<!-- /category list -->

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-create')): ?>
<?php echo $__env->make('admin.category.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-edit')): ?>
<?php echo $__env->make('admin.category.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-delete')): ?>
<?php echo $__env->make('admin.category.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-view')): ?>
<?php echo $__env->make('admin.category.view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal
    var editModal = document.getElementById('edit-category');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var parent_id = button.getAttribute('data-parent_id');

            document.getElementById('editCategoryForm').action = "<?php echo e(url('categories')); ?>/" + id;
            document.getElementById('edit_category_name').value = name;
            document.getElementById('edit_category_parent_id').value = parent_id;
        });
    }

    // Delete Modal
    var deleteModal = document.getElementById('delete-modal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteCategoryForm').action = "<?php echo e(url('categories')); ?>/" + id;
        });
    }

    // View Modal
    var viewModal = document.getElementById('view-category');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            document.getElementById('view_category_name').textContent = button.getAttribute('data-name');
            document.getElementById('view_category_parent').textContent = button.getAttribute('data-parent');
            document.getElementById('view_category_created_at').textContent = button.getAttribute('data-created_at');
        });
    }
});
</script>






<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/category/index.blade.php ENDPATH**/ ?>