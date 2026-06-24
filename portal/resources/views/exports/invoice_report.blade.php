<table>
 <thead>
  <tr>
    <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">State</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Site Name</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Site Level</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Shift Level</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">{{config('custom.guard')}} Name</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">{{config('custom.guard')}} External ID</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">{{config('custom.guard')}} Phone</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Customer</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Schedule Start Date</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Schedule Start Time</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Schedule Finish Time</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Authorized Total Hours</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Actual Hours</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Day Hours</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Day Rates</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Night Hours</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Night Rates</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Saturday Hours</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Saturday  Rates</th>
   <!-- <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Saturday Night Hours</th> -->
   <!-- <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Saturday Night Rates</th> -->
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Sunday Hours</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Sunday Rates</th>
   <!-- <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Sunday Night Hours</th> -->
   <!-- <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Sunday Night Rates</th> -->
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Pub. Hol. Hours</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Pub. Hol. Rates</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Break Payable</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Break Deduction</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Travel Time Hours</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 50px;">Travel Time Pay</th>
   <th style="text-align:center; background-color: #A9D08E; border:1px solid #000000;font-size: 14px;width: 50px;">Total Amount</th>
  @if(config('custom.shift_po') == 1)
   <th style="text-align:center; background-color: #A9D08E; border:1px solid #000000;font-size: 14px;width: 50px;">P.O/W.O</th>
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 100px;">Site P.O/W.O</th>
   @endif
   <th style="text-align:center; background-color: #FFFF00;border:1px solid #000000; font-size: 14px;width: 100px;">Training</th>
   
 </tr>
