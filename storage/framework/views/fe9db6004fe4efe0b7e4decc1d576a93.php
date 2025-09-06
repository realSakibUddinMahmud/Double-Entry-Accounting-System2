

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-create')): ?>
<div>
    <form wire:submit.prevent="save">
        <?php $__sessionArgs = ['error'];
if (session()->has($__sessionArgs[0])) :
if (isset($value)) { $__sessionPrevious[] = $value; }
$value = session()->get($__sessionArgs[0]); ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php unset($value);
if (isset($__sessionPrevious) && !empty($__sessionPrevious)) { $value = array_pop($__sessionPrevious); }
if (isset($__sessionPrevious) && empty($__sessionPrevious)) { unset($__sessionPrevious); }
endif;
unset($__sessionArgs); ?>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
                <select wire:model="supplier_id" id="supplier_id" class="form-control">
                    <option value="">Select Supplier</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="col-md-4 mb-3">
                <label for="store_id" class="form-label">Store <span class="text-danger">*</span></label>
                <select
                    wire:model="store_id"
                    wire:change="changeStore($event.target.value)"
                    class="form-control"
                    id="store_id"
                    x-data
                    <?php if(count($stores) === 1): ?>
                        x-init="$wire.set('store_id', '<?php echo e($stores[0]->id); ?>')"
                    <?php endif; ?>
                >
                    <option value="">Select Store</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                <input type="date" wire:model="purchase_date" id="purchase_date" class="form-control">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['purchase_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <div class="row">
            
            <div class="col-md-3 mb-3">
                <label for="discount_amount" class="form-label">Discount</label>
                <input type="number" step="0.01" wire:input="changeDiscountAmount($event.target.value)" wire:model="discount_amount" id="discount_amount" class="form-control">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['discount_amount'];
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
                <div class="position-relative">
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
                        <ul class="list-group position-absolute w-100" style="z-index: 10; left:0; top:100%; min-width:100%;">
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
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>COGS</th>
                        <th>Tax</th>
                        <th>Tax Amount</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item['product_name'] ?? ''); ?></td>
                            <td>
                                <select wire:model="product_items.<?php echo e($index); ?>.unit_id" class="form-control">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <!--[if BLOCK]><![endif]--><?php if($unit->id == $item['base_unit_id'] || $unit->parent_id == $item['base_unit_id']): ?>
                                            <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </td>
                            <td>
                                <input type="number"
                                       step="0.01"
                                       min="1"
                                       wire:input="changeProductQty($event.target.value, <?php echo e($index); ?>)"
                                       wire:model="product_items.<?php echo e($index); ?>.quantity"
                                       class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="number" min="1" step="0.01" wire:input="changeProductCost($event.target.value, <?php echo e($index); ?>)" wire:model="product_items.<?php echo e($index); ?>.per_unit_cost" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="number" min="1" step="0.01" wire:model="product_items.<?php echo e($index); ?>.per_unit_cogs" class="form-control form-control-sm">
                            </td>
                            <td>
                                <select wire:model="product_items.<?php echo e($index); ?>.tax_id" class="form-control form-control-sm" wire:change="calculateTotals">
                                    <option value="">No Tax</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tax->id); ?>" <?php echo e($tax->id == ($item['tax_id'] ?? null) ? 'selected' : ''); ?>>
                                            <?php echo e($tax->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </td>
                            <td>
                                <?php echo e(number_format($this->calculateItemTaxAmount($item), 2)); ?> (<?php echo e($item['tax_method'] ?? 'exclusive'); ?>)
                            </td>
                            <td><?php echo e(number_format($this->calculateItemTotal($item), 2)); ?></td>
                            <td class="text-center">
                                <button type="button" wire:click="removeItem(<?php echo e($index); ?>)" class="btn p-0 text-danger" title="Remove">
                                    <i class="ti ti-x"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if(count($product_items) == 0): ?>
                        <tr>
                            <td colspan="8" class="text-center">No products added.</td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total</th>
                        <th></th>
                        <th>
                            <?php echo e(number_format(collect($product_items)->sum(fn($item) => $this->calculateItemTaxAmount($item)), 2)); ?>

                        </th>
                        <th>
                            <?php echo e(number_format(collect($product_items)->sum(fn($item) => $this->calculateItemTotal($item)), 2)); ?>

                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Total Amount</label>
                <input type="text" class="form-control" value="<?php echo e($total_amount); ?>" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Paid Amount</label>
                <input type="number" step="0.01" wire:input="changePaidAmount" wire:model="paid_amount" class="form-control" readonly>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['paid_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="col-md-3">
                <label class="form-label">Due Amount</label>
                <input type="text" class="form-control" value="<?php echo e($due_amount); ?>" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Payment Status</label>
                <select wire:model="payment_status" class="form-control" disabled>
                    <option value="Pending">Pending</option>
                    <option value="Partial">Partial</option>
                    <option value="Paid">Paid</option>
                </select>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Note</label>
                <textarea wire:model="note" class="form-control" rows="2" placeholder="Add any notes..."></textarea>
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
        <button type="submit" class="btn btn-success">
            <?php echo e($mode === 'edit' ? 'Update Purchase' : 'Save Purchase'); ?>

        </button>
    </form>
</div>
<?php else: ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Access Denied</h4>
            <p>You don't have permission to create purchases.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">
                <i class="ti ti-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/livewire/admin/purchase-form.blade.php ENDPATH**/ ?>