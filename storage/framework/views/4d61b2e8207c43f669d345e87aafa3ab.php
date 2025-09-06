<!-- Add Unit Modal -->
<div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo e(route('units.store')); ?>" method="POST" id="createUnitForm">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Add Unit</h4>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Unit Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Symbol <span class="text-muted">(optional)</span></label>
                        <input type="text" name="symbol" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Base Unit</label>
                        <select name="parent_id" class="form-control" id="add_unit_parent_id">
                            <option value="">-- None --</option>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Conversion Factor</label>
                        <input type="number" step="0.01" name="conversion_factor" class="form-control" placeholder="e.g. 1, 0.01">
                        <div class="form-text">
                            How many of base unit equals this unit?<br>
                            <div class="alert alert-info py-2 px-3 my-2" style="font-weight:bold;">
                                <span class="text-primary">
                                    <strong>Explanation:</strong>
                                    1 <span id="example_unit_name">[Unit]</span> = 
                                    <span id="example_conversion_factor">X</span> 
                                    <span id="example_base_unit">[Base Unit]</span>
                                </span>
                            </div>
                            <span class="text-success" style="font-weight:bold;">
                                <strong>Example:</strong> 1 Dozen = 12 Piece
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Unit Modal -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitNameInput = document.querySelector('input[name="name"]');
    const baseUnitSelect = document.getElementById('add_unit_parent_id');
    const conversionFactorInput = document.querySelector('input[name="conversion_factor"]');
    const exampleUnitName = document.getElementById('example_unit_name');
    const exampleBaseUnit = document.getElementById('example_base_unit');
    const exampleConversionFactor = document.getElementById('example_conversion_factor');

    function updateExample() {
        exampleUnitName.textContent = unitNameInput.value || '[Unit]';
        exampleBaseUnit.textContent = baseUnitSelect.options[baseUnitSelect.selectedIndex].text !== '-- None --'
            ? baseUnitSelect.options[baseUnitSelect.selectedIndex].text
            : '[Base Unit]';
        let val = conversionFactorInput.value;
        if (val && !isNaN(val)) {
            exampleConversionFactor.textContent = parseFloat(val).toFixed(2);
        } else {
            exampleConversionFactor.textContent = 'X';
        }
    }

    unitNameInput.addEventListener('input', updateExample);
    baseUnitSelect.addEventListener('change', updateExample);
    conversionFactorInput.addEventListener('input', updateExample);
});
</script><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/admin/unit/create-modal.blade.php ENDPATH**/ ?>