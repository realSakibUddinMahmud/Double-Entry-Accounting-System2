<?php $__env->startSection('title', 'Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>All Products</h4>
            <h6>Manage your Products</h6>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
    <div class="page-btn">
        <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">
            <i class="ti ti-circle-plus me-1"></i>Add Product
        </a>
    </div>
    <?php endif; ?>
</div>
<!-- /product list -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Search & Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('products.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search Product Name</label>
                <input type="text" name="search" class="form-control" placeholder="Search by product name..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Brand</label>
                <select name="brand_id" class="form-select">
                    <option value="">All Brands</option>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($brand->id); ?>" <?php echo e(request('brand_id') == $brand->id ? 'selected' : ''); ?>>
                            <?php echo e($brand->name); ?>

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
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>Active</option>
                    <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-search me-1"></i>Search
                </button>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">
                    <i class="ti ti-refresh me-1"></i>Clear Filters
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5 class="card-title mb-0">Product List</h5>
        <div class="ms-auto">
            <span class="text-muted">Total: <?php echo e($products->total()); ?> products</span>
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
                        <th>Category</th>
                        <th>Brand</th>
                        
                        <th>Store</th>
                        <th>Unit</th>
                        <th>Cost</th>
                        <th>Cogs (Avg)</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $storeData = $product->productStores->first();
                            // Fetch stock quantity from the view for this product and store
                            $stockQty = null;
                            if ($storeData) {
                                $stockQty = optional(
                                    $product->productStoreStockViews
                                        ->where('store_id', $storeData->store_id)
                                        ->first()
                                )->current_stock_qty;
                            }
                            $cogsAvg = optional(
                                $product->cogsAvgView($storeData?->store_id)->first()
                            )->cogs_avg ?? 0;
                            $additionalFields = [];
                            foreach ($customFields as $field) {
                                $value = optional(
                                    $product->customFieldValues->where('custom_field_id', $field->id)->first()
                                )->value;
                                $additionalFields[$field->label] = $value ?? '-';
                            }
                        ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($product->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td class="text-gray-9">
                                <?php echo e($product->name); ?>

                            </td>
                            <td>
                                <?php echo e(optional($product->category)->name ?? '-'); ?>

                            </td>
                            <td>
                                <?php echo e(optional($product->brand)->name ?? '-'); ?>

                            </td>
                            
                            <td>
                                <?php echo e(optional($storeData?->store)->name ?? '-'); ?>

                            </td>
                            <td>
                                <?php echo e(optional($storeData?->base_unit)->name ?? '-'); ?>

                            </td>
                            <td>
                                <?php echo e($storeData->purchase_cost ?? '-'); ?>

                            </td>
                            <td>
                                <?php echo e(is_numeric($cogsAvg) ? number_format($cogsAvg, 2) : '-'); ?>

                            </td>
                            <td>
                                <?php echo e($storeData->sales_price ?? '-'); ?>

                            </td>
                            <td>
                                <?php echo e(is_numeric($stockQty) ? number_format($stockQty, 2) : '-'); ?>

                            </td>
                            <td>
                                <?php if($product->status): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-view')): ?>
                                    <a class="me-2 p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#viewProductModal"
                                       data-id="<?php echo e($product->id); ?>"
                                       data-name="<?php echo e($product->name); ?>"
                                       data-category="<?php echo e(optional($product->category)->name); ?>"
                                       data-brand="<?php echo e(optional($product->brand)->name); ?>"
                                       data-sku="<?php echo e($product->sku); ?>"
                                       data-barcode="<?php echo e($product->barcode); ?>"
                                       data-status="<?php echo e($product->status); ?>"
                                       data-description="<?php echo e($product->description); ?>"
                                       data-store="<?php echo e(optional($storeData?->store)->name); ?>"
                                       data-base_unit="<?php echo e(optional($storeData?->base_unit)->name); ?>"
                                       data-purchase_cost="<?php echo e($storeData->purchase_cost ?? '-'); ?>"
                                       data-sales_price="<?php echo e($storeData->sales_price ?? '-'); ?>"
                                       data-images="<?php echo e(json_encode($product->images->map(fn($img) => asset('storage/'.$img->path)))); ?>"
                                       data-additional_fields='<?php echo json_encode($additionalFields, 15, 512) ?>'>
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-edit')): ?>
                                    <a class="me-2 p-2"
                                       href="<?php echo e(route('products.edit', $product->id)); ?>">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-delete')): ?>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#deleteProductModal"
                                       data-id="<?php echo e($product->id); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.pagination','data' => ['paginator' => $products,'infoText' => 'products']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($products),'info-text' => 'products']); ?>
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
<!-- /product list -->

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-delete')): ?>
<?php echo $__env->make('admin.product.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-view')): ?>
<?php echo $__env->make('admin.product.view-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal
    var editModal = document.getElementById('editProductModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var category_id = button.getAttribute('data-category_id');
            var brand_id = button.getAttribute('data-brand_id');
            var sku = button.getAttribute('data-sku');
            var barcode = button.getAttribute('data-barcode');
            var status = button.getAttribute('data-status');
            var description = button.getAttribute('data-description');

            document.getElementById('editProductForm').action = "<?php echo e(url('products')); ?>/" + id;
            document.getElementById('edit_product_name').value = name;
            document.getElementById('edit_product_category_id').value = category_id;
            document.getElementById('edit_product_brand_id').value = brand_id;
            document.getElementById('edit_product_sku').value = sku;
            document.getElementById('edit_product_barcode').value = barcode;
            document.getElementById('edit_product_status').value = status;
            document.getElementById('edit_product_description').value = description;
        });
    }

    // Delete Modal
    var deleteModal = document.getElementById('deleteProductModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            document.getElementById('deleteProductForm').action = "<?php echo e(url('products')); ?>/" + id;
        });
    }

    // View Modal
    var viewModal = document.getElementById('viewProductModal');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            document.getElementById('view_product_name').textContent = button.getAttribute('data-name');
            document.getElementById('view_product_category').textContent = button.getAttribute('data-category');
            document.getElementById('view_product_brand').textContent = button.getAttribute('data-brand');
            document.getElementById('view_product_sku').textContent = button.getAttribute('data-sku');
            document.getElementById('view_product_barcode').textContent = button.getAttribute('data-barcode');
            document.getElementById('view_product_status').textContent = button.getAttribute('data-status') == 1 ? 'Active' : 'Inactive';
            document.getElementById('view_product_description').textContent = button.getAttribute('data-description');

            // Additional Fields (expects a JSON object in data-additional_fields)
            var additionalFieldsData = button.getAttribute('data-additional_fields');
            var additionalFieldsContainer = document.getElementById('view_product_additional_fields');
            if (additionalFieldsContainer) {
                additionalFieldsContainer.innerHTML = '';
                if (additionalFieldsData) {
                    try {
                        var fields = JSON.parse(additionalFieldsData);
                        if (fields && typeof fields === 'object') {
                            Object.keys(fields).forEach(function(label) {
                                var dt = document.createElement('dt');
                                dt.className = 'col-sm-4';
                                dt.textContent = label + ':';
                                var dd = document.createElement('dd');
                                dd.className = 'col-sm-8';
                                dd.textContent = fields[label];
                                additionalFieldsContainer.appendChild(dt);
                                additionalFieldsContainer.appendChild(dd);
                            });
                        }
                    } catch (e) {
                        // Ignore if invalid
                    }
                }
            }
        });
    }
});
</script>






<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/product/index.blade.php ENDPATH**/ ?>