</thead>
<tbody>
  <?php $site_name = '';
  $total_actual_hours = 0;
  $total_day_hours = 0;
  $total_night_hours = 0;
  $total_saturday_day_hours = 0;
  $total_saturday_night_hours = 0;
  $total_sunday_day_hours = 0;
  $total_sunday_night_hours = 0;
  $total_ph_hours = 0;
  $total_amount = 0;


  $tauh = 0;
  $tath = 0;
  $dh = 0;
  $nh = 0;
  $sadh = 0;
  $sanh = 0;
  $sudh = 0;
  $sunh = 0;
  $phh = 0;
  $ttamt = 0;

  ?>
 @foreach($data as $key => $val)
 <?php 
 $val['site_name'] = $val['site_name'] != '' ? $val['site_name'] : 'N/A';
  if ($site_name != '' && $site_name != $val['site_name']) {
    ?>
    <tr>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #EBF1DE; border:1px solid #000000; font-weight: bold;">{{number_format($total_actual_hours, 2)}}</td>
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000; font-weight: bold;">{{number_format($total_day_hours, 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #EBF1DE; border:1px solid #000000; font-weight: bold;">{{number_format($total_night_hours, 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000; font-weight: bold;">{{number_format(($total_saturday_day_hours + $total_saturday_night_hours), 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <!-- <td style="text-align:center; background-color: #EBF1DE; border:1px solid #000000; font-weight: bold;">{{number_format($total_saturday_night_hours, 2)}}</td> -->
  <!-- <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td> -->
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000; font-weight: bold;">{{number_format(($total_sunday_day_hours + $total_sunday_night_hours), 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <!-- <td style="text-align:center; background-color: #EBF1DE; border:1px solid #000000; font-weight: bold;">{{number_format($total_sunday_night_hours, 2)}}</td> -->
  <!-- <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td> -->
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000; font-weight: bold;">{{number_format($total_ph_hours, 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #BFBFBF; border:1px solid #000000; font-weight: bold;">${{number_format($total_amount, 2)}}</td>
  @if(config('custom.shift_po') == 1)
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
   @endif
  <td style="text-align:center; background-color: #808080; border:1px solid #000000; font-weight: bold;"></td>
</tr>
    <?php
  $total_actual_hours = 0;
  $total_day_hours = 0;
  $total_night_hours = 0;
  $total_saturday_day_hours = 0;
  $total_saturday_night_hours = 0;
  $total_sunday_day_hours = 0;
  $total_sunday_night_hours = 0;
  $total_ph_hours = 0;
  $total_amount = 0;
  }

 if(!empty($val['activity'])){
  $signin_time = $val['activity']->signin_time;
  $signin_time = str_replace('T', ' ', $signin_time);
  $signin_time = explode('+', $signin_time);
  $signin_time = $signin_time[0];
  $signout_time = $val['activity']->signout_time;
  $signout_time = str_replace('T', ' ', $signout_time);
  $signout_time = explode('+', $signout_time);
  $signout_time = $signout_time[0];
}else{
  $signin_time = 'N/A';
  $signout_time = 'N/A';
}
?>
<tr>
  <td style="text-align:center;border:1px solid #000000;">{{$val['state']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['site_name']}} ({{$val['site_description']}})</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['level']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['shift_level']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['guard_name'] != '' ? $val['guard_name'] : 'N/A'}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['external_id'] != '' ? $val['external_id'] : 'N/A'}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['phone']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['customer_name']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['temp_date']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['temp_start']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['temp_end']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['total_hours']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{ number_format(($val['total_hours'] + $val['travel_time'] - $val['payable_and_chargeable_time']/60), 2)}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{number_format($val['day_hours'], 2)}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['day_rate']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['night_hours']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['night_rate']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{($val['saturday_day_hours'] + $val['saturday_night_hours'])}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['saturday_day_rate']}}</td>
  <!-- <td style="text-align:center;border:1px solid #000000;">{{$val['saturday_night_hours']}}</td> -->
  <!-- <td style="text-align:center;border:1px solid #000000;">{{$val['saturday_night_rate']}}</td> -->
  <td style="text-align:center;border:1px solid #000000;">{{($val['sunday_day_hours'] + $val['sunday_night_hours'])}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['sunday_day_rate']}}</td>
  <!-- <td style="text-align:center;border:1px solid #000000;">{{$val['sunday_night_hours']}}</td> -->
  <!-- <td style="text-align:center;border:1px solid #000000;">{{$val['sunday_night_rate']}}</td> -->
  <td style="text-align:center;border:1px solid #000000;">{{($val['ph_day_hours'] + $val['ph_night_hours'])}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['ph_day_rate']}}</td>

  <td style="text-transform: capitalize;text-align:center;border:1px solid #000000;">{{$val['payable']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['payable_and_chargeable_time']/60}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{number_format($val['travel_time'], 2)}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['travel_time_pay']}}</td>
  <td style="text-align:center;border:1px solid #000000;background-color: #A9D08E; border:1px solid #000000;">${{$val['total_amount']}}</td>
  @if(config('custom.shift_po') == 1)
  <td style="text-align:center;border:1px solid #000000;">{{$val['pw_order']}}</td>
  <td style="text-align:center;border:1px solid #000000;">{{$val['site_pw_order']}}</td>
   @endif
  <td style="text-align:center;border:1px solid #000000;">{{$val['training']}}</td>
