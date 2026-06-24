
<table>
 <thead>
  <tr>
    <th style="text-align:center; background-color: #00B0F0; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">#</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Site Name</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">{{config('custom.guard')}} Name</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Date</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Start Time</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">End Time</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Signin Time</th>
    <th style="text-align:center; background-color: #00B050; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Signout Time</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Green Call 1</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Green Call 2</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Welfare Care</th>
 </tr>
</thead>
<tbody>
@foreach($data as $key => $d)

<tr>
	<td>{{($key+1)}}</td>
	<td>{{$d->site_name}}</td>
	<td>{{$d->Guards->name}}</td>
  <td>{{date('m/d/Y', strtotime($d->temp_start))}}</td>
	<td>{{date('H:i', strtotime($d->temp_start))}}</td>
	<td>{{date('H:i', strtotime($d->temp_end))}}</td>
	<td>{{!empty($d->activity) ? date('H:i', strtotime($d->activity->signin_time)) : 'N/A'}}</td>
  <td>{{!empty($d->activity) ? date('H:i', strtotime($d->activity->signout_time)) : 'N/A'}}</td>
  <td>{{(!empty($d->GreenCall) && isset($d->GreenCall[1]) ? date('H:i', strtotime($d->GreenCall[1]->created_at)) : 'N/A')}}</td>
  <td>{{(!empty($d->GreenCall) && isset($d->GreenCall[0]) ? date('H:i', strtotime($d->GreenCall[0]->created_at)) : 'N/A')}}</td>
  <td>{{(!empty($d->WelfareCall) && isset($d->WelfareCall[0]) ? date('H:i', strtotime($d->WelfareCall[0]->created_at)) : 'N/A')}}</td>
</tr>

@endforeach

</tbody>
</table>