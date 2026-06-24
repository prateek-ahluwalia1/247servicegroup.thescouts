@for($i = 0; $i < 13; $i+=4)
<div style="margin-top: 20px;">
	@for($j = 0; $j < 4; $j++)
	<?php $start = strtotime("+7 day", $start); ?>
	<span style="margin-left: {{$j > 0 ? '53px' : '0px';}};">
	<input class="myCheck" style="margin-left: 4px;" type="checkbox" value="{{$start}} - {{$start + (60*60*24*7-1)}}" name="selected_weeks">
	<label>{{date('M d', $start + 1)}} - {{date('d', $start + (60*60*24*7-1))}}</label>
	</span>
	
	@endfor
	<?php $start = $start; ?>
</div>
@endfor

