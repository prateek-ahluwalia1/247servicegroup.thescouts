<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    use HasFactory;

    function customerSites($customerID)
    {
    	$sites = DB::table('jobs')
    	->join('customers', 'customers.id', '=', 'jobs.customer_id')
    	->where('jobs.customer_id', $customerID)
    	->where('jobs.status', 'active')
    	->select('jobs.id as siteId', 'jobs.site_name', 'jobs.site_description', 'jobs.state', 'jobs.stateType', 'jobs.level', 'jobs.payrol', 'customers.charged_rates_id', 'customers.state as customer_state', 'customers.name')->get();

    	return $sites;
    }

    function dataBySite($siteId, $from, $to)
    {
    	$rosterData = DB::table('job_new_roster')
    	->leftJoin('guards', 'guards.id', '=', 'job_new_roster.guard_id')
    	->where('job_new_roster.site_id', $siteId)
    	// ->where('job_new_roster.job_status', 'completed')
		//by hussain
    	->where('job_new_roster.temp_start', '>=', date('Y-m-d', $from))
    	->where('job_new_roster.temp_start', '<=',date('Y-m-d', $to))
    	->select('job_new_roster.*', 'guards.name as guard_name')
    	->get();
    	return $rosterData;
    }
}
