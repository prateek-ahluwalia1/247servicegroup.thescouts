style="display:{{isset($site_data) && $site_data->custom_payrate == 1 ? 'none' : '' }};"

@if(isset($settings['custom_payrates']) && $settings['custom_payrates'] == 1)
    <div class="form-check form-check-custom form-check-solid me-10">
        <input class="form-check-input h-30px w-30px" type="checkbox" value="1" id="custom_payrate" name="custom_payrate"  {{isset($site_data) && $site_data->custom_payrate == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="custom_payrate">
            Custom Payrate
        </label>
    </div>
    <div class="own_chargerate_div" style="display:{{isset($site_data) && $site_data->custom_chargerate == 1 ? '' : 'none' }};">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="rTable">
                            <div class="rTableBody">
                                <div class="rTableRow">
                                    <div class="rTableHead text-center">Metro</div>
                                    <div class="rTableHead">&nbsp;</div>
                                    <div class="rTableHead text-center">Regional</div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input class="form-control form-control-md" name="charge_rate_flat_metro_week_day_day" type="number" step="any" value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_week_day_day']) ? $site_data->custom_charge_rate['flat_metro_week_day_day'] : '0' }}">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_week_day_day']) ? $site_data->custom_charge_rate['flat_regional_week_day_day'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_week_day_day" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_week_day_night']) ? $site_data->custom_charge_rate['flat_metro_week_day_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_week_day_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_week_day_night']) ? $site_data->custom_charge_rate['flat_regional_week_day_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_week_day_night" type="number" step="any">
                                    </div>
                                </div>  
                                <div class="rTableRow" style="display: none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_friday']) ? $site_data->custom_charge_rate['flat_metro_friday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_friday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_friday']) ? $site_data->custom_charge_rate['flat_regional_friday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_friday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_saturday']) ? $site_data->custom_charge_rate['flat_metro_saturday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_saturday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday (Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_saturday']) ? $site_data->custom_charge_rate['flat_regional_saturday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_saturday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_saturday_night']) ? $site_data->custom_charge_rate['flat_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_saturday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_saturday_night']) ? $site_data->custom_charge_rate['flat_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_saturday_night" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_sunday']) ? $site_data->custom_charge_rate['flat_metro_sunday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_sunday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday (Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_sunday']) ? $site_data->custom_charge_rate['flat_regional_sunday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_sunday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_sunday_night']) ? $site_data->custom_charge_rate['flat_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_sunday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_sunday_night']) ? $site_data->custom_charge_rate['flat_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_sunday_night" type="number" step="any">
                                    </div>
                                </div>

                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_public_holiday']) ? $site_data->custom_charge_rate['flat_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_public_holiday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday (Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_public_holiday']) ? $site_data->custom_charge_rate['flat_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_public_holiday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_public_holiday_night']) ? $site_data->custom_charge_rate['flat_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_public_holiday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_public_holiday_night']) ? $site_data->custom_charge_rate['flat_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_public_holiday_night" type="number" step="any">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    @endif