<?php $__env->startSection('title', 'Sales Report'); ?>

<?php $__env->startSection('content'); ?>

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Sales Report</h4>
                    <h6>Manage your Sales report</h6>
                </div>
            </div> 
        </div>
        <div class="card">
            <div class="card-body pb-1">
                <form action="<?php echo e(route('report.sales')); ?>" method="GET">
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
                                   href="<?php echo e(route('report.sales.export', array_merge(request()->all(), ['format' => 'pdf']))); ?>">
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
                                <th>Sold Qty</th>
                                <th>Sold Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $grandTotalQty = 0;
                                $grandTotalAmount = 0;
                            ?>
                            <?php $__currentLoopData = $reportRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storeName => $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $rowspan = count($products);
                                    $storeTotalQty = 0;
                                    $storeTotalAmount = 0;
                                    $first = true;
                                ?>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $storeTotalQty += $row['sold_qty'];
                                        $storeTotalAmount += $row['sold_amount'];
                                        $grandTotalQty += $row['sold_qty'];
                                        $grandTotalAmount += $row['sold_amount'];
                                    ?>
                                    <tr>
                                        <?php if($first): ?>
                                            <td rowspan="<?php echo e($rowspan); ?>" style="vertical-align: middle;"><?php echo e($storeName); ?></td>
                                            <?php $first = false; ?>
                                        <?php endif; ?>
                                        <td><?php echo e($row['sku']); ?></td>
                                        <td><?php echo e($row['product_name']); ?></td>
                                        <td><?php echo e($row['unit']); ?></td>
                                        <td><?php echo e($row['sold_qty']); ?></td>
                                        <td><?php echo e(number_format($row['sold_amount'], 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr style="background:#f9f9f9;">
                                    <th colspan="4" class="text-end">Total for <?php echo e($storeName); ?></th>
                                    <th><?php echo e($storeTotalQty); ?></th>
                                    <th><?php echo e(number_format($storeTotalAmount, 2)); ?></th>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Grand Total</th>
                                <th><?php echo e($grandTotalQty); ?></th>
                                <th><?php echo e(number_format($grandTotalAmount, 2)); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/reports/sales.blade.php ENDPATH**/ ?>