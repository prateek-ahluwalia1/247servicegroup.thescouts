
<table>
 <thead>
  <tr>
    <th style="text-align:center; background-color: #00B0F0; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Division</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Clients</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;"></th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Hours</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Rates</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Gross Output</th>
    <th style="text-align:center; background-color: #00B050; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Total output</th>
   
 </tr>
</thead>
<tbody>
@foreach($data as $key1 => $d)
   <?php 
   $gross_output = 0;
   $total_output = 0;
   $customer_name = '';
   ?>
 @foreach($d['data'] as $key => $val)
 <?php 
 $division = $d['division'];
 $division->rate = 0;
 if ($val->payrol == 'Default Rates') {
        foreach ($val->normal_rate as $key1 => $nr) {
            if ($nr['id'] == $division->id) {
                $division->rate = $nr['rate'];
            }
        }
     // $division->rate = $val->normal_rate;
 }else{
    foreach ($val->eba_rate as $key1 => $er) {
            if ($er['id'] == $division->id) {
                $division->rate = $er['rate'];
            }
        }
     // $division->rate = $val->eba_rate;
 }
 ?>
 <tr>
    <td style="text-align:center;">{{$key1 + 1}}</td>
    <td style="text-align:center;">{{$val->name}}</td>
    <td style="text-align:center;">{{$val->site_name}}</td>
    <td style="text-align:center;">{{number_format($val->total_hours, 2)}}</td>
    <td style="text-align:center;">{{number_format($division->rate, 2)}}</td>
    <td style="text-align:center;font-weight: bold;font-size: 14px;">${{$val->total_hours * $division->rate}}</td>
    <td style="text-align:center;"></td>
 </tr>
 <?php 
 
 $gross_output += $val->total_hours * $division->rate;
 $total_output += $val->total_hours * $division->rate;
 if ($customer_name != $val->name || $key+1 == count($data)) {
    ?>
    <tr>
    <td style="text-align:center;background-color: #808080; border:1px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:1px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:1px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:1px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:1px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:2px solid #000000; font-weight: bold;font-size: 14px; color: #ffffff;">${{number_format($gross_output, 2)}}</td>
    <td style="text-align:center;background-color: #808080; border:1px solid #000000;"></td>
 </tr>
    <?php
    $gross_output = 0;
 }
 ?>
 @endforeach
 <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
 </tr>
 <tr>
    <td style="text-align:center;background-color: #808080; border:2px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:2px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:2px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:2px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:2px solid #000000;"></td>
    <td style="text-align:center;background-color: #808080; border:2px solid #00B050;font-weight: bold;font-size: 14px;">Total output</td>
    <td style="text-align:center;background-color: #808080; border:2px solid #00B050;font-weight: bold;font-size: 14px; color: #ffffff;">{{number_format($total_output, 2)}}</td>
 </tr>
 <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
 </tr>
<?php 
    if ((count($data) > 1 || $key1 > 0) && $key1 < count($data) -1) {
        ?>
        <tr>
    <td style="text-align:center; background-color: #00B0F0; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Division</td>
    <td style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Clients</td>
    <td style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;"></td>
    <td style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Hours</td>
    <td style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Rates</td>
    <td style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Gross Output</td>
    <td style="text-align:center; background-color: #00B050; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 20px;">Total output</td>
   
 </tr>
        <?php 
    }
?>

@endforeach
</tbody>

</table>

