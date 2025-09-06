

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-create')): ?>
<div>
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="store_id" class="form-label">Store <span class="text-danger">*</span></label>
                <select
                    wire:model="store_id"
                    wire:change="changeStore($event.target.value)"
                    class="form-control"
                    id="store_id"
                    x-data
                    <?php if(count($allStores) === 1): ?>
                        x-init="$wire.set('store_id', '<?php echo e($allStores[0]->id); ?>')"
                    <?php endif; ?>
                >
                    <option value="">Select Store</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allStores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['store_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="col-md-4 mb-3">
                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" wire:model="date" id="date" class="form-control">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <hr>
        <h5>Add Products</h5>
        <div class="row align-items-end mb-2">
            <div class="col-md-6 position-relative">
                <label for="product_search" class="form-label">Search Product</label>
                <div style="position: relative;">
                    <input type="text"
                           wire:input="inputProductSearch($event.target.value)"
                           wire:model="product_search"
                           id="product_search"
                           class="form-control"
                           placeholder="Type product name, SKU, or barcode"
                           <?php if(!$store_id): ?> disabled <?php endif; ?>>
                    <!--[if BLOCK]><![endif]--><?php if(!$store_id): ?>
                        <small class="text-danger">Please select a store first.</small>
                    <?php elseif($product_search && count($product_suggestions) > 0): ?>
                        <ul class="list-group position-absolute w-100" style="z-index: 10; left:0; right:0;">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product_suggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggested): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item list-group-item-action"
                                    wire:click="selectProduct(<?php echo e($suggested->id); ?>)"
                                    style="cursor:pointer;">
                                    <?php echo e($suggested->name); ?>

                                    <!--[if BLOCK]><![endif]--><?php if($suggested->sku): ?> | <?php echo e($suggested->sku); ?> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if($suggested->barcode): ?> | <?php echo e($suggested->barcode); ?> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </ul>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        <div class="table-responsive mb-3">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Base Unit</th>
                        <th>Action</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item['product_name'] ?? ''); ?></td>
                            <td>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       value="<?php echo e($item['base_unit_name'] ?? ($item['base_unit'] ?? '')); ?>"
                                       readonly>
                            </td>
                            <td>
                                <select wire:model="product_items.<?php echo e($index); ?>.action" class="form-control form-control-sm">
                                    <option value="+">Increase</option>
                                    <option value="-">Decrease</option>
                                </select>
                            </td>
                            <td>
                                <input type="number"
                                       min="0.01"
                                       step="0.01"
                                       wire:model="product_items.<?php echo e($index); ?>.quantity"
                                       class="form-control form-control-sm">
                            </td>
                            <td class="text-center">
                                <button type="button" wire:click="removeItem(<?php echo e($index); ?>)" class="btn p-0 text-danger" title="Remove">
                                    <i class="ti ti-x"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if(count($product_items) == 0): ?>
                        <tr>
                            <td colspan="5" class="text-center">No products added.</td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="note" class="form-label">Note</label>
                <input type="text" wire:model="note" id="note" class="form-control">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-success">
                <?php echo e($stock_adjustment_id ? 'Update Stock Adjustment' : 'Save Stock Adjustment'); ?>

            </button>
        </div>
    </form>
</div>
<?php else: ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Access Denied</h4>
            <p>You don't have permission to create stock adjustments.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>
<?php endif; ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/livewire/admin/stock-adjustment-form.blade.php ENDPATH**/ ?>