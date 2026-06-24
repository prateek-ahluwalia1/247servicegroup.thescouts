<?php if (isset($ids) && !empty($ids)) : ?>
    <?php foreach ($ids as $id): 
        ?>

        <div class="col-md-6 form-group _index_payroll">
            <div class="fv-row mb-10">
            <label class="col-form-label">Type</label>
            <select class="form-select form-select-lg form-select-solid ac-payroll-dropdown" data-control="select2" data-placeholder="Select..." data-allow-clear="true" id="payroll-option-<?php echo $index; ?>" name="payroll[<?php echo $index; ?>][payroll_id_type]">
                <!-- <option value="">Select payroll</option> -->
                @if($id->type == 'direct')
                <option <?php echo ($id->type == 'direct') ? 'selected' : '' ?> value="direct">Direct</option>
                @endif
                @if($id->type == 'contractor')

                <option <?php echo ($id->type == 'contractor') ? 'selected' : '' ?> value="contractor">Contractor</option>
                @endif

            </select>
        </div>
    </div>
        <div class="col-md-6 form-group">
            <div class="fv-row mb-10">

            <label for="recipient-name" class="col-form-label">Payroll ID</label>
            <input type="text" class="form-control form-control-md" value="<?php echo $id->payroll_id ?>" name="payroll[<?php echo $index; ?>][payroll_id]" readonly>
        </div>
        </div>
    <?php 
$index++;
            endforeach; ?>
<?php elseif (!isset($isloaded)): ?>
    <div class="col-md-6 form-group _index_payroll">
            <div class="fv-row mb-10">

        <label class="col-form-label">Type</label>
        {{-- <select class="form-select form-select-lg form-select-solid ac-payroll-dropdown payroll_dropdown" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="payroll-option-<?php echo $index; ?>" name="payroll[<?php echo $index; ?>][payroll_id_type]" onchange="getpayrollId(<?php echo $index; ?>)"> --}}

        <select class="form-select form-select-lg form-select-solid" id="payroll-option" name="payroll[<?php echo $index; ?>][payroll_id_type]" >
            <option value="direct">Direct</option>
            <option value="contractor">Contractor</option>
               
        </select>
    </div>
    </div>
    <div class="col-md-6 form-group">
            <div class="fv-row mb-10">

        <label for="recipient-name" class="col-form-label">Payroll ID</label>
        <input type="text" class="form-control form-control-md" id="payroll-id" name="payroll[<?php echo $index; ?>][payroll_id]" readonly>
    </div>
    </div>
<?php endif; ?>