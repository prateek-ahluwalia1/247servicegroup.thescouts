{{-- @dd($guard_files); --}}
<table id="customers" >
    <thead style="background-color: white;" >
        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-">Name</th>
            @if($vaccination == 'on')
            <th class="min-w-">Vaccination</th>
            @endif
            @if($visa == 'on')
            <th class="min-w- visa">Visa</th>
            @endif
            @if($induction == 'on')
            <th class="min-w-">Induction</th>
            @endif
            @if($working_children == 'on')
            <th class="min-w-">Working with Children</th>
            @endif
            @if($passport == 'on')
            <th class="min-w-">Passport</th>
            @endif
            @if($citizenship == 'on')
            <th class="min-w-">Citizenship</th>
            @endif
            @if($driver_license == 'on')
            <th class="min-w-">Driver License</th>
            @endif
            @if($firstaid == 'on')
            <th class="min-w-">Firstaid</th>
            @endif
            @if($medicare == 'on')
            <th class="min-w-">Medicare</th>
            @endif
            @if($security_license == 'on')
            <th class="min-w-">Security License</th>
            @endif
            @if($police_check == 'on')
            <th class="min-w-">Police check</th>
            @endif
            @if($birth_certificate == 'on')
            <th class="min-w-">Birth Certificate</th>
            @endif
            </tr>
    </thead>
    <tbody id="guard_data">
        @foreach($guard as $item)
        <tr>
    <td><a href="https://vcpgsystem.com.au/guard_profile/{{$item->id}}" target="_blank">{{$item->name}}</a></td>
    
    @if($vaccination == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->vaccination_certificate}}" target="_blank">{{$item->vaccination_certificate}}</a></td>
    @endif
    
    @if($visa == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->visa_file}}" target="_blank">{{$item->visa_file}}</a></td>
    @endif
    
    @if($induction == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->visa_file}}" target="_blank">{{$item->visa_file}}</a></td>
    @endif
    
    @if($working_children == 'on')
    <td>
        @foreach($guard_files as $val)
            @if($val->guard_id == $item->id)
            <a href="https://vcpgsystem.com.au/asset_uploads/{{$val->file_path}}" target="_blank">{{$val->file_path}}</a><br>
            @endif
        @endforeach
    </td>
    @endif
    
    @if($passport == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->passport_file}}" target="_blank">{{$item->passport_file}}</a></td>
    @endif
    
    @if($citizenship == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->citizenship_file}}" target="_blank">{{$item->citizenship_file}}</a></td>
    @endif
    
    @if($driver_license == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->driver_license_file}}" target="_blank">{{$item->driver_license_file}}</a></td>
    @endif
    
    @if($firstaid == 'on')
    <td>{{$item->firstaid_license_file}}</td>
    @endif
    
    @if($medicare == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->medicare_file}}" target="_blank">{{$item->medicare_file}}</a></td>
    @endif
    
    @if($security_license == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->security_license_file}}" target="_blank">{{$item->security_license_file}}</a></td>
    @endif
    
    @if($police_check == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->security_license_file}}" target="_blank">{{$item->security_license_file}}</a></td>
    @endif
    
    @if($birth_certificate == 'on')
    <td><a href="https://vcpgsystem.com.au/asset_uploads/{{$item->birthcertificate_file}}" target="_blank">{{$item->birthcertificate_file}}</a></td>
    @endif
</tr>

        @endforeach
    </tbody>
</table>
