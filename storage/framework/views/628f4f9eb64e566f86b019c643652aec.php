<?php $__env->startSection('title', 'Chart of Accounts'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Chart of Accounts</h4>
            <h6>Manage your Chart of Accounts</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="<?php echo e(route('de-account.create')); ?>" class="btn btn-primary">
            <i class="ti ti-circle-plus me-1"></i>Add Account
        </a>
    </div>
</div>
<!-- /account list -->
<div class="card card-body">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('de-accounting::account-search-component');

$__html = app('livewire')->mount($__name, $__params, 'lw-32834915-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5 class="card-title mb-0">Account List</h5>
        <div class="ms-auto">
            <span class="text-muted">Total: <?php echo e($accounts->total()); ?> accounts</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th>Account No</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Parent</th>
                        <th>Additional Info</th>
                        <th>Status</th>
                        <th>Balance</th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox" value="<?php echo e($account->id); ?>">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td><?php echo e($account->account_no ?? '-'); ?></td>
                            <td class="text-gray-9"><?php echo e($account->title ?? '-'); ?></td>
                            <td>
                                <span class="badge bg-primary" ><?php echo e($account->accountType->title ?? 'N/A'); ?></span>
                            </td>
                            <td>
                                <?php echo e($account->parent ? $account->parent->title : '-'); ?>

                            </td>
                            <td>
                                <p>
                                    Belong To: <?php echo e($account->accountable_alias ?? '-'); ?> -
                                    <?php echo e($account->accountable->name ?? ($account->accountable->title ?? 'N/A')); ?>

                                </p>
                                <?php if($account->accountType && $account->accountType->title == 'Bank' && $account->bankAccount): ?>
                                    <p>
                                        Bank: <?php echo e($account->bankAccount->bank->bank_name ?? 'N/A'); ?><br>
                                        A/C No: <?php echo e($account->bankAccount->account_no ?? 'N/A'); ?><br>
                                        Holder: <?php echo e($account->bankAccount->account_name ?? 'N/A'); ?><br>
                                        Branch: <?php echo e($account->bankAccount->branch ?? 'N/A'); ?>

                                    </p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($account->status == 'ACTIVE'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary load-balance-btn"
                                    data-id="<?php echo e($account->id); ?>"
                                    data-url="<?php echo e(route('de-account.latest-balance', ['id' => $account->id])); ?>"
                                    id="balance-btn-<?php echo e($account->id); ?>">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2"
                                       href="<?php echo e(route('de-account.edit', $account)); ?>">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="p-2"
                                       href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#delete-account-modal"
                                       data-id="<?php echo e($account->id); ?>">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if (isset($component)) { $__componentOriginal1f9437379ffbb940ff05ba93353d3cd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.pagination','data' => ['paginator' => $accounts,'infoText' => 'accounts']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accounts),'info-text' => 'accounts']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5)): ?>
<?php $attributes = $__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5; ?>
<?php unset($__attributesOriginal1f9437379ffbb940ff05ba93353d3cd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f9437379ffbb940ff05ba93353d3cd5)): ?>
<?php $component = $__componentOriginal1f9437379ffbb940ff05ba93353d3cd5; ?>
<?php unset($__componentOriginal1f9437379ffbb940ff05ba93353d3cd5); ?>
<?php endif; ?>
    </div>
</div>
<!-- /account list -->
<?php echo $__env->make('de-accounting::accounts.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.load-balance-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;
                    const buttonEl = this;
                    const originalHTML = buttonEl.innerHTML;
                    const originalClass = buttonEl.className;

                    // Show loading state (primary outline)
                    buttonEl.className = 'btn btn-sm btn-outline-primary';
                    buttonEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                    buttonEl.disabled = true;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            // Success state (primary with balance)
                            buttonEl.className = 'btn btn-sm btn-primary';
                            buttonEl.innerHTML = `<i class="fa fa-eye"></i> ${data.balance}`;
                            buttonEl.disabled = false;
                        })
                        .catch(error => {
                            console.error(error);
                            // Error state (red)
                            buttonEl.className = 'btn btn-sm btn-danger';
                            buttonEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> Error';
                            
                            setTimeout(() => {
                                // Revert to original (primary outline)
                                buttonEl.className = originalClass;
                                buttonEl.innerHTML = originalHTML;
                                buttonEl.disabled = false;
                            }, 2000);
                        });
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/packages/Hilinkz/DEAccounting/src/../resources/views/accounts/index.blade.php ENDPATH**/ ?>