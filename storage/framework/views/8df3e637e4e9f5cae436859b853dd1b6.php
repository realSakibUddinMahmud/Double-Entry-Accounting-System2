<?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($journal->files && $journal->files->count() > 0): ?>
    <div class="modal fade" id="filesModal<?php echo e($journal->id); ?>" tabindex="-1" aria-labelledby="filesModalLabel<?php echo e($journal->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attached Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <?php $__currentLoopData = $journal->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <?php echo e($file->title); ?>

                                </div>
                                <div class="btn-group">
                                    <a href="<?php echo e(asset($file->path)); ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteFileModal<?php echo e($file->id); ?>">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('de-accounting::loan-investments.delete-file-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/packages/Hilinkz/DEAccounting/src/../resources/views/loan-investments/files-modal.blade.php ENDPATH**/ ?>