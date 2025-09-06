<form id="searchForm" method="GET" class="row" target="_self">
    <div class="col-sm-2">
        <label>From</label>
        <input type="text" class="form-control form-control-sm datepicker" name="start_date"
            value="<?php echo e(request('start_date') ?? date('d-m-Y', strtotime(today()))); ?>" data-date-format="dd-mm-yy"
            max="<?php echo e(date('d-m-Y', strtotime(today()))); ?>">
    </div>
    <div class="col-sm-2">
        <label>To</label>
        <input type="text" class="form-control form-control-sm datepicker" name="end_date"
            value="<?php echo e(request('end_date') ?? date('d-m-Y', strtotime(today()))); ?>" data-date-format="dd-mm-yy"
            max="<?php echo e(date('d-m-Y', strtotime(today()))); ?>">
    </div>

    <div class="col-sm-2">
        <label for="receivable">Belong To</label>
        <select class="form-control form-control-sm" wire:model="accountable_type"
            wire:change="changeAccountableType($event.target.value)" name="accountable_type">
            <option value="">Select an option</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item['class_id']); ?>">
                    <?php echo e($item['alias']); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($selected_accountable_type_alias): ?>
        <div class="col-sm-4">
            <label>Select <?php echo e($selected_accountable_type_alias); ?></label>
            <select class="form-control form-control-sm" wire:model="accountable_id" name="accountable_id">
                <option value="">Select an option</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountable_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountable_data_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountable_data_item->id); ?>">
                        <?php echo e($accountable_data_item->name ?? $accountable_data_item->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="col-sm-2 d-flex-sm">
        <label>&nbsp;</label><br>
        <button type="submit" id="viewBtn"
            class="btn btn-primary btn-md d-inline-flex align-items-center">View</button>
        <button type="submit" id="pdfBtn" class="btn btn-dark btn-md d-inline-flex align-items-center"
            name="download" value="YES">PDF</button>
    </div>
</form>
<?php $__env->startPush('scripts'); ?>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI (with datepicker) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize datepickers with proper dd/mm/yyyy format
            $('.datepicker').datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                maxDate: new Date() // Restrict to today or earlier
            });

            // Ensure Livewire doesn't break the datepickers
            Livewire.hook('message.processed', () => {
                $('.datepicker').datepicker('refresh');
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /workspace/Double-Entry-Accounting-System/packages/Hilinkz/DEAccounting/src/../resources/views/livewire/component/journal-search.blade.php ENDPATH**/ ?>