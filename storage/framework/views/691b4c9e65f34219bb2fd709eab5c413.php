<!DOCTYPE html>
<html lang="en" data-layout-mode="light_mode">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hi-Inventory is a robust inventory management system featuring double entry accounting and product transformation, designed to streamline business operations.">
    <meta name="keywords" content="Hi-Inventory, inventory management, double entry accounting, product transformation, business management, responsive admin, POS system">
    <meta name="author" content="Hi-Inventory Team">
    <meta name="robots" content="index, follow">
    <title>
        <?php echo $__env->yieldContent('title', 'Hi-Inventory'); ?> | <?php echo e(config('app.name', 'Hi-Inventory')); ?>

    </title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon.png')); ?>">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/feather.css')); ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datetimepicker.min.css')); ?>">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/animate.css')); ?>">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>">
    <!-- Summernote CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/summernote/summernote-bs4.min.css')); ?>">
    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')); ?>">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/dataTables.bootstrap5.min.css')); ?>">
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/tabler-icons/tabler-icons.css')); ?>">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome/css/fontawesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome/css/all.min.css')); ?>">
    <!-- Color Picker CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/@simonwep/pickr/themes/nano.min.css')); ?>">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables-buttons/css/buttons.bootstrap5.min.css')); ?>">

    <!-- Theme Script -->
    <script src="<?php echo e(asset('assets/js/theme-script.js')); ?>" type="4ca29d42bceef05ee1ad5bcf-text/javascript"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body>
    

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /Header -->

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- Logo -->
            <div class="sidebar-logo">
                <a href="<?php echo e(route('home')); ?>" class="logo logo-normal">
                    <img src="<?php echo e(asset('assets/img/ryofin-logo.png')); ?>" alt="Img">
                </a>
                <a href="<?php echo e(route('home')); ?>" class="logo logo-white">
                    <img src="<?php echo e(asset('assets/img/ryofin-logo.png')); ?>" alt="Img">
                </a>
                <a href="<?php echo e(route('home')); ?>" class="logo-small">
                    <img src="<?php echo e(asset('assets/img/logo-small.png')); ?>" alt="Img">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                    <i data-feather="chevrons-left" class="feather-16"></i>
                </a>
            </div>
            <!-- /Logo -->
            <?php echo $__env->make('layouts.side-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- /Sidebar -->

        <div class="page-wrapper">
            <div class="content">

                
                <?php if(session('success')): ?>
                    <div class="toast align-items-center text-bg-success border-0 position-fixed top-0 end-0 m-4 show" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 9999;">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?php echo e(session('success')); ?>

                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="toast align-items-center text-bg-danger border-0 position-fixed top-0 end-0 m-4 show" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 9999;">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?php echo e(session('error')); ?>

                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(session('warning')): ?>
                    <div class="toast align-items-center text-bg-warning border-0 position-fixed top-0 end-0 m-4 show" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 9999;">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?php echo e(session('warning')); ?>

                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="toast align-items-center text-bg-danger border-0 position-fixed top-0 end-0 m-4 show" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 9999;">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?php echo e($errors->first()); ?>

                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

    </div>
    <!-- /Main Wrapper -->

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="<?php echo e(asset('assets/js/jquery-3.7.1.min.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>
    <!-- Bootstrap Core JS -->
    <script src="<?php echo e(asset('assets/js/bootstrap.bundle.min.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>
    <!-- Feather Icon JS -->
    <script src="<?php echo e(asset('assets/js/feather.min.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>
    <!-- Slimscroll JS -->
    <script src="<?php echo e(asset('assets/js/jquery.slimscroll.min.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>
    <!-- Datatable JS -->
    <script src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>" type="4ca29d42bceef05ee1ad5bcf-text/javascript"></script>
    <script src="<?php echo e(asset('assets/js/dataTables.bootstrap5.min.js')); ?>" type="4ca29d42bceef05ee1ad5bcf-text/javascript"></script>
    <!-- Summernote JS -->
    <script src="<?php echo e(asset('assets/plugins/summernote/summernote-bs4.min.js')); ?>" type="4ca29d42bceef05ee1ad5bcf-text/javascript"></script>
    <!-- Select2 JS -->
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.min.js')); ?>" type="4ca29d42bceef05ee1ad5bcf-text/javascript"></script>
    <!-- Datetimepicker JS -->
    <script src="<?php echo e(asset('assets/js/moment.min.js')); ?>" type="4ca29d42bceef05ee1ad5bcf-text/javascript"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap-datetimepicker.min.js')); ?>" type="4ca29d42bceef05ee1ad5bcf-text/javascript"></script>
    <!-- Bootstrap Tagsinput JS -->
    <script src="<?php echo e(asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')); ?>" type="4ca29d42bceef05ee1ad5bcf-text/javascript"></script>
    <!-- Chart JS -->
    <script src="<?php echo e(asset('assets/plugins/apexchart/apexcharts.min.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>
    <script src="<?php echo e(asset('assets/plugins/apexchart/chart-data.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>

    <!-- Chart JS -->
    

    <!-- Daterangepikcer JS -->
    <script src="assets/js/moment.min.js" type="eb16dee38797852848cea039-text/javascript"></script>
    <script src="assets/plugins/daterangepicker/daterangepicker.js"type="eb16dee38797852848cea039-text/javascript"></script>

    <!-- Color Picker JS -->
    <script src="<?php echo e(asset('assets/plugins/@simonwep/pickr/pickr.es5.min.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>
    <!-- Custom JS -->
    <script src="<?php echo e(asset('assets/js/theme-colorpicker.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>
    <script src="<?php echo e(asset('assets/js/script.js')); ?>" type="eb16dee38797852848cea039-text/javascript"></script>
    <!-- Rocket Loader -->
    <script src="<?php echo e(asset('assets/js/rocket-loader.min.js')); ?>" data-cf-settings="eb16dee38797852848cea039-|49" defer></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH /workspace/resources/views/layouts/app-admin.blade.php ENDPATH**/ ?>