<li class="nav-item dropdown has-arrow main-drop profile-nav">
    <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
        <span class="user-info p-0">
            <span class="user-letter">
                <img src="<?php echo e(asset('assets/img/profiles/avator.png')); ?>" alt="Img" class="img-fluid">
            </span>
        </span>
    </a>
    <div class="dropdown-menu menu-drop-user">
        <div class="profileset d-flex align-items-center">
            <span class="user-img me-2">
                <img src="<?php echo e(asset('assets/img/profiles/avator.png')); ?>" alt="Img">
            </span>
            <div>
                <h6 class="fw-medium"><?php echo e(Auth::user()->name); ?></h6>
                
            </div>
        </div>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profile-view')): ?>
        <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>"><i class="ti ti-user-circle me-2"></i>MyProfile</a>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profile-edit')): ?>
        <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>"><i class="ti ti-settings-2 me-2"></i>Edit</a>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('company-profile-show')): ?>
            <a class="dropdown-item" href="<?php echo e(route('company.profile')); ?>"><i class="ti ti-building me-2"></i>MyCompany</a>
        <?php endif; ?>

        <a class="dropdown-item" href="<?php echo e(route('clear.all', ['id' => 'admin1234'])); ?>"><i class="ti ti-trash me-2"></i>Clear All</a>

        <hr class="my-2">
        
        <?php if(auth()->guard()->check()): ?>
            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <i class="ti ti-logout me-2"></i><?php echo e(__('Logout')); ?>

            </a>

            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
        <?php endif; ?>
    </div>
</li><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/layouts/user-profile.blade.php ENDPATH**/ ?>