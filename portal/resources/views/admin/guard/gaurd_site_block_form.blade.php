<?php if (isset($sites_blocked) && !empty($sites_blocked)) : ?>
    <?php foreach ($sites_blocked as $trained): ?>

<div class="row training-section _site-block-index">
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid _ac-site-block-customer-change" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" data-index="<?php echo $index; ?>" id="site_blocked_customer-option-<?php echo $index; ?>" name="site_blocked[<?php echo $index; ?>][customer_id]">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                <option <?php echo ($customer->id == $trained->customer_id) ? 'selected' : '' ?> value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
                
            </select>
        </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="site_blocked[<?php echo $index; ?>][site_id]" id="site_blocked_site-option-<?php echo $index; ?>" >
                <option value="">Please select</option>
                <?php foreach ($trained->sites as $site): ?>
                    <option <?php echo ($site->site_id == $trained->site_id) ? 'selected' : '' ?> value="{{ $site->site_id }}">{{ $site->site_name }}</option>

            <?php  endforeach; ?>
            </select>
        </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="site_blocked[<?php echo $index; ?>][status]">
                <option <?php echo ('Block' == $trained->status) ? 'selected' : '' ?> value="Block">Block</option>
                <option  <?php echo ('unBlock' == $trained->status) ? 'selected' : '' ?> value="unBlock">UnBlock</option>
            </select>
            </select>
        </div>
    </div>
    <?php $index++;
            endforeach; ?>
            <?php elseif (!isset($isloaded)): ?>

<div class="row training-section _site-block-index">
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid _ac-site-block-customer-change" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" data-index="<?php echo $index; ?>" id="site_blocked_customer-option-<?php echo $index; ?>" name="site_blocked[<?php echo $index; ?>][customer_id]">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
                
            </select>
        </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="site_blocked[<?php echo $index; ?>][site_id]" id="site_blocked_site-option-<?php echo $index; ?>" >
                <option value="1">Please select</option>
            </select>
        </div>
        </div>
        <div class="col-md-4 form-group">
            <div class="fv-row mb-10">
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="site_blocked[<?php echo $index; ?>][status]">
                <option value="Block">Block</option>
                <option value="unBlock">UnBlock</option>
            </select>
            </select>
        </div>
    </div>

<?php endif; ?>
