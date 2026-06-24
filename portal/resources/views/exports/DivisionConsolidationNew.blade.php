
<table>
 <thead>
  <tr>
    <th style="text-align:center; background-color: #00B0F0; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Customer</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Site Name</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Total Hours</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Total Charge</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Total Pay</th>
    <th style="text-align:center; background-color: #808080; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Expense</th>
    <th style="text-align:center; background-color: #00B050; font-weight:bold; border:1px solid #000000; font-size: 14px;width: 200px;">Total Profit</th>
 </tr>
</thead>
<tbody>
<?php 
	$customer_name = '';
?>
@foreach($data as $key => $d)
@if($customer_name != '' && $customer_name != $d['customer_name'])
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<?php $customer_name = ''; ?>
@endif
<tr>
	<td>{{($customer_name == '' ? $d['customer_name'] : '')}}</td>
	<td>{{$d['site_name']}}</td>
	<td>{{$d['hours_pay']}}</td>
	<td>${{number_format($d['total_amount_charge'], 2)}}</td>
	<td>${{number_format($d['total_amount_pay'], 2)}}</td>
	<td>${{$d['expense']}}</td>
	<td>${{number_format(($d['total_amount_charge'] - $d['total_amount_pay'] - $d['expense']), 2)}}</td>
</tr>
<?php 
$customer_name = $d['customer_name']; ?>

@endforeach
</tbody>
</table>