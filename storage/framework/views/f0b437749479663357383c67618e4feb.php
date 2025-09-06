<div class="header">
    <div class="main-header">

        <!-- Logo -->
        <div class="header-left active">
            <a href="<?php echo e(route('home')); ?>" class="logo logo-normal">
                <img src="<?php echo e(asset('assets/img/ryofin-logo.png')); ?>" alt="Img">
            </a>
            <a href="<?php echo e(route('home')); ?>" class="logo logo-white">
                <img src="<?php echo e(asset('assets/img/ryofin-logo.png')); ?>" alt="Img">
            </a>
            <a href="<?php echo e(route('home')); ?>" class="logo-small">
                <img src="<?php echo e(asset('assets/img/logo-small.png')); ?>" alt="Img">
            </a>
        </div>
        <!-- /Logo -->

        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <!-- Header Menu -->
        <ul class="nav user-menu">

            <!-- Search -->
            <li class="nav-item nav-searchinputs">
                <div class="top-nav-search">
                    <a href="javascript:void(0);" class="responsive-search">
                        <i class="fa fa-search"></i>
                    </a>
                    
                </div>
            </li>
            <!-- /Search -->

            <!-- Select Store -->
            
            <!-- /Select Store -->

            <?php echo $__env->make('layouts.add-new', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
            

            <!-- Flag -->
            
            <!-- /Flag -->

            <li class="nav-item nav-item-box">
                <a href="javascript:void(0);" id="btnFullscreen">
                    <i class="ti ti-maximize"></i>
                </a>
            </li>
            
            <!-- Notifications -->
            
            <!-- /Notifications -->

            

            <?php echo $__env->make('layouts.user-profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </ul>
        <!-- /Header Menu -->

        <!-- Mobile Menu -->
        <?php echo $__env->make('layouts.user-profile-mobile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /Mobile Menu -->
    </div>
</div><?php /**PATH /workspace/resources/views/layouts/header.blade.php ENDPATH**/ ?>