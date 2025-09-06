
<form method="GET" class="row align-items-end g-2 mb-3">
    <div class="col-md-2">
        <label class="form-label" for="receivable">Belong To</label>
        <select class="form-control form-control-sm"
                wire:model="accountable_type"
                wire:change="changeAccountableType($event.target.value)"
                name="accountable_type">
            <option value="">Select an option</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item['class_id']); ?>">
                    <?php echo e($item['alias']); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($selected_accountable_type_alias): ?>
        <div class="col-md-3">
            <label class="form-label">Select <?php echo e($selected_accountable_type_alias); ?></label>
            <select class="form-control form-control-sm"
                    wire:model="accountable_id"
                    name="accountable_id">
                <option value="">Select an option</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountable_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountable_data_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountable_data_item->id); ?>">
                        <?php echo e($accountable_data_item->name ?? $accountable_data_item->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="col-md-2">
        <label class="form-label" for="accountable_types">Account Type</label>
        <select class="form-control form-control-sm"
                wire:model="account_type_id"
                name="account_type_id">
            <option value="">Select an option</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type->id); ?>">
                    <?php echo e($type->title); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="accountable_types">Account No / Title</label>
        <input type="text" class="form-control form-control-sm" name="title_ac_no" wire:model="title_ac_no" placeholder="Search by Title or Account No...">
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-sm w-100" onclick="myPreloader()">
            <i class="ti ti-search me-1"></i>Search
        </button>
    </div>
</form><?php /**PATH /workspace/packages/Hilinkz/DEAccounting/src/../resources/views/livewire/component/account-search.blade.php ENDPATH**/ ?>