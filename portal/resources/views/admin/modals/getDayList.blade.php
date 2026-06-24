<div class="col-12">
  <select id="gMonth" name="gMonth" class="form-control">
    <option {{($month == '' ? 'selected' : '')}} value=''>--Select Month--</option>
    <option {{($month == '01' ? 'selected' : '')}} value='01/01/{{date("Y")}}'>Janaury</option>
    <option {{($month == '02' ? 'selected' : '')}} value='02/01/{{date("Y")}}'>February</option>
    <option {{($month == '03' ? 'selected' : '')}} value='03/01/{{date("Y")}}'>March</option>
    <option {{($month == '04' ? 'selected' : '')}} value='04/01/{{date("Y")}}'>April</option>
    <option {{($month == '05' ? 'selected' : '')}} value='05/01/{{date("Y")}}'>May</option>
    <option {{($month == '06' ? 'selected' : '')}} value='06/01/{{date("Y")}}'>June</option>
    <option {{($month == '07' ? 'selected' : '')}} value='07/01/{{date("Y")}}'>July</option>
    <option {{($month == '08' ? 'selected' : '')}} value='08/01/{{date("Y")}}'>August</option>
    <option {{($month == '09' ? 'selected' : '')}} value='09/01/{{date("Y")}}'>September</option>
    <option {{($month == '10' ? 'selected' : '')}} value='10/01/{{date("Y")}}'>October</option>
    <option {{($month == '11' ? 'selected' : '')}} value='11/01/{{date("Y")}}'>November</option>
    <option {{($month == '12' ? 'selected' : '')}} value='12/01/{{date("Y")}}'>December</option>
    </select> 
    </div> 
    <div class="col-12 mt-4">
        <span style="">
    <input class="myCheck" style="margin-left: 4px;" type="checkbox" value="1" name="without_guard" id="without_guard">
    <label>Without {{config('custom.guard')}}</label>
    </span>
    </div>
<input type="hidden" name="copyShiftEventId" id="copyShiftEventId" value="{{$event_id}}">
@for($i = 0; $i < $days; $i++)
<div class="col-2" style="margin-top: 20px;">
	<span style="">
	<input class="myCheck" style="margin-left: 4px;" type="checkbox" value="{{$monthStart}}" name="selected_days">
	<label>{{date('M d', $monthStart)}}</label>
	</span>
	
	<?php $monthStart = strtotime("+1 day", $monthStart); ?>
	<?php $monthStart = $monthStart; ?>
</div>
@endfor

<script type="text/javascript">
	$('#gMonth').on('change', function(){
        console.log('i am ')
        eventInfo=false;
        $.ajax({
        type: "POST",
        url: base_url + "/job/getDayList",
        data: {
            _token: token,
            event_id : $('#copyShiftEventId').val(),
            start: $(this).val()
        },
        success: function (result) {
            $('#active_day_list_div').html(result);
            
        }
       })
       })
</script>
