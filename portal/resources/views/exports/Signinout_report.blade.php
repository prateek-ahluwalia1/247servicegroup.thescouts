
<table>
 <thead>
  <tr>
    <th style="text-align:center; background-color: #00B0F0; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">#</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Site Name</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">{{config('custom.guard')}} Name</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Start Time</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">End Time</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Signin Time</th>
    <th style="text-align:center; background-color: #00B050; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Signout Time</th>
 </tr>
</thead>
<tbody>
@foreach($data as $key => $d)

<tr>
	<td>{{($key+1)}}</td>
	<td>{{$d->site_name}}</td>
	<td>{{$d->guard_name}}</td>
	<td>{{date('m/d/Y H:i', strtotime($d->temp_start))}}</td>
	<td>{{date('m/d/Y H:i', strtotime($d->temp_end))}}</td>
	<td>{{$d->signin_time}}</td>
	<td>{{$d->signout_time}}</td>
</tr>

@endforeach

</tbody>
</table>