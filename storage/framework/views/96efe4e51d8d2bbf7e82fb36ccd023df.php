<?php $__env->startSection('title', 'Add Product'); ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="page-title">
        <h4>Add Product</h4>
        <h6>Create a new product</h6>
    </div>
    <div class="page-btn">
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
            <i class="ti ti-list me-1"></i>Product List
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="<?php echo e(route('products.store')); ?>" method="POST" id="createProductForm" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Store <span class="text-danger">*</span></label>
                    <select name="store_id" class="form-select" id="store_id" required>
                        <option value="">Select Store</option>
                        <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 position-relative">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" id="product_name" list="product_name_suggestions" autocomplete="off" required>
                        <button type="button" class="btn btn-outline-secondary" id="toggleSuggestionsBtn" title="Enable/Disable Suggestions">
                            <span id="toggleSuggestionsIcon" class="ti ti-bulb"></span>
                        </button>
                    </div>
                    <datalist id="product_name_suggestions" style="background: rgba(255,255,255,0.8);">
                        <?php $__currentLoopData = $productNameSuggestions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($suggestion); ?>"></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </datalist>
                </div>
                <div class="col-md-4">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" id="sku">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Brand</label>
                    <select name="brand_id" class="form-select" id="add_product_brand_id">
                        <option value="">Select Brand</option>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" id="add_product_category_id" required>
                        <option value="">Select Category</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!$cat->parent_id): ?>
                                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                <?php if($cat->children && $cat->children->count()): ?>
                                    <?php $__currentLoopData = $cat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($child->id); ?>">— <?php echo e($child->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Barcode</label>
                    <div class="input-group">
                        <input type="text" name="barcode" class="form-control" id="barcode">
                        <button type="button" class="btn btn-outline-secondary" id="generateBarcodeBtn" tabindex="-1">Generate</button>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Base Unit <span class="text-danger">*</span></label>
                    <select name="base_unit_id" class="form-select" id="base_unit_id" required>
                        <option value="">Select Base Unit</option>
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Purchase Unit <span class="text-danger">*</span></label>
                    <select name="purchase_unit_id" class="form-select" id="purchase_unit_id" required>
                        <option value="">Select Purchase Unit</option>
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sales Unit <span class="text-danger">*</span></label>
                    <select name="sales_unit_id" class="form-select" id="sales_unit_id" required>
                        <option value="">Select Sales Unit</option>
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Purchase Cost <span class="text-danger">*</span></label>
                    <input type="number" name="purchase_cost" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="col-md-4 position-relative">
                    <label class="form-label">
                        Cost of Goods Sold (COGS) <span class="text-danger">*</span>
                        <span class="ms-1" style="cursor:pointer;" tabindex="0">
                            <i class="ti ti-info-circle" 
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top" 
                               title="Enter the total cost including purchase, shipping, handling, and any other direct costs.">
                            </i>
                        </span>
                    </label>
                    <input type="number" name="cogs" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sales Price <span class="text-danger">*</span></label>
                    <input type="number" name="sales_price" class="form-control" step="0.01" min="0" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Tax</label>
                    <select name="tax_id" class="form-select" id="tax_id">
                        <option value="">Select Tax</option>
                        <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tax->id); ?>"><?php echo e($tax->name); ?> (<?php echo e($tax->rate); ?>%)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tax Method</label>
                    <select name="tax_method" class="form-select" id="tax_method">
                        <option value="exclusive">Exclusive</option>
                        <option value="inclusive">Inclusive</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2"></textarea>
            </div>

            
            <?php if($productFields->count()): ?>
                <div class="mb-3">
                    <h6 class="mb-2">Additional Fields</h6>
                    <div class="row">
                        <?php $__currentLoopData = $productFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-3">
                                <label class="form-label"><?php echo e($field->label); ?><?php if($field->type !== 'checkbox'): ?> <span class="text-danger">*</span><?php endif; ?></label>
                                <?php if($field->type === 'text'): ?>
                                    <input type="text" name="additional_fields[<?php echo e($field->name); ?>]" class="form-control">
                                <?php elseif($field->type === 'number'): ?>
                                    <input type="number" name="additional_fields[<?php echo e($field->name); ?>]" class="form-control">
                                <?php elseif($field->type === 'date'): ?>
                                    <input type="date" name="additional_fields[<?php echo e($field->name); ?>]" class="form-control">
                                <?php elseif($field->type === 'select'): ?>
                                    <select name="additional_fields[<?php echo e($field->name); ?>]" class="form-select">
                                        <option value="">Select <?php echo e($field->label); ?></option>
                                        <?php $__currentLoopData = explode(',', $field->options); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e(trim($option)); ?>"><?php echo e(trim($option)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                <?php elseif($field->type === 'checkbox'): ?>
                                    <div class="form-check">
                                        <input type="checkbox" name="additional_fields[<?php echo e($field->name); ?>]" class="form-check-input" value="1" id="field_<?php echo e($field->name); ?>">
                                        <label class="form-check-label" for="field_<?php echo e($field->name); ?>"><?php echo e($field->label); ?></label>
                                    </div>
                                <?php elseif($field->type === 'textarea'): ?>
                                    <textarea name="additional_fields[<?php echo e($field->name); ?>]" class="form-control"></textarea>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Product Images</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                <small class="text-muted">You can select multiple images.</small>
            </div>
            <div class="modal-footer px-0">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php else: ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="page-title">
        <h4>Access Denied</h4>
        <h6>You don't have permission to create products</h6>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var nameInput = document.getElementById('product_name');
    var datalist = document.getElementById('product_name_suggestions');
    var toggleBtn = document.getElementById('toggleSuggestionsBtn');
    var toggleIcon = document.getElementById('toggleSuggestionsIcon');
    var suggestionsEnabled = true;

    toggleBtn.addEventListener('click', function () {
        suggestionsEnabled = !suggestionsEnabled;
        if (suggestionsEnabled) {
            nameInput.setAttribute('list', 'product_name_suggestions');
            toggleIcon.className = 'ti ti-bulb';
        } else {
            nameInput.removeAttribute('list');
            toggleIcon.className = 'ti ti-bulb-off';
        }
    });

    var skuInput = document.getElementById('sku');
    var barcodeInput = document.getElementById('barcode');
    var generateBarcodeBtn = document.getElementById('generateBarcodeBtn');

    // Track if SKU was autofilled or manually edited
    skuInput.dataset.autofilled = "1";

    // Autofill SKU when product name changes, only if not manually edited
    nameInput.addEventListener('input', function () {
        if (skuInput.dataset.autofilled === "1") {
            let slug = nameInput.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-') // replace non-alphanumeric with dash
                .replace(/^-+|-+$/g, '')     // trim dashes
                .substring(0, 30);           // limit length if needed
            skuInput.value = slug;
        }
    });

    // If user edits SKU, stop autofilling
    skuInput.addEventListener('input', function () {
        skuInput.dataset.autofilled = "0";
    });

    // If SKU is cleared, allow autofill again
    skuInput.addEventListener('blur', function () {
        if (skuInput.value === '') {
            skuInput.dataset.autofilled = "1";
        }
    });

    // Barcode generator (random 12-digit number)
    generateBarcodeBtn.addEventListener('click', function () {
        let barcode = '';
        for (let i = 0; i < 12; i++) {
            barcode += Math.floor(Math.random() * 10);
        }
        barcodeInput.value = barcode;
    });

    // Unit selection logic
    var baseUnit = document.getElementById('base_unit_id');
    var purchaseUnit = document.getElementById('purchase_unit_id');
    var salesUnit = document.getElementById('sales_unit_id');

    baseUnit.addEventListener('change', function () {
        if (baseUnit.value) {
            purchaseUnit.value = baseUnit.value;
            salesUnit.value = baseUnit.value;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/product/create.blade.php ENDPATH**/ ?>