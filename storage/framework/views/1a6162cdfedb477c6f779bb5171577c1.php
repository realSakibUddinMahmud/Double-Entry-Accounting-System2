<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Profile</h4>
                </div>
                <div class="card-body">
                    <h5 class="mb-3"><i class="ti ti-user text-primary me-1"></i> Basic Information</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Name:</div>
                        <div class="col-md-8"><?php echo e($user->name); ?></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8"><?php echo e($user->email); ?></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Phone:</div>
                        <div class="col-md-8"><?php echo e($user->phone); ?></div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary me-2">
                            Edit Profile
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#passwordModal">
                            Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Change Modal -->
<?php echo $__env->make('admin.profile.password-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/resources/views/admin/profile/show.blade.php ENDPATH**/ ?>