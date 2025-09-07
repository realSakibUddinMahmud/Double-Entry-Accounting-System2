
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stock Report PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <h2>Stock Report</h2>
    <table>
        <thead>
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
</body>
</html><?php /**PATH /workspace/resources/views/admin/reports/stock-export-pdf.blade.php ENDPATH**/ ?>