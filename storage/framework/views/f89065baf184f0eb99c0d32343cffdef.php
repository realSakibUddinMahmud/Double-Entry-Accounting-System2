<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trial Balance Summary PDF</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .text-end {
            text-align: right;
        }

        .text-start {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .ps-4 {
            padding-left: 1.5rem;
        }

        .fw-medium {
            font-weight: 500;
        }

        footer {
            position: fixed;
            margin-bottom: -20px;
            left: 0px;
            right: 0px;
            font-size: 12px;
            font-style: italic;
            bottom: -5px;
        }

        header {
            text-align: center;
            margin-bottom: -25px;
            margin-top: -25px;
        }

        .main_header {
            height: 10px;
            position: relative;
        }

        .main_header .logo {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bolder;
            font-size: 35px;
            position: absolute;
            top: 0;
            right: 0;
        }

        .main_header .logo img {
            max-width: 120px;
            max-height: 75px;
        }

        .main_header .comp_info {
            position: absolute;
            top: 0;
            left: 0;
            text-align: left;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: normal;
            opacity: 0.8;
            font-size: 15px;
            font-style: italic;
        }

        .main_header ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main_header ul li {
            margin-right: 20px;
        }

        header p {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-top: 50px;
        }
    </style>
</head>

<header>
    <div class="main_header">
        <div class="container">
            <div class="logo">
                <img src="<?php echo e(public_path('assets/img/ryofin-logo.png')); ?>" alt="Logo">
            </div>

            <ul class="comp_info">
                <li><?php echo e($selected_name); ?></li>
                <li><?php echo e($address); ?></li>
                <li><?php echo e($phone); ?></li>
            </ul>
        </div>
    </div>

    <p>
        Trial Balance as of <?php echo e(date('d-M-Y', strtotime($date ?? today()))); ?>

        (Summary Report)
    </p>
</header>

<footer>
    <?php
        date_default_timezone_set('Asia/Dhaka');
    ?>
    <p>Report Generated from Inventory System at <?php echo e(date('d/m/Y h:i:s A')); ?> | Summary Report</p>
</footer>

<body>
    <table>
        <thead>
            <tr>
                <th class="text-start">Account</th>
                <th class="text-end">Net Debit (Tk)</th>
                <th class="text-end">Net Credit (Tk)</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $trialBalanceData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $accounts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(count($accounts) > 0): ?>
                    <tr>
                        <td class="text-start fw-bold"><?php echo e($category); ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($account['amount']) && $account['amount'] != 0): ?>
                            <tr>
                                <td class="text-start ps-4 fw-medium"><?php echo e($account['title']); ?></td>
                                <?php if($account['type'] === 'debit'): ?>
                                    <td class="text-end"><?php echo e(number_format($account['amount'], 2)); ?></td>
                                    <td class="text-end"></td>
                                <?php else: ?>
                                    <td class="text-end"></td>
                                    <td class="text-end"><?php echo e(number_format($account['amount'], 2)); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="3" style="border: none; height: 20px;"></td>
            </tr>
            <tr>
                <td class="text-start fw-bold">Total for Trial Balance</td>
                <td class="text-end fw-bold"><?php echo e(number_format($totalDebit, 2)); ?></td>
                <td class="text-end fw-bold"><?php echo e(number_format($totalCredit, 2)); ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center fw-bold">
                    <?php echo e($totalDebit == $totalCredit ? 'Balanced' : 'Not Balanced'); ?>

                </td>
            </tr>
        </tbody>
    </table>

    <script type="text/php">
        if ( isset($pdf) ) { 
            $pdf->page_script('
                if ($PAGE_COUNT > 0) {
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $size = 8;
                    $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                    $y = 805;
                    $x = 502;
                    $pdf->text($x, $y, $pageText, $font, $size);
                } 
            ');
        }
    </script>
</body>

</html>
<?php /**PATH /workspace/resources/views/admin/reports/trial-balance-summary-pdf.blade.php ENDPATH**/ ?>