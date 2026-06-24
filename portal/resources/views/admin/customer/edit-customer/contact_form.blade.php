@if (isset($indexs) && !empty($indexs)) 
<input type="hidden" name="" id="_index" value="{{$indexs}}">
  

<div class="row">
    <div class="col-md-4 form-group">
        <label for="recipient-name" class="col-form-label">Name</label>
        <input type="text" class="form-control form-control-md" name="contact_name[<?php echo $indexs; ?>]">
    </div>
    <div class="col-md-4 form-group">
        <label for="recipient-name" class="col-form-label">Email</label>
        <input type="email" class="form-control form-control-md"  name="contact_email[<?php echo $indexs; ?>]">
    </div>
    <div class="col-md-4 form-group">
        <label for="recipient-name" class="col-form-label">Phone</label>
        <input type="phone" class="form-control form-control-md"  name="contact_phone[<?php echo $indexs; ?>]">
    </div>
</div>
<?php  $indexs++; ?>
@endif