</tr>
<?php 
  $site_name = $val['site_name'] != '' ? $val['site_name'] : 'N/A';
  $total_actual_hours = $total_actual_hours + ($val['total_hours'] + $val['travel_time'] - $val['payable_and_chargeable_time']/60);
  $total_day_hours = $total_day_hours + $val['day_hours'];
  $total_night_hours = $total_night_hours + $val['night_hours'];
  $total_saturday_day_hours = $total_saturday_day_hours + $val['saturday_day_hours'];
  $total_saturday_night_hours = $total_saturday_night_hours + $val['saturday_night_hours'];
  $total_sunday_day_hours = $total_sunday_day_hours + $val['sunday_day_hours'];
  $total_sunday_night_hours = $total_sunday_night_hours + $val['sunday_night_hours'];
  $total_ph_hours = $total_ph_hours + $val['ph_day_hours'] + $val['ph_night_hours'];
  $total_amount = $total_amount + $val['total_amount'];



  $tauh += $val['total_hours'];
  $tath += ($val['total_hours'] + $val['travel_time'] - $val['payable_and_chargeable_time']/60);
  $dh += $val['day_hours'];
  $nh += $val['night_hours'];
  $sadh += $val['saturday_day_hours'];
  $sanh += $val['saturday_night_hours'];
  $sudh += $val['sunday_day_hours'];
  $sunh += $val['sunday_night_hours'];
  $phh += $val['ph_day_hours'] + $val['ph_night_hours'];
  $ttamt += $val['total_amount'];

  if ($key == count($data) - 1) {
    ?>
    <tr>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #EBF1DE; border:1px solid #000000;">{{number_format($total_actual_hours, 2)}}</td>
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000;">{{number_format($total_day_hours, 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #EBF1DE; border:1px solid #000000;">{{number_format($total_night_hours, 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000;">{{number_format(($total_saturday_day_hours + $total_saturday_night_hours), 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <!-- <td style="text-align:center; background-color: #EBF1DE; border:1px solid #000000;">{{number_format($total_saturday_night_hours, 2)}}</td> -->
  <!-- <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td> -->
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000;">{{number_format(($total_sunday_day_hours + $total_sunday_night_hours), 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <!-- <td style="text-align:center; background-color: #EBF1DE; border:1px solid #000000;">{{number_format($total_sunday_night_hours, 2)}}</td> -->
  <!-- <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td> -->
  <td style="text-align:center; background-color: #DCE6F1; border:1px solid #000000;">{{number_format($total_ph_hours, 2)}}</td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #BFBFBF; border:1px solid #000000;">${{number_format($total_amount, 2)}}</td>
  @if(config('custom.shift_po') == 1)
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
   @endif
  <td style="text-align:center; background-color: #808080; border:1px solid #000000;"></td>
</tr>
    <?php
  }
?>
@endforeach
 <tr>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:center; border:1px solid #000000;"></td>
  <td style="text-align:right; background-color: #8DB4E2; border:1px solid #000000;">{{number_format($tauh, 2)}}</td>
  <td style="text-align:right; background-color: #D8E4BC; border:1px solid #000000;">{{number_format($tath, 2)}}</td>
  <td style="text-align:right; background-color: #8DB4E2; border:1px solid #000000;">{{number_format($dh, 2)}}</td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <td style="text-align:right; background-color: #D8E4BC; border:1px solid #000000;">{{number_format($nh, 2)}}</td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <td style="text-align:right; background-color: #8DB4E2; border:1px solid #000000;">{{number_format(($sadh + $sanh), 2)}}</td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <!-- <td style="text-align:right; background-color: #D8E4BC; border:1px solid #000000;">{{number_format($sanh, 2)}}</td> -->
  <!-- <td style="text-align:right;border:1px solid #000000;"></td> -->
  <td style="text-align:right; background-color: #8DB4E2; border:1px solid #000000;">{{number_format(($sudh + $sunh), 2)}}</td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <!-- <td style="text-align:right; background-color: #D8E4BC; border:1px solid #000000;">{{number_format($sunh, 2)}}</td> -->
  <!-- <td style="text-align:right;border:1px solid #000000;"></td> -->
  <td style="text-align:right; background-color: #8DB4E2; border:1px solid #000000;">{{number_format($phh, 2)}}</td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <td style="text-align:right;border:1px solid #000000;"></td>
  <td style="text-align:right; background-color: #FFFF00; border:1px solid #000000;">${{number_format($ttamt, 2)}}</td>
  @if(config('custom.shift_po') == 1)
  <td style="text-align:right;border:1px solid #000000;"></td>
  <td style="text-align:right;border:1px solid #000000;"></td>
   @endif
  <td style="text-align:right;border:1px solid #000000;"></td>
</tr>

</tbody>

</table>