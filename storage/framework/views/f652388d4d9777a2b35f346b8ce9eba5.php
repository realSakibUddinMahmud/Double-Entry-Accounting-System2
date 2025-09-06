

<li class="nav-item dropdown link-nav">
    <a href="javascript:void(0);" class="btn btn-primary btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
        <i class="ti ti-circle-plus me-1"></i>Add New
    </a>
    <div class="dropdown-menu dropdown-xl dropdown-menu-center">
        <div class="row g-2">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('categories.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-brand-codepen"></i>
                    </span>
                    <p>Category</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('products.create')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-square-plus"></i>
                    </span>
                    <p>Product</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-create')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('purchases.create')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-shopping-bag"></i>
                    </span>
                    <p>Purchase</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-create')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('sales.create')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-shopping-cart"></i>
                    </span>
                    <p>Sale</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-expense-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('de-expense.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-file-text"></i>
                    </span>
                    <p>Expense</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('customers.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-users"></i>
                    </span>
                    <p>Customer</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('suppliers.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-user-check"></i>
                    </span>
                    <p>Supplier</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('brands.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-triangles"></i>
                    </span>
                    <p>Brand</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('units.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-brand-unity"></i>
                    </span>
                    <p>Unit</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('stores.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-home-bolt"></i>
                    </span>
                    <p>Store</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('stock-adjustments.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-stairs-up"></i>
                    </span>
                    <p>Stock</p>
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-view')): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('taxes.index')); ?>" class="link-item">
                    <span class="link-icon">
                        <i class="ti ti-file-infinity"></i>
                    </span>
                    <p>Tax</p>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</li><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/layouts/add-new.blade.php ENDPATH**/ ?>