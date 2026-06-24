<?php if (isset($site_trained) && !empty($site_trained)) : ?>
    <?php foreach ($site_trained as $trained): ?>
<div class="row training-section _site-train-index">
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid _ac-site-trainsed-customer-change" multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" data-index="<?php echo $index;?>" id="site_trained_customer-option-<?php echo $index; ?>" name="site_trained[<?php echo $index; ?>][customer_id]">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                <option <?php echo ($customer->id == $trained->customer_id) ? 'selected' : '' ?> value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="site_trained[<?php echo $index; ?>][site_id]" id="site_trained_site-option-<?php echo $index; ?>" >
                <option value="1">Please select</option>
                <?php foreach ($trained->sites as $site): ?>
                    <option <?php echo ($site->site_id == $trained->site_id) ? 'selected' : '' ?> value="{{ $site->site_id }}">{{ $site->site_name }}</option>

            <?php  endforeach; ?>

            </select>
        </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="site_trained[<?php echo $index; ?>][status]">
                <option <?php echo ('completed' == $trained->status) ? 'selected' : '' ?> value="completed">Completed</option>
                <option <?php echo ('notcompleted' == $trained->status) ? 'selected' : '' ?> value="notcompleted">Not Completed</option>
            </select>
        </div>
        </div>
    </div>
    <?php 
    $index++;
            endforeach; ?>
            <?php elseif (!isset($isloaded)): ?>
                <div class="row training-section _site-train-index">
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid _ac-site-trainsed-customer-change" multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" data-index="<?php echo $index;?>" id="site_trained_customer-option-<?php echo $index; ?>" name="site_trained[<?php echo $index; ?>][customer_id]">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="site_trained[<?php echo $index; ?>][site_id]" id="site_trained_site-option-<?php echo $index; ?>" >
                <option value="1">Please select</option>
            </select>
        </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="site_trained[<?php echo $index; ?>][status]">
                <option value="completed">Completed</option>
                <option value="notcompleted">Not Completed</option>
            </select>
        </div>
        </div>
    </div>
<?php endif; ?>



    