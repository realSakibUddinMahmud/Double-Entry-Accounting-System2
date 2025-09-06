<?php $__env->startSection('title', 'Edit Company Profile'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Company Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('company.profile.update')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="row mb-3">
                                <div class="col-md-12 text-center">
                                    <?php if($logo): ?>
                                        <img src="<?php echo e(asset('storage/' . $logo->path)); ?>" id="logo-preview"
                                            alt="Company Logo"
                                            style="height: 100px; width: 100px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('admin/no-image.png')); ?>" id="logo-preview" alt="No Logo"
                                            style="height: 100px; width: 100px; object-fit: cover; border-radius: 50%;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?php echo e(old('name', $company->name)); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_no" class="form-control"
                                        value="<?php echo e(old('contact_no', $company->contact_no)); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?php echo e(old('email', $company->email)); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Region</label>
                                    <input type="text" name="region" class="form-control"
                                        value="<?php echo e(old('region', $company->region)); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Office Address</label>
                                    <textarea name="office_address" class="form-control" rows="3"><?php echo e(old('office_address', $company->office_address)); ?></textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Logo (Image)</label>
                                <input type="file" name="logo" class="form-control" accept="image/*">
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="<?php echo e(route('company.profile')); ?>" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logo preview
            const logoInput = document.getElementById('logo');
            const logoPreview = document.getElementById('logo-preview');

            logoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/company/profile/edit.blade.php ENDPATH**/ ?>