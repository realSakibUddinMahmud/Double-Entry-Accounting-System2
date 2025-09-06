<!-- filepath: /opt/lampp/htdocs/ryogas/hilinkz-inventory/packages/Hilinkz/DEAccounting/resources/views/accounts/delete-modal.blade.php -->
<!-- Delete Modal -->
<div class="modal fade" id="delete-account-modal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5">
            <form id="deleteAccountForm" method="POST" action="<?php echo e(route('de-account.delete', 0)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-body text-center p-0">
                    <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
                        <i class="ti ti-trash fs-24 text-danger"></i>
                    </span>
                    <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">Delete Account</h4>
                    <p class="text-gray-6 mb-0 fs-16">Are you sure you want to delete this account?</p>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger fs-13 fw-medium p-2 px-3">Yes Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = document.getElementById('delete-account-modal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                if (!button) return;
                var accountId = button.getAttribute('data-id');
                var form = document.getElementById('deleteAccountForm');
                // This will generate /de-accounting/accounts/{id}
                var url = '<?php echo e(route('de-account.delete', ':id')); ?>'.replace(':id', accountId);
                form.action = url;
            });
        }
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/packages/Hilinkz/DEAccounting/src/../resources/views/accounts/delete-modal.blade.php ENDPATH**/ ?>