<div class="dropdown mobile-user-menu">
    <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
    <div class="dropdown-menu dropdown-menu-right">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profile-view')): ?>
        <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">My Profile</a>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profile-edit')): ?>
        <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Settings</a>
        <?php endif; ?>

        <a class="dropdown-item" href="<?php echo e(route('clear.all', ['id' => 'admin1234'])); ?>">Clear All</a>
        
        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            <?php echo e(__('Logout')); ?>

        </a>

        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
            <?php echo csrf_field(); ?>
        </form>
    </div>
</div><?php /**PATH /workspace/resources/views/layouts/user-profile-mobile.blade.php ENDPATH**/ ?>