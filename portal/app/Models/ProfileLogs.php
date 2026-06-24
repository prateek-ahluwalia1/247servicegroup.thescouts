<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileLogs extends Model
{
    protected $table = 'log_profile_changes';
    use HasFactory;

    function guardProfileLogs($request, $guardData)
    {
    	$change = '';
    	if(session()->get('userType') == 'administrator' || session()->get('userType') == 'admin'){
    		$admin = DB::table('administrators')->where('id', session()->get('userId'))->first();
    		$change .= $admin->name .' update ';
    	}
    	if ($request->has('first_name') && $request->first_name != $guardData->first_name) {
    		$change .= 'First name, ';
    	}
    	if ($request->has('last_name') && $request->last_name != $guardData->last_name) {
    		$change .= 'Last name, ';
    	}
    	if ($request->has('middle_name') && $request->middle_name != $guardData->middle_name) {
    		$change .= 'Middle name, ';
    	}
    	if ($request->has('guard_type') && $request->guard_type != $guardData->guard_type) {
    		$change .= 'Guard type, ';
    	}
    	if ($request->has('phone') && $request->phone != $guardData->phone) {
    		$change .= 'Phone, ';
    	}
    	if ($request->has('address') && $request->address != $guardData->address) {
    		$change .= 'Address, ';
    	}
    	if ($request->has('suburb') && $request->suburb != $guardData->suburb) {
    		$change .= 'Suburb, ';
    	}
    	if ($request->has('city') && $request->city != $guardData->city) {
    		$change .= 'City, ';
    	}
    	if ($request->has('state') && $request->state != $guardData->state) {
    		$change .= 'State, ';
    	}
    	if ($request->has('postalCode') && $request->postalCode != $guardData->postal_code) {
    		$change .= 'Postal code, ';
    	}
    	if ($request->has('dob') && $request->dob != $guardData->dob) {
    		$change .= 'DOB, ';
    	}
    	if ($request->has('gender') && $request->gender != $guardData->gender) {
    		$change .= 'Gender, ';
    	}
        if ($request->has('securityLicenseFileUploaded') && $request->securityLicenseFileUploaded != $guardData->security_license_file) {
            $change .= 'Security license front, ';
        }
        if ($request->has('security_license_number') && $request->security_license_number != $guardData->security_license_number) {
            $change .= 'Security license number, ';
        }
        if ($request->has('securityLicenseFileUploadedBack') && $request->securityLicenseFileUploadedBack != $guardData->security_license_file_back) {
            $change .= 'Security license back, ';
        }
        if ($request->has('payroll_tfn_number') && $request->payroll_tfn_number != $guardData->payroll_tfn_number) {
            $change .= 'Payroll tfn number, ';
        }
        if ($request->has('payroll_abn_number') && $request->payroll_abn_number != $guardData->payroll_abn_number) {
            $change .= 'Payroll abn number, ';
        }
        if ($request->has('payroll_superannutation') && $request->payroll_superannutation != $guardData->payroll_superannutation) {
            $change .= 'Payroll superannutation, ';
        }
        if ($request->has('payroll_superannutation_name') && $request->payroll_superannutation_name != $guardData->payroll_superannutation_name) {
            $change .= 'Payroll superannutation name, ';
        }
        if ($request->has('payroll_bank_name') && $request->payroll_bank_name != $guardData->payroll_bank_name) {
            $change .= 'Payroll bank name, ';
        }
        if ($request->has('payroll_bsb') && $request->payroll_bsb != $guardData->bsb) {
            $change .= 'Payroll bsb, ';
        }
        if ($request->has('payroll_bank_account_number') && $request->payroll_bank_account_number != $guardData->payroll_bank_account_number) {
            $change .= 'Payroll bank account number, ';
        }

    	$change .= ' of guard '. $guardData->name.'.';
    	DB::table('log_profile_changes')->insert([
    		'profile_id' => $guardData->id,
    		'type' => 'guard',
    		'action' => $change,
    		'datetime' => time()
    	]);

    	
    }

    function customerProfileLogs($request, $guardData)
    {
        $change = '';
        if(session()->get('userType') == 'administrator' || session()->get('userType') == 'admin'){
            $admin = DB::table('administrators')->where('id', session()->get('userId'))->first();
            $change .= $admin->name .' update ';
        }
        if ($request->has('name') && $request->name != $guardData->name) {
            $change .= 'Name, ';
        }
        
        if ($request->has('email') && $request->email != $guardData->email) {
            $change .= 'Email, ';
        }
        if ($request->has('phone') && $request->phone != $guardData->phone) {
            $change .= 'Phone, ';
        }
        if ($request->has('address') && $request->address != $guardData->address) {
            $change .= 'Address, ';
        }
        
        if ($request->has('city') && $request->city != $guardData->city) {
            $change .= 'City, ';
        }
        if ($request->has('state') && $request->state != $guardData->state) {
            $change .= 'State, ';
        }
        if ($request->has('postalCode') && $request->postalCode != $guardData->postal_code) {
            $change .= 'Postal code, ';
        }
       
        // if ($request->has('securityLicenseFileUploaded') && $request->securityLicenseFileUploaded != $guardData->security_license_file) {
        //     $change .= 'Security license front, ';
        // }
        // if ($request->has('securityLicenseFileUploadedBack') && $request->securityLicenseFileUploadedBack != $guardData->security_license_file_back) {
        //     $change .= 'Security license back, ';
        // }
        // if ($request->has('payroll_tfn_number') && $request->payroll_tfn_number != $guardData->payroll_tfn_number) {
        //     $change .= 'Payroll tfn number, ';
        // }
        // if ($request->has('payroll_abn_number') && $request->payroll_abn_number != $guardData->payroll_abn_number) {
        //     $change .= 'Payroll abn number, ';
        // }
        // if ($request->has('payroll_superannutation') && $request->payroll_superannutation != $guardData->payroll_superannutation) {
        //     $change .= 'Payroll superannutation, ';
        // }
        // if ($request->has('payroll_superannutation_name') && $request->payroll_superannutation_name != $guardData->payroll_superannutation_name) {
        //     $change .= 'Payroll superannutation name, ';
        // }
        // if ($request->has('payroll_bank_name') && $request->payroll_bank_name != $guardData->payroll_bank_name) {
        //     $change .= 'Payroll bank name, ';
        // }
        // if ($request->has('payroll_bsb') && $request->payroll_bsb != $guardData->payroll_bsb) {
        //     $change .= 'Payroll bsb, ';
        // }
        // if ($request->has('payroll_bank_account_number') && $request->payroll_bank_account_number != $guardData->payroll_bank_account_number) {
        //     $change .= 'Payroll bank account number, ';
        // }

        $change .= ' of customer '. $guardData->name.'.';
        DB::table('log_profile_changes')->insert([
            'profile_id' => $guardData->id,
            'type' => 'customer',
            'action' => $change,
            'datetime' => time()
        ]);
        
    }

    function contractorProfileLogs($request, $guardData)
    {
        $change = '';
        if(session()->get('userType') == 'administrator' || session()->get('userType') == 'admin'){
            $admin = DB::table('administrators')->where('id', session()->get('userId'))->first();
            $change .= $admin->name .' update ';
        }
        if ($request->has('name') && $request->name != $guardData->name) {
            $change .= 'Name, ';
        }
        
        if ($request->has('email') && $request->email != $guardData->email) {
            $change .= 'Email, ';
        }
        if ($request->has('phone') && $request->phone != $guardData->phone) {
            $change .= 'Phone, ';
        }
        if ($request->has('address') && $request->address != $guardData->address) {
            $change .= 'Address, ';
        }
        
        if ($request->has('city') && $request->city != $guardData->city) {
            $change .= 'City, ';
        }
        if ($request->has('state') && $request->state != $guardData->state) {
            $change .= 'State, ';
        }
        if ($request->has('postalCode') && $request->postalCode != $guardData->postal_code) {
            $change .= 'Postal code, ';
        }

        $change .= ' of contractor '. $guardData->name.'.';
        DB::table('log_profile_changes')->insert([
            'profile_id' => $guardData->id,
            'type' => 'contractor',
            'action' => $change,
            'datetime' => time()
        ]);
        
    }
}
