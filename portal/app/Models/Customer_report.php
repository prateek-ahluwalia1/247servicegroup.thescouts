<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Customer_report extends Model
{
    protected $table = 'job_new_roster';
    use HasFactory;

    public function get_search_record()
    {
       $results = DB::table('job_new_roster')
            ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
            ->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')
          //   ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
            ->join('customers', 'jobs.customer_id', '=', 'customers.id')
            ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
            // ->leftJoin('guard_ids', 'customers.id', '=', 'guard_ids.customer_id')
            ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
                 'jobs.customer_id',
            'jobs.contractor_id',
            'jobs.state',
            'jobs.stateType',
            'jobs.address',
            'jobs.details',
            'jobs.site_name',
            'jobs.site_description',
            'jobs.level',
            'jobs.payrol',
            'customers.name AS customer_name' ,
            'customers.address AS customer_address' ,
            'customers.email AS customer_email' ,
            'customers.phone AS customer_phone' ,
            'customers.charged_rates_id AS customer_charge_rate_id' ,
            'contractors.name  AS contractor_name',
            'guards.guard_type',
            'guards.name  AS guard_name' ,
            'guards.address AS guard_address' ,
            'guards.email AS guard_email' ,
            'guards.phone AS guard_phone' ,
            'guards.profile_image AS guard_image' ,
            // 'guard_ids.external_id',
            // 'guard_ids.internal_id',
            'customers.flat_metro_week_day',
            'customers.eba_metro_weekday_day'
        )->where('job_new_roster.chargeable', "yes");
            return $results;
    }
    public function get_records($status){
            $temp1 = DB::table('job_new_roster')
            ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
            ->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')
          //   ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
            ->leftJoin('customers', 'jobs.customer_id', '=', 'customers.id')
            ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
            ->leftJoin('guard_ids', 'customers.id', '=', 'guard_ids.customer_id')
            ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
                 'jobs.customer_id',
            'jobs.contractor_id',
            'jobs.state',
            'jobs.stateType',
            'jobs.address',
            'jobs.details',
            'jobs.site_name',
            'jobs.site_description',
            'jobs.level',
            'jobs.payrol',
            
            'customers.name AS customer_name' ,
            'customers.address AS customer_address' ,
            'customers.email AS customer_email' ,
            'customers.phone AS customer_phone' ,
            'customers.charged_rates_id AS customer_charge_rate_id' ,

            'contractors.name  AS contractor_name',
            'guards.guard_type',
            'guards.name  AS guard_name' ,
            'guards.address AS guard_address' ,
            'guards.email AS guard_email' ,
            'guards.phone AS guard_phone' ,
            'guards.profile_image AS guard_image' ,
            'guard_ids.external_id' ,
            'guard_ids.internal_id' ,



            'customers.flat_metro_week_day',
            'customers.eba_metro_weekday_day'


 );
            if (session()->has('specific_sites') && session()->get('specific_sites') != '') {
                $specific_sites = json_decode(session()->get('specific_sites'));
                $temp1->where(function($query)  use($specific_sites){
                    foreach ($specific_sites as $key => $id) {
                        if ($key == 0) {
                            $query->where('jobs.id', $id);
                        }else{
                            $query->orWhere('jobs.id', $id);
                        }
                    }
                });
            }
// 
             if (session()->has('specific_customer') && session()->get('specific_customer') != '') {
                $specific_customer = json_decode(session()->get('specific_customer'));
                $temp1->where(function($query)  use($specific_customer){
                    foreach ($specific_customer as $key => $id) {
                        if ($key == 0) {
                            $query->where('jobs.customer_id', $id);
                        }else{
                            $query->orWhere('jobs.customer_id', $id);
                        }
                    }
                });
            }
            // ->where('job_new_roster.chargeable', "yes")
            $results = $temp1->orderBy('job_new_roster.roster_id', 'desc')->take(50)->get();


            return $results;

    }

   
}
