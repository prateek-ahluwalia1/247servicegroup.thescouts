<!-- <div style="float: left;height: 10%;width: 10%;">

<img alt="247" src="https://247staffingsolutions.com.au/assets/images/logo/logo.png"  />

</div>
 -->
<style type="text/css">
td{
	font-size: 9px;

}

</style>
 <center>
	<div><b><h1>customers List</h1></b></div>
</center>
<div></div>
</br>
</br>
</br>
</br>
</br>

	
<div class="">
				<table border="1px" style="width:40%">
					  	<tr>
						<td><b>Name</b></td>
					    <td><b>Email</b></td>
					    <td><b>Phone</b></td>
					    <td><b>State</b></td>
					    <td><b>City</b></td>
					    <td><b>Address</b></td>



					    <td><b>Bussiness ABN Number</b></td>
					    <td><b>Bussiness ABN Expiration</b></td>
					
					    <td><b>Security License Number</b></td>
					        <td><b>Security License Expiration</b></td>


<td><b>Labour Hire Number</b></td>

<td><b>Labour Hire Expiration</b></td>

<td><b>Public Liability Expiration</b></td>

<td><b>Public Liability Expiration</b></td>

					    <td><b>Postal Code</b></td>
					 
					  	</tr>
				

					  
					  	@foreach($customers as $customer)
					  <tr>
					    <td>{{$customer->name}}</td>
					    <td>{{$customer->email}}</td>
					    <td>{{$customer->phone}}</td>
					    <td>{{$customer->state}}</td>
					    <td>{{$customer->city}}</td>
					    <td>{{$customer->address}}</td>
					    <td>{{$customer->business_abn_can_number}}</td>
					    <td>{{$customer->business_abn_can_expiration}}</td>
					    <td>{{$customer->security_license_number}}</td>
					    <td>{{$customer->security_license_expiration}}</td>
					    <td>{{$customer->labour_hire_number}}</td>
					     <td>{{$customer->labour_hire_expiration}}</td>

					      <td>{{$customer->public_liability_number}}</td>

					       <td>{{$customer->public_liability_expiration}}</td>
					    <td>{{$customer->postal_code}}</td>

					  </tr>
					  @endforeach

					
					  	
					  
				</table>
			</div>
