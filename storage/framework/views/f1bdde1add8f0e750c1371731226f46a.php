
<form wire:submit.prevent="store">
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="alert alert-success">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php echo csrf_field(); ?>

    <div class="card">
        <div class="card-body row g-3">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="account_no" class="form-label">Account No (Optional)</label>
                    <input type="text" class="form-control" wire:model="account_no" placeholder="Ex: 10011">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['account_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger small"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Account Title *</label>
                    <input type="text" class="form-control" wire:model="title" placeholder="Ex: Roket, Nagad, DBBL" required>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger small"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Financial Type *</label>
                    <select class="form-control" wire:model="root_type" required>
                        <option value="">----- Select Option -----</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rootTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rootType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($rootType['id']); ?>"><?php echo e($rootType['name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Account Type</label>
                    <select class="form-control"
                        wire:change="changeAccountType($event.target.value)"
                        wire:model="account_type_id">
                        <option value="">----- Select Option -----</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($accountType->id); ?>"><?php echo e($accountType->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <!--[if BLOCK]><![endif]--><?php if($this->selected_account_type == 'Bank'): ?>
                    <div class="form-group mb-3">
                        <label class="form-label">A/C Holder Name *</label>
                        <input type="text" class="form-control" wire:model="ac_holder_name" placeholder="Enter bank name">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Bank A/C No *</label>
                        <input type="text" class="form-control" wire:model="bank_ac_no" placeholder="Enter bank a/c no">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Bank Name *</label>
                        <select class="form-control" wire:model="bank_id" required>
                            <option value="">----- Select Option -----</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->bank_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Branch *</label>
                        <input type="text" class="form-control" wire:model="branch" placeholder="Enter branch name" required>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Account For *</label>
                    <select class="form-control"
                        wire:change="changeAccountableType($event.target.value)"
                        wire:model="accountable_type" required>
                        <option value="">----- Select Option -----</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item['class_id']); ?>"><?php echo e($item['alias']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Belong To *</label>
                    <select multiple="multiple" class="form-control" wire:model="accountable_id" required>
                        <option value="">----- Select Option -----</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountable_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountable_data_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($accountable_data_item->id); ?>">
                                <?php echo e($accountable_data_item->name ?? $accountable_data_item->title); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Parent Account</label>
                    <select class="form-control" wire:model="parent_title">
                        <option value="">----- Select Option -----</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($accountTitle); ?>"><?php echo e($accountTitle); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary" id="submit">Submit</button>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('logToConsole', function(data) {
            console.log('Livewire Debug Info:', data);
        });
    });
</script><?php /**PATH /workspace/packages/Hilinkz/DEAccounting/src/../resources/views/livewire/account/create.blade.php ENDPATH**/ ?>