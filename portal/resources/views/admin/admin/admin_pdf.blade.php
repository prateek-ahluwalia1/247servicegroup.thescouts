<!-- <div style="float: left;height: 10%;width: 10%;">

<img alt="247" src="https://247staffingsolutions.com.au/assets/images/logo/logo.png"  />

</div>
 --><center>
	<div><b><h1>Administrator</h1></b></div>
</center>
<div></div>
</br>
</br>
</br>
</br>
</br>


<div class="table-responsive">
				<table border="2px" style="width:100%">
					  	<tr>
						<td><b>Name</b></td>
					    <td><b>Email</b></td>
					    <td><b>Phone</b></td>
					    <td><b>States</b></td>
					    <td><b>Super Admin</b></td>


					  	</tr>
				


					  	@foreach($admins as $admin)
					  <tr>

					  <?php 
					  if($admin->multiple_states!=null && $admin->multiple_states != '')
					  {
					  $multiple_states =json_decode($admin->multiple_states,true);

					  }
					else{
						  $multiple_states=[];
					}
				?>
					    <td>{{$admin->name}}</td>
					    <td>{{$admin->email}}</td>
					    <td>{{$admin->phone}}</td>
					    <td>
					    	@foreach($multiple_states as $a)
					    	{{$a}}
					    	@endforeach
					    </td>
					    @if($admin->is_super_admin == 1)
					    <td>Yes</td>
					    @else
					    <td>No</td>
					    @endif


					  </tr>
					  @endforeach

					
					  	
					  
				</table>
			</div>
