<?php $__env->startSection('title', 'Stock Report'); ?>

<?php $__env->startSection('content'); ?>

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Stock Report</h4>
                    <h6>View your stock by store and product</h6>
                </div>
            </div> 
        </div>
        <div class="card">
            <div class="card-body pb-1">
                <form action="<?php echo e(route('report.stock')); ?>" method="GET">
                    <div class="row align-items-end">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Start Date</label>
                                        <div class="input-icon-start">
                                            <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date', now()->toDateString())); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">End Date</label>
                                        <div class="input-icon-start">
                                            <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date', now()->toDateString())); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Store</label>
                                        <select class="form-control" name="store_id">
                                            <option value="">All</option>
                                            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($store->id); ?>" <?php if(request('store_id') == $store->id): ?> selected <?php endif; ?>><?php echo e($store->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3 d-flex gap-2">
                                <button class="btn btn-primary w-100" type="submit">View</button>
                                <a class="btn btn-secondary w-100"
                                   href="<?php echo e(route('report.stock.export', array_merge(request()->all(), ['format' => 'pdf']))); ?>">
                                    PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card no-search">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Store</th>
                                <th>SKU</th>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>Initial Stock</th>
                                <th>Purchase Qty</th>
                                <th>Sales Qty</th>
                                <th>Adjustment Qty</th>
                                <th>InStock Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reportRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storeName => $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $rowspan = count($products);
                                    $first = true;
                                    $storeInitialStock = 0;
                                    $storePurchaseQty = 0;
                                    $storeSalesQty = 0;
                                    $storeAdjustmentQty = 0;
                                    $storeInStockQty = 0;
                                ?>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $storeInitialStock += $row['initial_stock'] ?? 0;
                                        $storePurchaseQty += $row['purchase_qty'];
                                        $storeSalesQty += $row['sales_qty'];
                                        $storeAdjustmentQty += $row['adjustment_total'];
                                        $storeInStockQty += $row['instock_qty'];
                                    ?>
                                    <tr>
                                        <?php if($first): ?>
                                            <td rowspan="<?php echo e($rowspan); ?>" style="vertical-align: middle;"><?php echo e($storeName); ?></td>
                                            <?php $first = false; ?>
                                        <?php endif; ?>
                                        <td><?php echo e($row['sku']); ?></td>
                                        <td><?php echo e($row['product_name']); ?></td>
                                        <td><?php echo e($row['unit']); ?></td>
                                        <td><?php echo e($row['initial_stock'] ?? 0); ?></td>
                                        <td><?php echo e($row['purchase_qty']); ?></td>
                                        <td><?php echo e($row['sales_qty']); ?></td>
                                        <td><?php echo e($row['adjustment_qty']); ?></td>
                                        <td><?php echo e($row['instock_qty']); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr style="background:#f9f9f9;">
                                    <th colspan="4" class="text-end">Total for <?php echo e($storeName); ?></th>
                                    <th><?php echo e($storeInitialStock); ?></th>
                                    <th><?php echo e($storePurchaseQty); ?></th>
                                    <th><?php echo e($storeSalesQty); ?></th>
                                    <th><?php echo e($storeAdjustmentQty); ?></th>
                                    <th><?php echo e($storeInStockQty); ?></th>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /stock list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/reports/stock.blade.php ENDPATH**/ ?>