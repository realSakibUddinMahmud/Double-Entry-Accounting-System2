<?php $__env->startSection('title', 'Company Profile'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Company Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <?php if($logo): ?>
                                <img src="<?php echo e(asset('storage/' . $logo->path)); ?>" alt="Company Logo"
                                    style="height: 100px; width: 100px; object-fit: cover;">
                            <?php else: ?>
                                <img src="<?php echo e(asset('admin/no-image.png')); ?>" alt="No Logo"
                                    style="height: 100px; width: 100px; object-fit: cover; border-radius: 50%;">
                            <?php endif; ?>
                        </div>

                        <h5 class="mb-3"><i class="ti ti-building text-primary me-1"></i> Company Information</h5>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">Company Name:</div>
                            <div class="col-md-8"><?php echo e($company->name); ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">Contact Number:</div>
                            <div class="col-md-8"><?php echo e($company->contact_no); ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">Email:</div>
                            <div class="col-md-8"><?php echo e($company->email ?? 'N/A'); ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">Office Address:</div>
                            <div class="col-md-8"><?php echo e($company->office_address ?? 'N/A'); ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">Region:</div>
                            <div class="col-md-8"><?php echo e($company->region ?? 'N/A'); ?></div>
                        </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('company-profile-show')): ?>
                        <div class="d-flex justify-content-end">
                            <a href="<?php echo e(route('company.profile.edit')); ?>" class="btn btn-primary">
                                Edit Profile
                            </a>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/company/profile/show.blade.php ENDPATH**/ ?>