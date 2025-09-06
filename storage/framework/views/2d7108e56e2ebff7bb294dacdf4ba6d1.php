<!DOCTYPE html>
<html lang="en" data-layout-mode="light_mode">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RyoFin is a robust inventory management system featuring double entry accounting and product transformation, designed to streamline business operations.">
    <meta name="keywords" content="RyoFin, inventory management, double entry accounting, product transformation, business management, responsive admin, POS system">
    <meta name="author" content="RyoFin Team">
    <meta name="robots" content="index, follow">
    <title><?php echo $__env->yieldContent('title', 'RyoFin'); ?> | <?php echo e(config('app.name', 'RyoFin')); ?></title>

    <script src="<?php echo e(asset('assets/js/theme-script.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>	

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon.png')); ?>">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>">

    <!-- Bootstrap CSS (static) -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datetimepicker.min.css')); ?>">

    <!-- animation CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/animate.css')); ?>">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/tabler-icons/tabler-icons.css')); ?>">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome/css/fontawesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome/css/all.min.css')); ?>">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/@simonwep/pickr/themes/nano.min.css')); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">

</head>

<body>
    <!-- Main Wrapper -->
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="content w-100">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- /Main Wrapper -->

    <!-- Theme core scripts (static) -->
    <script src="<?php echo e(asset('assets/js/script.js')); ?>" type="text/javascript"></script>

</body>
</html>
<?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/layouts/app.blade.php ENDPATH**/ ?>