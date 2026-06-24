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
	<div><b><h1>Contractors List</h1></b></div>
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
				

					  
					  	@foreach($contractors as $contractor)
					  <tr>
					    <td>{{$contractor->name}}</td>
					    <td>{{$contractor->email}}</td>
					    <td>{{$contractor->phone}}</td>
					    <td>{{$contractor->state}}</td>
					    <td>{{$contractor->city}}</td>
					    <td>{{$contractor->address}}</td>
					    <td>{{$contractor->business_abn_can_number}}</td>
					    <td>{{$contractor->business_abn_can_expiration}}</td>
					    <td>{{$contractor->security_license_number}}</td>
					    <td>{{$contractor->security_license_expiration}}</td>
					    <td>{{$contractor->labour_hire_number}}</td>
					     <td>{{$contractor->labour_hire_expiration}}</td>

					      <td>{{$contractor->public_liability_number}}</td>

					       <td>{{$contractor->public_liability_expiration}}</td>
					    <td>{{$contractor->postal_code}}</td>

					  </tr>
					  @endforeach

					
					  	
					  
				</table>
			</div>
