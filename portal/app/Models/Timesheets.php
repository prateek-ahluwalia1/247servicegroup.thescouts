<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Timesheets extends Model
{
	protected $table = 'job_new_roster';
    use HasFactory;


    public function get_search_record()
    {
       $results= DB::table('job_new_roster')
            ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
            ->leftJoin('guards', 'job_new_roster.guard_id', '=', 'guards.id')
            ->leftJoin('guard_payroll_ids', 'guards.id', '=', 'guard_payroll_ids.guard_id')

            ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
            ->join('customers', 'jobs.customer_id', '=', 'customers.id')
            ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
            // ->leftJoin('guard_ids', 'customers.id', '=', 'guard_ids.customer_id')
            ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
                 'jobs.customer_id',
            'jobs.contractor_id',
            'jobs.state',
            'jobs.site_name',
            'jobs.site_description',
            'jobs.stateType',
            'jobs.address',
            'jobs.details',
            'jobs.level',
            'customers.name AS customer_name' ,
            'contractors.name  AS contractor_name',
            'guards.guard_type',
            'guards.name  AS guard_name' ,
            'guards.email  AS guard_email' ,
            'guards.phone  AS guard_phone' ,
            // 'guard_ids.external_id',
            'customers.flat_metro_week_day',
            'job_roster_activities.signin_time',
            'job_roster_activities.signout_time',
            'guard_payroll_ids.payroll_id AS guard_payroll_id' 

        );
            return $results;
    }
    public function get_records(){
       $results= DB::table('job_new_roster')
            ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
            ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
            ->leftJoin('guards', 'job_new_roster.guard_id', '=', 'guards.id')
            ->leftJoin('guard_payroll_ids', 'guards.id', '=', 'guard_payroll_ids.guard_id')
            ->join('customers', 'jobs.customer_id', '=', 'customers.id')
            ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
            // ->join('guard_ids', 'customers.id', '=', 'guard_ids.customer_id')
            ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
                 'jobs.customer_id',
            'jobs.contractor_id',
            'jobs.state',
            'jobs.site_name',
            'jobs.site_description',
            'jobs.stateType',
            'jobs.address',
            'jobs.details',
            'jobs.level',
            'customers.name AS customer_name' ,
            'contractors.name  AS contractor_name',
            'guards.guard_type',
            'guards.name  AS guard_name' ,
            'guards.email  AS guard_email' ,
            'guards.phone  AS guard_phone' ,
            'customers.flat_metro_week_day',
            'job_roster_activities.signin_time',
            'job_roster_activities.signout_time',
            'guard_payroll_ids.payroll_id AS guard_payroll_id' 

        )->where('job_new_roster.job_status' ,'completed')->orderBy('job_new_roster.roster_id', 'desc')->take(50)->get();
    // $results = DB::select(
    //     "SELECT
    //     jr.*,
    //     j.`id` AS job_id,
    //     j.`booking_id`,
    //     j.`customer_id`,
    //     j.`contractor_id`,
    //     j.`state`,
    //     j.`stateType`,
    //     j.`address`,
    //     j.`site_name`,
    //     j.`site_description`,
    //     j.`break`,
    //     j.`payable`,
    //     j.`chargeable`,
    //     cust.`name` AS customer_name,
    //     c.`name` AS contractor_name,
    //     g.`guard_type`,
    //     g.`phone` AS guard_phone,
    //     g.`id` AS guard_id,
    //     g.`email` AS guard_email,
    //     g.`address` AS guard_address,
    //     g.`profile_image` AS guard_image,
    //     g.`name` AS guard_name,
    //     ad.`name` AS admin_name,
    //     jsa.`signin_time`,
    //     j.`details`,
    //     j.`level`,
    //     jsa.`signout_time`
    //     FROM job_new_roster AS jr
    //     INNER JOIN jobs AS j ON j.`id` = jr.`site_id`
    //     LEFT JOIN job_roster_activities AS jsa ON jsa.`job_roster_id` = jr.`roster_id`
    //     LEFT JOIN `guards` AS g ON g.`id` = jr.`guard_id`
    //     LEFT JOIN customers AS cust ON j.`customer_id` = cust.`id`
    //     LEFT JOIN `contractors` AS c ON j.`contractor_id`= c.`id`
    //     LEFT JOIN `administrators` AS ad ON jr.`status_change_by` = ad.`id`
    //    ");
    //    ->where('job_new_roster.job_status' ,'completed')->orderBy('job_new_roster.roster_id', 'desc')->take(50)->get();
            return $results;

    }

}
