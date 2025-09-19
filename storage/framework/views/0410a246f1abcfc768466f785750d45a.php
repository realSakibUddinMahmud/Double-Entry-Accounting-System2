
<form wire:submit.prevent="store">
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="alert alert-success">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php if(session()->has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php echo csrf_field(); ?>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>From <small class="text-muted">(Liabilities)</small></h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Account owner category *</label>
                                <select class="form-control"
                                    wire:change="changeSourceAccountableType($event.target.value)"
                                    wire:model="source_accountable_type" required>
                                    <option value="">Select an option</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item['class_id']); ?>"><?php echo e($item['alias']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Date *</label>
                                <input type="date" class="form-control" wire:model="date"
                                    value="<?php echo e(date('Y-m-d', strtotime(today()))); ?>"
                                    max="<?php echo e(date('Y-m-d', strtotime(today()))); ?>" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Account owner *</label>
                                <select class="form-control"
                                    wire:change="changeSourceAccountableId($event.target.value)"
                                    wire:model="source_accountable_id" required>
                                    <option value="">Select an option</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $source_accountable_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source_accountable_data_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($source_accountable_data_item->id); ?>">
                                            <?php echo e($source_accountable_data_item->name ?? $source_accountable_data_item->title); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Source Account *</label>
                                <select class="form-control" wire:model="source_account_id" required>
                                    <option value="">Select an account</option>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($sourceAccounts)): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sourceAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sourceAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sourceAccount->id); ?>">
                                                <?php echo e($sourceAccount->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Amount *</label>
                                <input type="text" class="form-control"
                                    wire:model="source_amount" required placeholder="Taka"
                                    pattern="^\d*(\.\d{0,2})?$"
                                    title="Please enter a valid number (e.g., 123.45)"
                                    wire:input="changeAmount($event.target.value)"
                                    oninput="validateInput(this);" maxlength="14">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Attachments <small class="text-muted">(jpg, jpeg, png, pdf)</small></label>
                                <input type="file" class="form-control"
                                    wire:model="attachments" multiple accept=".jpg,.jpeg,.png,.pdf">

                                <div wire:loading wire:target="attachments" class="text-info mt-2">
                                    Uploading files, please wait...
                                </div>

                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['attachments.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if($attachments): ?>
                                    <ul class="mt-2">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($file->getClientOriginalName()); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </ul>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>To <small class="text-muted">(Assets)</small></h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Destination *</label>
                                <select class="form-control" wire:model="destination_account_id" required>
                                    <option value="">Select an account</option>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($destinationAccounts)): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $destinationAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destinationAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($destinationAccount->id); ?>">
                                                <?php echo e($destinationAccount->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <input type="text" class="form-control"
                                    wire:model="destination_amount" required placeholder="Taka"
                                    pattern="^\d*(\.\d{0,2})?$" readonly
                                    value="<?php echo e($destination_amount); ?>">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Note</label>
                                <textarea class="form-control" wire:model.lazy="note" maxlength="500"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-end">
            <button 
                type="submit" 
                class="btn btn-primary" 
                id="submit"
                <?php echo e($disabled ? 'disabled' : ''); ?>

                wire:loading.attr="disabled"
                wire:target="attachments"
            >
                Submit
            </button>
        </div>
    </div>
</form>

<script>
    function validateInput(input) {
        // Remove any characters that are not digits or decimal points
        input.value = input.value.replace(/[^0-9.]/g, '');

        // Limit to two decimal places
        const parts = input.value.split('.');
        if (parts.length > 2) {
            input.value = parts[0] + '.' + parts.slice(1).join('');
        }
        if (parts[1] && parts[1].length > 2) {
            input.value = parts[0] + '.' + parts[1].slice(0, 2);
        }

        // Limit total length to 14 characters
        if (input.value.length > 14) {
            input.value = input.value.slice(0, 14);
        }
    }
</script><?php /**PATH /workspace/packages/Hilinkz/DEAccounting/src/../resources/views/livewire/security-deposit/create.blade.php ENDPATH**/ ?>