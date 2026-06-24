<?php if (isset($ids) && !empty($ids)) : ?>
    <?php foreach ($ids as $id): 
        if ($id->customer_id != '' && $id->customer_id != null) :
        ?>

        <div class="col-md-6 form-group _index">
            <div class="fv-row mb-10">
            <label class="col-form-label">Customer</label>
            <select class="form-select form-select-lg form-select-solid ac-customer-dropdown" data-control="select2" data-placeholder="Select..." data-allow-clear="true" id="customer-option-<?php echo $index; ?>" name="customer[<?php echo $index; ?>][customer_id]">
                <option value="">Select Customer</option>
                <?php foreach ($customers as $customer):  ?>
                    <option <?php echo ($customer->id == $id->customer_id) ? 'selected' : '' ?> value="<?php echo $customer['id'] ?>"><?php echo $customer->name ?></option>
                <?php 
            endforeach; ?>
            </select>
        </div>
    </div>
        <div class="col-md-6 form-group">
            <div class="fv-row mb-10">

            <label for="recipient-name" class="col-form-label">External ID</label>
            <input type="text" class="form-control form-control-md" value="<?php echo $id->external_id ?>" name="customer[<?php echo $index; ?>][external_id]">
        </div>
        </div>
    <?php 
$index++;
            endif;
            endforeach; ?>
<?php elseif (!isset($isloaded)): ?>
    <div class="col-md-6 form-group _index">
            <div class="fv-row mb-10">

        <label class="col-form-label">Customer</label>
        <select class="form-select form-select-lg form-select-solid ac-customer-dropdown" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="customer-option-<?php echo $index; ?>" name="customer[<?php echo $index; ?>][customer_id]">
            <option value="">Select Customer</option>
                <?php foreach ($customers as $customer):  ?>
                    <option value="<?php echo $customer['id'] ?>"><?php echo $customer->name ?></option>
                <?php  endforeach; ?>
        </select>
    </div>
    </div>
    <div class="col-md-6 form-group">
            <div class="fv-row mb-10">

        <label for="recipient-name" class="col-form-label">External ID</label>
        <input type="text" class="form-control form-control-md" name="customer[<?php echo $index; ?>][external_id]">
    </div>
    </div>
<?php endif; ?>