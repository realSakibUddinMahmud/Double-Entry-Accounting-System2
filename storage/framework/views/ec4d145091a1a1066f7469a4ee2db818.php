<!-- Add Role -->
<div class="modal fade" id="add-role">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="page-title">
                    <h4>Add Role</h4>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('roles.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guard Name</label>
                        <input type="text" name="guard_name" class="form-control" value="web">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permissions</label>
                        <div class="row">
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" 
                                               value="<?php echo e($permission->id); ?>" 
                                               id="perm_<?php echo e($permission->id); ?>" 
                                               class="form-check-input">
                                        <label for="perm_<?php echo e($permission->id); ?>" 
                                               class="form-check-label"><?php echo e($permission->name); ?></label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Role --><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/roles/create-modal.blade.php ENDPATH**/ ?>